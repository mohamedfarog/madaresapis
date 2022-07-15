<?php

namespace App\Models\Academies;

use App\Models\Jobs\JobLevel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademyLevels extends Model
{
    use HasFactory;
    protected $fillable = ['academy_id', 'level_id'];
    protected $guarded = ['id'];
    protected $hidden = ['created_at', 'updated_at'];
    public function level()
    {
       return $this->belongsTo(JobLevel::class);
    }
}
