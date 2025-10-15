<?php

namespace App\Repositories\StudentInfo;

use App\Models\Role;
use App\Models\User;
use App\Enums\Settings;
use App\Enums\ApiStatus;
use Illuminate\Support\Str;
use App\Traits\CommonHelperTrait;
use App\Traits\ReturnFormatTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\StudentInfo\ParentGuardian;
use App\Interfaces\StudentInfo\ParentGuardianInterface;

class ParentGuardianRepository implements ParentGuardianInterface
{
    use ReturnFormatTrait;
    use CommonHelperTrait;

    private $model;

    public function __construct(ParentGuardian $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->active()->pluck('guardian_name','id')->toArray();
    }

    public function get()
    {
        return $this->model->select("id", "guardian_name")->active()->get();
    }

    public function getPaginateAll()
    {
        return $this->model::with('children')->latest()->paginate(Settings::PAGINATE);
    }

    public function searchParent($request)
    {
        $query = $this->model::query();
        $query->whereHas('children.schoolDetail', function ($q) use ($request) {
            if (!empty($request->year)) {
                $q->where('school_year', $request->year);
            }
            if (!empty($request->year_status)) {
                $q->where('year_status', $request->year_status);
            }
        });
        if (!empty($request->student_name)) {
            $query->whereHas('children', function ($q) use ($request) {
                $nameParts = explode(' ', $request->student_name, 2);
                $firstName = $nameParts[0] ?? null;
                $lastName  = $nameParts[1] ?? null;
                $q->where('first_name', $firstName);
                if ($lastName) {
                    $q->where('last_name', $lastName);
                }
            });
        }

        return $query->with('children')->paginate(Settings::PAGINATE);
    }


    public function getParent($request)
    {
        return $this->model->where('guardian_name', 'like', '%' . $request->text . '%')->pluck('guardian_name','id')->toArray();
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {
            $role                    = Role::find(7);
            $user                    = new User();
            $user->name              = $request->guardian_name;
            $user->email             = $request->guardian_email;
            $user->phone             = $request->guardian_mobile;
            $user->password          = $request->password_type == 'default'? Hash::make('123456') : Hash::make($request->password);
            $user->email_verified_at = now();
            $user->role_id           = $role->id;
            $user->permissions       = $role->permissions;
            $user->username          = $request->username;
            $user->upload_id         = $this->UploadImageCreate($request->guardian_image, 'backend/uploads/users');
            $user->uuid              = Str::uuid();
            $user->save();

            $row = $this->model::firstOrNew(['student_id' => $request->student_id]);
            $row->user_id                  = $user->id;
            $row->father_title             = $request->father_title;
            $row->father_name              = $request->father_name;
            $row->father_hebrew_name       = $request->father_hebrew_name;
            $row->father_mobile            = $request->father_mobile;
            $row->father_profession        = $request->father_profession;
            $row->mother_title             = $request->mother_title;
            $row->mother_name              = $request->mother_name;
            $row->maiden_name              = $request->maiden_name;
            $row->mother_hebrew_name       = $request->mother_hebrew_name;
            $row->mother_mobile            = $request->mother_mobile;
            $row->mother_profession        = $request->mother_profession;
            $row->guardian_name            = $request->guardian_name;
            $row->guardian_email           = $request->guardian_email;
            $row->guardian_mobile          = $request->guardian_mobile;
            $row->guardian_profession      = $request->guardian_profession;
            $row->guardian_relation        = $request->guardian_relation;
            $row->guardian_address         = $request->guardian_address;
            $row->father_dob               = $request->father_dob;
            $row->mother_dob               = $request->mother_dob;
            $row->additional_mobile_numbers= $request->additional_mobile_numbers;
            $row->father_email             = $request->father_email;
            $row->mother_email             = $request->mother_email;
            $row->additional_emails        = $request->additional_emails;
            $row->guardian_home_phone      = $request->guardian_home_phone;
            $row->status                   = 1;
            $row->updated_at               = now();
            $row->created_at               = $row->exists ? $row->created_at : now();    
            $row->save();
            DB::commit();
            return $this->responseWithSuccess(___('alert.created_successfully'), []);
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }


    public function show($id)
    {
        return $this->model->find($id);
    }

    public function update($request, $id)
    {
        DB::beginTransaction();
        try {
            $parent = ParentGuardian::where('student_id', $id)->firstOrFail();
            if ($parent->user_id) {
                $user = User::findOrFail($parent->user_id);
            } else {
                $role = Role::findOrFail(7);
                $user = new User();
                $user->password          = Hash::make('123456');
                $user->role_id           = $role->id;
                $user->permissions       = $role->permissions;
                $user->uuid              = Str::uuid();
            }
            $user->name        = $request->guardian_name;
            $user->email       = $request->guardian_email;
            $user->phone       = $request->guardian_mobile;
            $user->username    = $request->username;
            $user->upload_id   = $this->UploadImageUpdate($request->guardian_image, 'backend/uploads/users', $user->upload_id ?? null);
            $user->save();

            $row = $this->model::firstOrNew(['student_id' => $request->student_id]);
            $row->user_id                  = $user->id;
            $row->father_title             = $request->father_title;
            $row->father_name              = $request->father_name;
            $row->father_hebrew_name       = $request->father_hebrew_name;
            $row->father_mobile            = $request->father_mobile;
            $row->father_profession        = $request->father_profession;
            $row->mother_title             = $request->mother_title;
            $row->mother_name              = $request->mother_name;
            $row->maiden_name              = $request->maiden_name;
            $row->mother_hebrew_name       = $request->mother_hebrew_name;
            $row->mother_mobile            = $request->mother_mobile;
            $row->mother_profession        = $request->mother_profession;
            $row->guardian_name            = $request->guardian_name;
            $row->guardian_email           = $request->guardian_email;
            $row->guardian_mobile          = $request->guardian_mobile;
            $row->guardian_profession      = $request->guardian_profession;
            $row->guardian_relation        = $request->guardian_relation;
            $row->guardian_address         = $request->guardian_address;
            $row->father_dob               = $request->father_dob;
            $row->mother_dob               = $request->mother_dob;
            $row->additional_mobile_numbers= $request->additional_mobile_numbers;
            $row->father_email             = $request->father_email;
            $row->mother_email             = $request->mother_email;
            $row->additional_emails        = $request->additional_emails;
            $row->guardian_home_phone      = $request->guardian_home_phone;
            $row->status                   = 1;
            $row->updated_at               = now();
            $row->created_at               = $row->exists ? $row->created_at : now();    
            $row->save();
            DB::commit();
            return $this->responseWithSuccess(___('alert.created_successfully'), []);
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $row = $this->model->find($id);
            $this->UploadImageDelete($row->father_image);
            $this->UploadImageDelete($row->mother_image);
            $row->delete();

            $user = User::find($row->user_id);
            $this->UploadImageDelete($user->upload_id);
            $user->delete();

            DB::commit();
            return $this->responseWithSuccess(___('alert.deleted_successfully'), []);
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }
}
