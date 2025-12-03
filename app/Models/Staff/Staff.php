<?php

namespace App\Models\Staff;

use App\Models\Academic\SubjectAssign;
use App\Models\Academic\SubjectAssignChildren;
use App\Models\BaseModel;
use App\Models\Gender;
use App\Models\Role;
use App\Models\Staff\Designation;
use App\Models\Upload;
use App\Models\User;
use App\Models\Leave;
use App\Models\StudentClassMapping;
use App\Models\Academic\{Classes, Section, Subject};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\LiveChat\Entities\Message;
use Illuminate\Database\Eloquent\SoftDeletes;

class Staff extends BaseModel
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'user_id',
        'role_id',
        'department_id',
        'designation_id',
        'first_name',
        'last_name',
        'father_name',
        'mother_name',
        'email',
        'gender_id',
        'dob',
        'joining_date',
        'phone',
        'emergency_contact',
        'marital_status',
        'status',
        'upload_id',
        'current_address',
        'permanent_address',
        'basic_salary',
        'upload_documents',
        'title',
        'hebrew_title',
        'hebrew_first_name',
        'hebrew_last_name',
        'identification_number',
        'hebrew_dob',
        'ssn',
        'cell_phone',
        'zip_code',
        'city',
        'country',
        'position',
        'inactive',
        'neighborhood',
    ];

    protected $casts = [
        'upload_documents' => 'array',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', \App\Enums\Status::ACTIVE);
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function upload()
    {
        return $this->belongsTo(Upload::class, 'upload_id', 'id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class, 'designation_id', 'id');
    }

    public function gender()
    {
        return $this->belongsTo(Gender::class, 'gender_id', 'id');
    }

    public function lastMessage()
    {
        return $this->hasOne(Message::class, 'receiver_id', 'user_id');
    }

    public function unreadMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id', 'user_id')->where('is_seen', 0);
    }

    public function subject_assign_childrens()
    {
        return $this->hasMany(SubjectAssignChildren::class, 'staff_id');
    }

    public function leaves()
    {
        return $this->hasMany(Leave::class, 'teacher_id', 'id');
    }

    public function subjectAssigns()
    {
        return $this->hasManyThrough(
            SubjectAssign::class,            // The final model you want to access
            SubjectAssignChildren::class,    // The intermediate model
            'staff_id',                      // Foreign key on the SubjectAssignChildren table
            'id',                            // Foreign key on the SubjectAssign table (default is 'id')
            'id',                            // Local key on the Staff model (default is 'id')
            'subject_assign_id'              // Local key on the SubjectAssignChildren model
        );
    }

    // public function classes()
    // {
    //     return $this->belongsToMany(
    //         Classes::class,
    //         'student_class_mapping',
    //         'teacher_id',
    //         'class_id'
    //     )->withPivot('status');
    // }

    // public function subjects()
    // {
    //     return $this->belongsToMany(
    //         Subject::class,
    //         'student_class_mapping',
    //         'teacher_id',
    //         'class_id'  
    //     )->using(StudentClassMapping::class);
    // }


    public function classes()
    {
        return $this->hasMany(Classes::class, 'teacher_id', 'id');
    }

    public function subjects()
    {
        return $this->hasManyThrough(
            Subject::class,
            Classes::class,
            'teacher_id',   // FK on classes table
            'id',           // PK on subject table
            'id',           // PK on staff table
            'subject_id'    // FK on classes table
        );
    }

}
