<?php

namespace App\Models\StudentInfo;

use App\Models\Academic\Shift;
use App\Models\Academic\SubjectAssignChildren;
use App\Models\BaseModel;
use App\Models\BloodGroup;
use App\Models\Gender;
use App\Models\Leave;
use App\Models\Religion;
use App\Models\Staff\Department;
use App\Models\Staff\Staff;
use App\Models\Transcript;
use App\Models\Upload;
use App\Models\User;
use Faker\Core\Blood;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\LiveChat\Entities\Message;
use Modules\VehicleTracker\Entities\EnrollmentReport;
use Modules\VehicleTracker\Entities\StudentRouteEnrollment;
use App\Models\StudentInfo\SchoolDetail;

class Student extends BaseModel
{
    use HasFactory;

    protected $appends = ['full_name'];

    protected $casts = [
        'upload_documents' => 'array',
    ];

    public function routeEnroll()
    {
        return $this->hasOne(StudentRouteEnrollment::class, 'student_id', 'id');
    }

    public function staffs()
    {
        return $this->hasManyThrough(Staff::class, SubjectAssignChildren::class, 'student_id', 'staff_id');
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function upload()
    {
        return $this->belongsTo(Upload::class, 'image_id', 'id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', \App\Enums\Status::ACTIVE);
    }

    public function session_class_student()
    {
        return $this->belongsTo(SessionClassStudent::class, 'id', 'student_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class, 'shift_id', 'id');
    }

    public function religion()
    {
        return $this->belongsTo(Religion::class, 'religion_id', 'id');
    }

    public function gender()
    {
        return $this->belongsTo(Gender::class, 'gender_id', 'id');
    }

    public function blood()
    {
        return $this->belongsTo(BloodGroup::class, 'blood_group_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(ParentGuardian::class, 'parent_guardian_id', 'id');
    }

    public function sessionStudentDetails()
    {
        return $this->belongsTo(SessionClassStudent::class, 'id', 'student_id');
    }

    public function studentCategory()
    {
        return $this->belongsTo(StudentCategory::class, 'student_category_id', 'id');
    }

    public function lastMessage()
    {
        return $this->hasOne(Message::class, 'sender_id', 'user_id')->latest();
    }

    public function unreadMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id', 'user_id')->where('is_seen', 0);
    }

    public function route()
    {
        return $this->hasOne(StudentRouteEnrollment::class, 'student_id', 'id');
    }

    public function pickupReport()
    {
        return $this->hasOne(EnrollmentReport::class, 'student_id', 'id')->where('type', 'pickup');
    }

    public function dropReport()
    {
        return $this->hasOne(EnrollmentReport::class, 'student_id', 'id')->where('type', 'drop');
    }

    public function leaves()
    {
        return $this->hasMany(Leave::class, 'student_id', 'id');
    }

    public function transcripts()
    {
        return $this->hasMany(Transcript::class, 'student_id');
    }

    public function imageUpload()
    {
        return $this->belongsTo(\App\Models\Upload::class, 'image_id');
    }

    public function schoolDetail()
    {
        return $this->hasOne(SchoolDetail::class, 'student_id', 'id');
    }

    public function requestTranscripts()
    {
        return $this->hasMany(\App\Models\RequestTranscript::class, 'student_id');
    }


    public function classMappings()
    {
        return $this->hasMany(\App\Models\StudentClassMapping::class, 'student_id');
    }

    public function formChecklists()
    {
        return $this->hasMany(\App\Models\FormChecklist::class, 'student_id');
    }

   


}
