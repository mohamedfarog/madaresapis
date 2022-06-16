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

class Academy extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'en_name' ,'ar_name', 'website','contact_number','ar_bio', 'en_bio', 'avatar' , 'banner' ];
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
    public function academyFiles(){
        return $this->hasMany(academyFiles::class);
    }
    public function academyLocations(){
        return $this->hasOne(Locations::class);
    }
    public function academyLevels(){
        return $this->hasMany(academyLevels::class);
    }
    public function getVacanciesAttribute()
    {
        $jobs= Job::where('academy_id',$this->id)->sum('job_vacancy');
        return $jobs;
    }
    public function getTotaljobsAttribute()
    {
        $jobs= Job::where('academy_id',$this->id)->count('job_vacancy');
        return $jobs;
    }
  
}
