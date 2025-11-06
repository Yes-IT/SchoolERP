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
use Illuminate\Support\Facades\Http;

use Illuminate\Support\Facades\Auth;


class ApplicantbhanuController extends Controller
{
    use ReturnFormatTrait;
    use CommonHelperTrait;


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
        } else {
            $data['applicant_parents'] = null;
            $data['aplicant_history'] = null;
            $data['aplicant_confirmation'] = null;
        }
        

        // $xKey = "yesitlabsdev1df38974369f4214a7ddc170f8a03727";

        // // 📦 Prepare request payload
        // $data = [
        //     "xKey" => $xKey,
        //     "xVersion" => "5.0.0",
        //     "xSoftwareName" => "LaravelApp",
        //     "xSoftwareVersion" => "1.0",
        //     "xCommand" => "cc:sale",
        //     "xAmount" => '10.00',
        //     "xInvoice" => "INV-" . time(),
        //     "xCardNum" => "4111111111111111",
        //     "xExp" => "1228", // MMYY
        //     "xCVV" => "123",
        //     "xName" => "Test User",
        //     "xEmail" => "test@example.com",
        //     "xBillStreet" => "123 Test Street",
        //     "xBillZip" => "12345",
        //     "xAllowDuplicate" => "true",
        // ];

        // try {
        //     // 🚀 Send request to gateway
        //     $response = Http::asForm()->timeout(45)->post('https://x1.cardknox.com/gateway', $data);

        //     // 🔍 Check HTTP status
        //     if ($response->failed()) {
        //         return response()->json([
        //             'status' => 'error',
        //             'message' => 'Payment gateway request failed.',
        //             'details' => $response->body(),
        //         ], 500);
        //     }

        //     // 🧾 Parse the query-style response (xKey format)
        //     parse_str($response->body(), $result);

        //     return response()->json([
        //         'status' => $result['xStatus'] ?? 'Unknown',
        //         'message' => $result['xError'] ?? 'Payment processed successfully',
        //         'transaction_id' => $result['xRefNum'] ?? null,
        //         'raw_response' => $result,
        //     ]);

        // } catch (\Exception $e) {
        //     return response()->json([
        //         'status' => 'error',
        //         'message' => 'Exception: ' . $e->getMessage(),
        //     ], 500);
        // }

        return view('applicant.application-bhanu', compact('data'));
    }

    public function applicationFormSave(Request $request)
    {
        try {
            #print_r($request->all());die;
            DB::beginTransaction();

            // Applicant insert or update
            DB::table('applicants')->updateOrInsert(
                ['user_id' => auth()->user()->id],
                [
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
                ]
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
