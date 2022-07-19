<?php

namespace App\Models\Jobs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Academies\Academy;
use App\Models\Jobs\JobType;
use App\Models\Jobs\JobLevel;
use App\Models\Jobs\JobAppSetting;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{

    use HasFactory;
    protected $guarded = ['id'];
    protected $hidden = ['created_at' , 'updated_at', 'updated_at'];

    public function academy(): BelongsTo
    {  
      return $this->belongsTo(Academy::class);
    }
    public function gender(): HasOne
    {
        return $this->hasOne(Gender::class);
    }

    public function type(): HasOne
    {
        return $this->hasOne(JobType::class);
    }
    public function level(): HasOne
    {
        return $this->hasOne(JobLevel::class);
    }
    public function setting(): HasOne
    {
        return $this->hasOne(JobAppSetting::class);
    }
    public function getAcademiesInfoAttribute()
    {
        $academy = Academy::select('en_name','avatar', 'ar_name')->where('id', $this->id)->get();
        return $academy;
    }
}
