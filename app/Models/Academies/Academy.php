<?php

namespace App\Models\Academies;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;
use App\Models\Academies\Branch;
use App\Models\Jobs\Job;
use App\Models\User;
use App\Models\Academies\AcademyFile;
use App\Models\Academies\AcademyLevels;
use App\Models\Locations;
use phpDocumentor\Reflection\Location;

class Academy extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'en_name' ,'ar_name','contact_number','ar_bio', 'en_bio', 'avatar' ];
    protected $guarded = ['id'];
    protected $hidden = ['updated_at'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function branches(): HasMany
    {
        return $this->hasMany(Branch::class);
    }
    public function jobs(): HasMany
    {
        return $this->hasMany(Job::class);
    }
    public function getVacanciesAttribute()
    {
        $jobs= Job::where('academy_id',$this->id)->sum('job_vacancy');
        return $jobs;
    }
    public function getCurrentStatusAttribute()

    {
        $vemil = User::where('id', $this->user_id)->first(['email_verified', 'is_active']);
        return $vemil;
    }

    public function getTotaljobsAttribute()
    {
        $jobs= Job::where('academy_id',$this->id)->count('job_vacancy');
        return $jobs;
    }
    public function getAvatarAttribute($value){
        return "http://api.madaresweb.mvp-apps.ae".$value;
    }   
    public function academyLocations(): HasMany
    {
        return $this->hasMany(Locations::class, 'academy_id', 'user_id');
    }

    public function academyLevels(): HasMany
    {
        return $this->hasMany(AcademyLevels::class, 'academy_id', 'user_id');
    }
    public function academyFiles(): HasMany
    {
        return $this->hasMany(AcademyFile::class, 'academy_id', 'user_id');
    }
}
