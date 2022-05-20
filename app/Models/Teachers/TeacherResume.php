<?php

namespace App\Models\Teachers;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Teachers\Teacher;


class TeacherResume extends Model
{
    use HasFactory;

    protected $fillable = ['teacher_id', 'curriculum_vitae' , 'cover_litter','extra_skills' ];
    
    protected $hidden = ['updated_at'];

    protected $casts = [
        'extra_skills' => 'array'
    ];




    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }


}
