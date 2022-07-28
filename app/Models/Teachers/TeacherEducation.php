<?php

namespace App\Models\Teachers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherEducation extends Model
{
    use HasFactory;
    protected $fillable = ['teacher_id', 'title' ,'start_date', 'end_date', 'degree', 'place_of_issurance', 'online_cert_url'];
    protected $guarded = ['id'];
    protected $hidden = ['updated_at'];
}
