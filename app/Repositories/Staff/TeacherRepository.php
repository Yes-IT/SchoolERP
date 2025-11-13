<?php

namespace App\Repositories\Staff;

use App\Interfaces\Staff\TeacherInterface;
use App\Models\{User,Role};
use App\Models\Staff\Staff;
use App\Enums\Settings;
use Illuminate\Support\Facades\{DB,Hash,Log};
use Illuminate\Support\Str;
use App\Traits\ReturnFormatTrait;
use App\Traits\CommonHelperTrait;
use Carbon\Carbon;
use App\Models\Academic\Classes;

class TeacherRepository implements TeacherInterface
{
    use ReturnFormatTrait;
    use CommonHelperTrait;

    const ROLE_TEACHER = 5;
    private $model;

    public function __construct(Staff $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->where('role_id', self::ROLE_TEACHER)->get();
    }

   
    public function getPaginateAll()
    {
        // dd(\App\Enums\Settings::PAGINATE);

        $perPage = request('per_page', Settings::PAGINATE);
        return $this->model
            ->where('role_id', self::ROLE_TEACHER)
            ->latest()
            ->paginate($perPage);
    }


    public function searchTeachers($request)
    {
        $query = $this->model->where('role_id', self::ROLE_TEACHER);

        if ($request->keyword != "") {
            $query->where(function ($q) use ($request) {
                $q->where('first_name', 'LIKE', "%{$request->keyword}%")
                  ->orWhere('last_name', 'LIKE', "%{$request->keyword}%")
                  ->orWhere('email', 'LIKE', "%{$request->keyword}%")
                  ->orWhere('mobile', 'LIKE', "%{$request->keyword}%");
            });
        }

        if ($request->department_id) {
            $query->where('department_id', $request->department_id);
        }

        return $query->paginate(Settings::PAGINATE);
    }

