<?php

namespace App\Http\Controllers\Applicant;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Traits\CommonHelperTrait;
use App\Traits\ReturnFormatTrait;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use DB;
use Exception;

use Illuminate\Support\Facades\Auth;


class ApplicantController extends Controller
{
    use ReturnFormatTrait;
    use CommonHelperTrait;

    private function generateOTP()
    {
        return random_int(10000, 99999);
    }

    protected function ShareOtpMail($email, $otp)
    {
        if (empty($email)) {
            \Log::error("Acknowledgement email not sent: missing recipient email.");
            return;
        }

        Mail::send('email.email_otp', compact('email', 'otp'), function ($msg) use ($email) {
            $msg->to($email);
            // $msg->cc('yesitlabs.rahulkumarphp@gmail.com');
            $msg->subject('OTP Email');
        });
    }


    public function register()
    {
        $data['title'] = ___('applicant.applicant_registration');
        return view('applicant.register', compact('data'));
    }

    public function forgot_password()
    {
        $data['title'] = ___('applicant.applicant_forgot_password');
        return view('applicant.forgot-password', compact('data'));
    }

    public function send_otp(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $email = $request->email;

        $user = User::where('email', $email)->first();

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'No account found with this email.'], 404);
        }

        $otp = $this->generateOTP();

        // store email + otp in session
        session()->put('email', $email);
        session()->put('otp', $otp);

        // send otp mail
        $this->ShareOtpMail($email, $otp);

        return response()->json(['status' => 'success', 'message' => 'OTP sent successfully. Please check your email.']);
    }

    public function resend_otp(Request $request)
    {
        $email = session()->get('email');

        $user = User::where('email', $email)->first();

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'User not found.'], 404);
        }

        $otp = $this->generateOTP();

        // store otp in session
        session()->put('otp', $otp);

        // send otp mail
        $this->ShareOtpMail($email, $otp);

        return response()->json(['status' => 'success', 'message' => 'OTP resent successfully. Please check your email.']);
    }

    public function verify_otp(Request $request)
    {
        return view('applicant.verify-otp');
    }

    public function otp_verification(Request $request)
    {
        $request->validate([
            'otp' => 'required'
        ]);

        // Merge the array into one OTP string
        $enteredOtp = implode('', $request->otp);

        $email = session()->get('email');
        $otp = session()->get('otp');
        #echo $otp;die;
        #$otp = "50475";
        if ($enteredOtp == $otp) {
            $user = User::where('email', $email)->first();

            if (!$user) {
                return redirect()->back()->withErrors(['email' => 'User not found.']);
            }

            $user->reset_password_otp = $otp;
            $user->save();

            session()->forget('otp');

            return redirect()->route('applicant-update-password');
        }

        // If OTP does not match
        return redirect()->back()->withErrors(['otp' => 'Invalid OTP. Please try again.']);
    }

    public function applicant_update_password(Request $request)
    {
        return view('applicant.update-password');
    }

    public function login()
    {
        $data['title'] = ___('applicant.applicant_registration');
        return view('applicant.login', compact('data'));
    }
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $role                    = Role::find(8);
            $user                    = new User();
            $user->name              = $request->first_name . ' ' . $request->last_name;
            $user->email             = $request->email  != "" ? $request->email :  NULL;
            $user->phone             = $request->mobile != "" ? $request->mobile :  NULL;
            $user->admission_no      = $request->admission_no != "" ? $request->admission_no :  NULL;
            $user->password          = $request->password_type == 'default' ? Hash::make('123456') : Hash::make($request->password);
            $user->email_verified_at = now();
            $user->role_id           = $role->id;
            $user->permissions       = $role->permissions;
            $user->date_of_birth     = $request->date_of_birth;
            $user->username          = $request->username;
            $user->uuid              = Str::uuid();
            $user->save();

            $applicantId = DB::table('applicants')->insertGetId([
                'custom_id'               => $request->id,
                'last_name'               => $request->last_name,
                'first_name'              => $request->first_name,
                'high_school'             => $request->high_school,
                'date_of_birth'           => $request->date_of_birth,
                'usa_cell'                => $request->mobile,
                'email'                   => $request->email,
                'highschool(application)' => $request->high_school_application,
                'created_at'              => now(),
                'updated_at'              => now(),
            ]);

            DB::commit();
            return $this->responseWithSuccess(___('alert.created_successfully'), []);
        } catch (\Throwable $th) {
            DB::rollback();
            dd($th);
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }
    public function process()
    {
        $data['title'] = ___('applicant.application_process');
        return view('applicant.process', compact('data'));
    }
    public function application()
    {
        $data['title'] = ___('applicant.application_application');
        $data['countries'] = DB::table('countries')->get();
        $data['states'] = DB::table('states')->get();
        $data['cities'] = DB::table('cities')->limit(50)->get();
        $data['applicant'] = DB::table('applicants')->where('user_id', auth()->user()->id)->first();
        if (!empty($data['applicant'])) {
            $data['applicant_parents'] = DB::table('applicant_parents')->where('applicant_id', $data['applicant']->id)->first();
            $data['aplicant_history'] = DB::table('aplicant_history')->where('applicant_id', $data['applicant']->id)->first();

            $data['aplicant_confirmation'] = DB::table('aplicant_confirmation')->where('applicant_id', $data['applicant']->id)->first();
            $data['upload'] =  $data['applicant']->profile;
        } else {
            $data['applicant_parents'] = null;
            $data['aplicant_history'] = null;
            $data['aplicant_confirmation'] = null;
            $data['upload'] = null;
        }

        return view('applicant.application', compact('data'));
    }
    public function applicationFormDraft(Request $request)
    {
        try {
            // dd($request->all());
            DB::beginTransaction();
            $upload = null;
            if ($request->hasFile('upload') && $request->file('upload')->isValid()) {
                $file = $request->file('upload');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('applicant'), $filename);
                $upload = 'applicant/' . $filename;
            }
            $applicant = [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'hebrew_name' => $request->hebrew_name,
                'hebrew_first_name' => $request->hebrew_first_name,
                'custom_id' => substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 6),
                'prefered_name' => $request->prefered_name,
                'date_of_birth' => $request->filled('dob') ? $request->dob : null,
                'hdob' => $request->filled('hdob') ? $request->hdob : null,
                'birth_place' => $request->birth_place,
                'zip' => $request->zip,
                'usa_cell' => $request->usa_cell,
                'cell' => $request->cell,
                'country' => $request->country,
                'state' => $request->state,
                'city' => $request->city,
                'address' => $request->address,
                'email' => $request->email,
                'is_draft' => 0,
                'interview_city' => $request->interview_city,
            ];
            if (!is_null($upload)) {
                $applicant['profile'] = $upload;
            }
            DB::table('applicants')->updateOrInsert(
                ['user_id' => auth()->user()->id],
                $applicant

            );
            // get applicant id
            $applicant = DB::table('applicants')->where('user_id', auth()->user()->id)->first();

            // update or insert parent info
            DB::table('applicant_parents')->updateOrInsert(
                ['applicant_id' => $applicant->id],
                [
                    "marital_status" => $request->maritalStatus,
                    "siblings" => $request->sibling,
                ]
            );

            $school_name = null;
            $grades = null;
            $about = null;
            $question = null;
            $attendance_upload = null;
            $transcript_upload = null;
            $recommendation_upload = null;
            $relation_name = null;
            $relation_address = null;
            $relation_phone = null;
            $relation_relationship = null;

            if ($request->filled('school_name')) {
                $school_name = json_encode($request->school_name);
            }

            if ($request->filled('grades')) {
                $grades = json_encode($request->grades);
            }

            if ($request->filled('relation_name')) {
                $relation_name = json_encode($request->relation_name);
            }

            if ($request->filled('relation_address')) {
                $relation_address = json_encode($request->relation_address);
            }

            if ($request->filled('relation_phone')) {
                $relation_phone = json_encode($request->relation_phone);
            }

            if ($request->filled('relation_relationship')) {
                $relation_relationship = json_encode($request->relation_relationship);
            }

            if ($request->hasFile('about') && $request->file('about')->isValid()) {
                $file = $request->file('about');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('pdf'), $filename);
                $about = 'pdf/' . $filename;
            }


            if ($request->hasFile('question') && $request->file('question')->isValid()) {
                $file = $request->file('question');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('pdf'), $filename);
                $question = 'pdf/' . $filename;
            }
            if ($request->hasFile('attendance_upload') && $request->file('attendance_upload')->isValid()) {
                $file = $request->file('attendance_upload');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('pdf'), $filename);
                $attendance_upload = 'pdf/' . $filename;
            }
            if ($request->hasFile('transcript_upload') && $request->file('transcript_upload')->isValid()) {
                $file = $request->file('transcript_upload');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('pdf'), $filename);
                $transcript_upload = 'pdf/' . $filename;
            }
            if ($request->hasFile('recommendation_upload') && $request->file('recommendation_upload')->isValid()) {
                $file = $request->file('recommendation_upload');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('pdf'), $filename);
                $recommendation_upload = 'pdf/' . $filename;
            }

            $updateData = [
                "school" => $request->school,
                "school_tel" => $request->s_tel,
                "grade" => $request->grade,
                "advisor_name" => $request->advisor_name,
                "home" => $request->home,
                "home_cell" => $request->home_cell,
                "email_address" => $request->email_address,
                "school_name" => $school_name,
                "school_grades" => $grades,
                "modified" => $request->modified,
                "surgery" => $request->surgery,
                "medication" => $request->medication,
                "allergies" => $request->allergies,
                "relation_name" => $relation_name,
                "relation_address" => $relation_address,
                "relation_phone" => $relation_phone,
                "relation_relationship" => $relation_relationship,
            ];

            // Add only non-null fields for these specific values
            if (!is_null($about)) {
                $updateData["about"] = $about;
            }
            if (!is_null($question)) {
                $updateData["question"] = $question;
            }
            if (!is_null($attendance_upload)) {
                $updateData["attendance_upload"] = $attendance_upload;
            }
            if (!is_null($transcript_upload)) {
                $updateData["transcript_upload"] = $transcript_upload;
            }
            if (!is_null($recommendation_upload)) {
                $updateData["recommendation_upload"] = $recommendation_upload;
            }

            // Perform update or insert
            DB::table('aplicant_history')->updateOrInsert(
                ['applicant_id' => $applicant->id],
                $updateData
            );
            $applicant_signature = null;
            $guardian_signature = null;
            if ($request->filled('guardian_signature') && strpos($request->guardian_signature, 'data:image') === 0) {
                $image_parts = explode(";base64,", $request->guardian_signature);
                $image_base64 = base64_decode($image_parts[1]);
                $fileName = 'guardian_signature_' . time() . '.png';
                $filePath = public_path('signatures/' . $fileName);

                if (!file_exists(public_path('signatures'))) {
                    mkdir(public_path('signatures'), 0777, true);
                }

                file_put_contents($filePath, $image_base64);
                $guardian_signature = 'signatures/' . $fileName;
            }


            // Handle parent signature
            if ($request->filled('applicant_signature') && strpos($request->applicant_signature, 'data:image') === 0) {
                $image_parts = explode(";base64,", $request->applicant_signature);
                $image_base64 = base64_decode($image_parts[1]);
                $fileName = 'applicant_signature_' . time() . '.png';
                $filePath = public_path('signatures/' . $fileName);

                if (!file_exists(public_path('signatures'))) {
                    mkdir(public_path('signatures'), 0777, true);
                }

                file_put_contents($filePath, $image_base64);
                $applicant_signature = 'signatures/' . $fileName;
            }

            if ($request->agree) {
                $agree = 1;
            } else {
                $agree = 0;
            }
            $data =   [
                "parent_email" => $request->parent_email,
                "confirm_applicant" => $request->confirm_applicant,
                "applicant_date" => $request->applicant_date,
                "guardian_name" => $request->guardian_name,
                "gaurdian_date" => $request->gaurdian_date,
                "agree" => $agree,
                "billing_email" => $request->billing_email,
                "billing_address" => $request->billing_address,
                "billing_state" => $request->billing_state,
                "billing_city" => $request->billing_city,
                "billing_zip" => $request->billing_zip,
                "billing_country" => $request->billing_country,
                "billing_card" => $request->billing_card,
                "security_code" => $request->security_code,
                "card_holder_name" =>  $request->card_holder_name,
                'exp_date' => $request->exp_date,
            ];
            if (!is_null($applicant_signature)) {
                $data['applicant_signature'] = $applicant_signature;
            }
            if (!is_null($guardian_signature)) {
                $data['guardian_signature'] = $guardian_signature;
            }
            DB::table('aplicant_confirmation')->updateOrInsert(
                ['applicant_id' => $applicant->id],
                $data
            );
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => __('alert.draft_saved_successfully'),
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
            return response()->json([
                'success' => false,
                'message' => __('alert.failed_to_save_draft'),
            ]);
        }
    }

    public function applicationFormSave(Request $request)
    {
        try {
            // dd($request->all());
            DB::beginTransaction();
            $upload = null;
            if ($request->hasFile('upload') && $request->file('upload')->isValid()) {
                $file = $request->file('upload');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('applicant'), $filename);
                $upload = 'applicant/' . $filename;
            }
            $applicant = [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'hebrew_name' => $request->hebrew_name,
                'hebrew_first_name' => $request->hebrew_first_name,
                'custom_id' => substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 6),
                'prefered_name' => $request->prefered_name,
                'date_of_birth' => $request->filled('dob') ? $request->dob : null,
                'hdob' => $request->filled('hdob') ? $request->hdob : null,
                'birth_place' => $request->birth_place,
                'zip' => $request->zip,
                'usa_cell' => $request->usa_cell,
                'cell' => $request->cell,
                'country' => $request->country,
                'state' => $request->state,
                'city' => $request->city,
                'address' => $request->address,
                'email' => $request->email,
                'is_draft' => 0,
                'interview_city' => $request->interview_city,
            ];
            if (!is_null($upload)) {
                $applicant['profile'] = $upload;
            }
            DB::table('applicants')->updateOrInsert(
                ['user_id' => auth()->user()->id],
                $applicant

            );

            // get applicant id
            $applicant = DB::table('applicants')->where('user_id', auth()->user()->id)->first();

            // update or insert parent info
            DB::table('applicant_parents')->updateOrInsert(
                ['applicant_id' => $applicant->id],
                [
                    "marital_status" => $request->maritalStatus,
                    "siblings" => $request->sibling,
                ]
            );

            $school_name = null;
            $grades = null;
            $about = null;
            $question = null;
            $attendance_upload = null;
            $transcript_upload = null;
            $recommendation_upload = null;
            $relation_name = null;
            $relation_address = null;
            $relation_phone = null;
            $relation_relationship = null;

            if ($request->filled('school_name')) {
                $school_name = json_encode($request->school_name);
            }

            if ($request->filled('grades')) {
                $grades = json_encode($request->grades);
            }

            if ($request->filled('relation_name')) {
                $relation_name = json_encode($request->relation_name);
            }

            if ($request->filled('relation_address')) {
                $relation_address = json_encode($request->relation_address);
            }

            if ($request->filled('relation_phone')) {
                $relation_phone = json_encode($request->relation_phone);
            }

            if ($request->filled('relation_relationship')) {
                $relation_relationship = json_encode($request->relation_relationship);
            }

            if ($request->hasFile('about') && $request->file('about')->isValid()) {
                $file = $request->file('about');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('pdf'), $filename);
                $about = 'pdf/' . $filename;
            }

            // Insert or update upload record

            if ($request->hasFile('question') && $request->file('question')->isValid()) {
                $file = $request->file('question');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('pdf'), $filename);
                $question = 'pdf/' . $filename;
            }
            if ($request->hasFile('attendance_upload') && $request->file('attendance_upload')->isValid()) {
                $file = $request->file('attendance_upload');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('pdf'), $filename);
                $attendance_upload = 'pdf/' . $filename;
            }
            if ($request->hasFile('transcript_upload') && $request->file('transcript_upload')->isValid()) {
                $file = $request->file('transcript_upload');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('pdf'), $filename);
                $transcript_upload = 'pdf/' . $filename;
            }
            if ($request->hasFile('recommendation_upload') && $request->file('recommendation_upload')->isValid()) {
                $file = $request->file('recommendation_upload');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('pdf'), $filename);
                $recommendation_upload = 'pdf/' . $filename;
            }

            $updateData = [
                "school" => $request->school,
                "school_tel" => $request->s_tel,
                "grade" => $request->grade,
                "advisor_name" => $request->advisor_name,
                "home" => $request->home,
                "home_cell" => $request->home_cell,
                "email_address" => $request->email_address,
                "school_name" => $school_name,
                "school_grades" => $grades,
                "modified" => $request->modified,
                "surgery" => $request->surgery,
                "medication" => $request->medication,
                "allergies" => $request->allergies,
                "relation_name" => $relation_name,
                "relation_address" => $relation_address,
                "relation_phone" => $relation_phone,
                "relation_relationship" => $relation_relationship,
            ];

            // Add only non-null fields for these specific values
            if (!is_null($about)) {
                $updateData["about"] = $about;
            }
            if (!is_null($question)) {
                $updateData["question"] = $question;
            }
            if (!is_null($attendance_upload)) {
                $updateData["attendance_upload"] = $attendance_upload;
            }
            if (!is_null($transcript_upload)) {
                $updateData["transcript_upload"] = $transcript_upload;
            }
            if (!is_null($recommendation_upload)) {
                $updateData["recommendation_upload"] = $recommendation_upload;
            }

            // Perform update or insert
            DB::table('aplicant_history')->updateOrInsert(
                ['applicant_id' => $applicant->id],
                $updateData
            );
            $applicant_signature = null;
            $guardian_signature = null;
            if ($request->filled('guardian_signature') && strpos($request->guardian_signature, 'data:image') === 0) {
                $image_parts = explode(";base64,", $request->guardian_signature);
                $image_base64 = base64_decode($image_parts[1]);
                $fileName = 'guardian_signature_' . time() . '.png';
                $filePath = public_path('signatures/' . $fileName);

                if (!file_exists(public_path('signatures'))) {
                    mkdir(public_path('signatures'), 0777, true);
                }

                file_put_contents($filePath, $image_base64);
                $guardian_signature = 'signatures/' . $fileName;
            }


            // Handle parent signature
            if ($request->filled('applicant_signature') && strpos($request->applicant_signature, 'data:image') === 0) {
                $image_parts = explode(";base64,", $request->applicant_signature);
                $image_base64 = base64_decode($image_parts[1]);
                $fileName = 'applicant_signature_' . time() . '.png';
                $filePath = public_path('signatures/' . $fileName);

                if (!file_exists(public_path('signatures'))) {
                    mkdir(public_path('signatures'), 0777, true);
                }

                file_put_contents($filePath, $image_base64);
                $applicant_signature = 'signatures/' . $fileName;
            }

            if ($request->agree) {
                $agree = 1;
            } else {
                $agree = 0;
            }
            $data =   [
                "parent_email" => $request->parent_email,
                "confirm_applicant" => $request->confirm_applicant,
                "applicant_date" => $request->applicant_date,
                "guardian_name" => $request->guardian_name,
                "gaurdian_date" => $request->gaurdian_date,
                "agree" => $agree,
                "billing_email" => $request->billing_email,
                "billing_address" => $request->billing_address,
                "billing_state" => $request->billing_state,
                "billing_city" => $request->billing_city,
                "billing_zip" => $request->billing_zip,
                "billing_country" => $request->billing_country,
                "billing_card" => $request->billing_card,
                "security_code" => $request->security_code,
                "card_holder_name" =>  $request->card_holder_name,
                'exp_date' => $request->exp_date,
            ];
            if (!is_null($applicant_signature)) {
                $data['applicant_signature'] = $applicant_signature;
            }
            if (!is_null($guardian_signature)) {
                $data['guardian_signature'] = $guardian_signature;
            }
            DB::table('aplicant_confirmation')->updateOrInsert(
                ['applicant_id' => $applicant->id],
                $data
            );
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => __('alert.draft_saved_successfully'),
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
            return response()->json([
                'success' => false,
                'message' => __('alert.failed_to_save_draft'),
            ]);
        }
    }

    public function interview()
    {
        $data['title'] = ___('applicant.interview_interview');
        $applicant = DB::table('applicants')->where('user_id', auth()->user()->id)->first()->id;
        $data['interviews'] = DB::table('interview_processing')->where('applicant_id', $applicant)->where('status', 1)->where('interview_status', 1)->first();
        return view('applicant.interview', compact('data'));
    }
    public function registration()
    {
        $data['title'] = ___('applicant.registration_registration');
        return view('applicant.registration', compact('data'));
    }
    public function agreement()
    {
        $data['title'] = ___('applicant.agreement_agreement');
        return view('applicant.agreement', compact('data'));
    }



    public function applicantProfile()
    {
        $userId = Auth::id();

        $data = DB::table('users')
            ->leftjoin('applicants', 'users.id', '=', 'applicants.user_id')
            ->select(
                'users.id as user_id',
                'users.name as user_name',
                'users.email',
                'users.role_id',
                'applicants.*'
            )
            ->where('users.id', $userId)
            // ->where('applicants.is_draft', 0)
            ->first();

        if (!$data) {
            return redirect()->back()->withErrors(['error' => 'Applicant not found.']);
        }
        // dd($data);
        return view('applicant.profile', compact('data'));
    }
}
