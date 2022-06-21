<?php

namespace App\Models\Teachers;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherResume extends Model
{
    use HasFactory;
    protected $fillable = ['teacher_id', 'curriculum_vitae', 'cover_litter', 'extra_skills'];
    protected $guarded = ['id'];
    protected $hidden = ['updated_at', 'created_at'];
}