    public function store($request)
    {
        // Log::info('request data',['request' => $request->all()]);

        DB::beginTransaction();
        try {
            $role = Role::find(self::ROLE_TEACHER);
            $uploadId = $this->UploadImageCreate($request->fileUpload, 'backend/uploads/teachers');
            

            $user = new User();
            $user->name                = $request->first_name . ' ' . $request->last_name;
            $user->email               = $request->email;
            $user->phone               = $request->home_phone;
            $user->password            = Hash::make($request->password ?? '123456');
            $user->email_verified_at   = now();
            $user->role_id             = $role->id;
            $user->permissions         = $role->permissions;
            $user->uuid                = Str::uuid();
            $user->upload_id           = $uploadId;
            $user->save();

             // Generate Teacher ID safely inside transaction
            $lastTeacher = $this->model->orderBy('id', 'desc')->lockForUpdate()->first();
            $nextNumber = $lastTeacher
                ? ((int) filter_var($lastTeacher->identification_number, FILTER_SANITIZE_NUMBER_INT)) + 1
                : 1;
            $teacherId = 'TCHR' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

            $row                        = new $this->model;
            $row->user_id               = $user->id;
            $row->staff_id              = '123';
            $row->role_id               = self::ROLE_TEACHER;
            $row->designation_id        = '1';
            $row->department_id         = '2';
            $row->first_name            = $request->first_name;
            $row->last_name             = $request->last_name;
            $row->email                 = $request->email;
            $row->gender_id             = '1';
            $row->marital_status        = '1';
            $row->status                = $request->status ?? 1;
            $row->current_address       = $request->address;
            $row->title                 = $request->title;
            $row->hebrew_title          = $request->hebrew_title;
            $row->hebrew_first_name     = $request->hebrew_first_name;
            $row->hebrew_last_name      = $request->hebrew_last_name;
            $row->identification_number = $teacherId;
            $row->dob                   = Carbon::parse($request->dob)->format('Y-m-d');
            $row->hebrew_dob            = Carbon::parse($request->hebrew_dob)->format('Y-m-d');
            $row->neighborhood          = $request->neighborhood;
            $row->ssn                   = $request->ssn;
            $row->phone                 = $request->home_phone;
            $row->cell_phone            = $request->cell_phone;
            $row->upload_id             = $uploadId;
            $row->city                  = $request->city;
            $row->country               = $request->country;
            $row->zip_code              = $request->zip_code;
            $row->position              = $request->position;
            $row->save();

            DB::commit();
            return $this->responseWithSuccess(___('alert.Teacher_created_successfully'), $row);
        } catch (\Throwable $th) {
            DB::rollback();
           Log::error('teacher store error', ['error' => $th->getMessage()]);

            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }

    public function show($id)
    {
        return $this->model->with('upload')->find($id);
    }

    public function fetchClasses($id)
    {
        return Classes::where('teacher_id',$id)->with(['subject','session','yearStatus','semester'])->get();
    }

    public function update($request, $id)
    {
        // Log::info('request data in update teacher', ['request' => $request->all()]);

        DB::beginTransaction();

        try {
            $row = $this->model->find($id);
            if (!$row) {
                return $this->responseWithError('Teacher not found', []);
            }

            $user = User::find($row->user_id);
            if (!$user) {
                return $this->responseWithError('User not found', []);
            }

            // === Update User Table ===
            $user->name  = trim(($request->first_name ?? '') . ' ' . ($request->last_name ?? ''));
            $user->email = $request->email;
            $user->phone = $request->home_phone ?? $user->phone;

            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            // Handle image upload safely
            $user->upload_id = $this->UploadImageUpdate(
                $request->file('fileUpload'),
                'backend/uploads/teachers',
                $user->upload_id
            );

            $user->save();

            // === Update Staff Table (Teacher Info) ===
            $row->first_name        = $request->first_name ?? $row->first_name;
            $row->last_name         = $request->last_name ?? $row->last_name;
            $row->email             = $request->email ?? $row->email;
            $row->current_address   = $request->address ?? $row->current_address;

            $row->title             = $request->title ?? $row->title;
            $row->hebrew_title      = $request->hebrew_title ?? $row->hebrew_title;
            $row->hebrew_first_name = $request->hebrew_first_name ?? $row->hebrew_first_name;
            $row->hebrew_last_name  = $request->hebrew_last_name ?? $row->hebrew_last_name;

            // Handle nullable dates safely
            $row->dob        = $request->dob ? Carbon::parse($request->dob)->format('Y-m-d') : $row->dob;
            $row->hebrew_dob = $request->hebrew_dob ? Carbon::parse($request->hebrew_dob)->format('Y-m-d') : $row->hebrew_dob;

            $row->neighborhood = $request->neighborhood ?? $row->neighborhood;
            $row->ssn          = $request->ssn ?? $row->ssn;
            $row->phone        = $request->home_phone ?? $row->phone;
            $row->cell_phone   = $request->cell_phone ?? $row->cell_phone;
            $row->upload_id    = $user->upload_id;

            $row->city     = $request->city ?? $row->city;
            $row->country  = $request->country ?? $row->country;
            $row->zip_code = $request->zip_code ?? $row->zip_code;
            $row->position = $request->position ?? $row->position;

            $row->save();

            DB::commit();

            // Log::info('teacher updated successfully', ['teacher' => $row]);

            return $this->responseWithSuccess(___('alert.Teacher_updated_successfully'), $row);

        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('teacher update error', ['error' => $th->getMessage(), 'trace' => $th->getTraceAsString()]);
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $row = $this->model->find($id);
            $user = User::find($row->user_id);
            if ($user) {
                $this->UploadImageDelete($user->upload_id);
                $user->delete();
            }
            $row->delete();

            DB::commit();
            return $this->responseWithSuccess(___('alert.deleted_successfully'), []);
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }

    public function filter($request)
    {
        $query = Staff::query();

        if ($request->id && $request->id !== 'all') {
            $query->where('id', $request->id);
        }

        return $query->paginate(
            $request->per_page ?? 10, 
            ['*'], 
            'page', 
            $request->page ?? 1
        )->appends($request->except('page'));
    }

}
