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
use DB;

class ApplicantController extends Controller
{
    use ReturnFormatTrait;
    use CommonHelperTrait;
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

            if ($request->has('camps') && $request->has('positions')) {
                $camps = $request->camps;
                $positions = $request->positions;
                foreach ($camps as $index => $camp) {
                    if (empty($positions[$index])) continue;
                    DB::table('applicant_camps')->insert([
                        'applicant_id'  => $applicantId,
                        'camp'         => $camp,
                        'position'     => $positions[$index],
                        'created_at'   => now(),
                        'updated_at'   => now(),
                    ]);
                }
            }

            DB::table('applicant_check_list')->insert([
                'applicant_id'            => $applicantId,
                'fee'                     => $request->fee,
                'cc_last_4'               => $request->cc_last_4,
                'date_deposited'          => $request->date_deposited,
                'reference'               => $request->references,
                'pictures'                => $request->pictures,
                'hold_hebrew'             => $request->hold_hebrew ?? 0,
                'hold_english'            => $request->hold_english ?? 0,
                'created_at'              => now(),
                'updated_at'              => now(),
            ]);

            DB::table('application_processing')->insert([
                'applicant_id'            => $applicantId,
                'interview_date'          => $request->interview_date,
                'interview_time'          => $request->interview_time,
                'interview_location'      => $request->interview_location,
                'status'                  => $request->status,
                'coming'                  => $request->coming,
                'application_comment'     => $request->application_comment,
                'scholarship_comment'     => $request->scholarship_comment,
                'tution_comment'          => $request->tution_comment,
                'letter_sent'             => $request->letter_sent ?? 0,
                'created_at'              => now(),
                'updated_at'              => now(),
            ]);

            DB::table('parent_guardians')->insert([
                'user_id'    => $user->id,
                'father_name' => $request->father_name,
                'mother_name' => $request->mother_name,
                'maiden_name' => $request->maiden_name,
                'father_mobile' => $request->father_mobile,
                'father_profession' => $request->father_profession,
                'mother_hebrew_name' => $request->mother_hebrew_name,
                'mother_mobile' => $request->mother_mobile,
                'mother_profession' => $request->mother_profession,
                'guardian_name' => $request->guardian_name,
                'guardian_email' => $request->guardian_email,
                'guardian_mobile' => $request->guardian_mobile,
                'guardian_profession' => $request->guardian_profession,
                'guardian_relation' => $request->guardian_relation,
                'guardian_address' => $request->guardian_address,
                'father_dob' => $request->father_dob,
                'mother_dob' => $request->mother_dob,
                'additional_mobile_numbers' => $request->additional_mobile_numbers,
                'father_email' => $request->father_email,
                'mother_email' => $request->mother_email,
                'additional_emails' => $request->additional_emails,
                'guardian_address' => $request->guardian_address,
                'guardian_home_phone' => $request->guardian_home_phone,
                'status'     => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();
            return $this->responseWithSuccess(___('alert.created_successfully'), []);
        } catch (\Throwable $th) {
            DB::rollback();
            dd($th);
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }
}
