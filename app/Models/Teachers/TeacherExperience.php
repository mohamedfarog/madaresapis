<?php

namespace App\Models\Teachers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Teachers\Teacher;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeacherExperience extends Model
{
    use HasFactory;
    protected $fillable = ['teacher_id', 'title' , 'place_of_assurance','start_day', 'end_day' ];
    protected $guarded = ['id'];
    protected $hidden = ['updated_at', 'created_at'];
}
