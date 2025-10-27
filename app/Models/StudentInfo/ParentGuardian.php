<?php

namespace App\Models\StudentInfo;

use App\Models\User;
use App\Models\BaseModel;
use Modules\LiveChat\Entities\Message;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Applicant\Applicant;


class ParentGuardian extends BaseModel
{
    use HasFactory;

      protected $table = 'parent_guardians';

    protected $fillable = [
        'user_id',
        'student_id',
        'father_title',
        'father_name',
        'father_hebrew_name',
        'father_mobile',
        'father_email',
        'father_dob',
        'father_profession',
        'father_image',
        'father_nationality',
        'mother_title',
        'mother_name',
        'maiden_name',
        'mother_hebrew_name',
        'mother_mobile',
        'mother_email',
        'mother_dob',
        'mother_profession',
        'mother_image',
        'additional_mobile_numbers',
        'additional_emails',

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function lastMessage()
    {
        return $this->hasOne(Message::class, 'sender_id', 'user_id')->latest();
    }

    public function unreadMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id', 'user_id')->where('is_seen', 0);
    }

    public function scopeActive($query)
    {
        return $query->where('status', \App\Enums\Status::ACTIVE);
    }

    public function children() : HasMany
    {
        return $this->hasMany(Student::class, "parent_guardian_id", "id");
    }

    public function applicants()
    {
        return $this->belongsToMany(
            Applicant::class,
            'applicant_parents', // pivot table
            'parent_id',         // foreign key in pivot referencing ParentGuardian
            'applicant_id'       // foreign key in pivot referencing Applicant
        );
    }
}
