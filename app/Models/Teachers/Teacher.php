<?php

namespace App\Models\Teacher;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Teachers\TeacherResume;
use App\Models\Teachers\TeacherExperience;
use App\Models\User;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'first_name' , 'last_name','mobile' , 'date_of_birth' , 'avatar' , 'academic_major' , 'bio' , 'gender'  ];

    protected $hidden = ['updated_at'];


    public function user(): belongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    

    public function resume(): hasOne
    {
        return $this->hasOne(TeacherResume::class);
    }


    public function experiences(): hasMany
    {
        return $this->hasMany(TeacherExperience::class);
    }

}
