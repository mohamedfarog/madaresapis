<?php

namespace App\Models\Teachers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Teachers\Teacher;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeacherExperience extends Model
{
    use HasFactory;

    //protected $fillable = ['teacher_id', 'curriculum_vitae' , 'cover_litter','extra_skills' ];
    protected $guarded = ['id'];
    protected $hidden = ['updated_at'];
    protected $casts = [
        'certificates' => 'array'
    ];
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }
}
