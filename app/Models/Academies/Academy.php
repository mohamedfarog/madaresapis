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
    protected $fillable = ['user_id', 'name','contact_number','bio', 'avatar', 'academy_size_id', 'years_of_teaching_id'];
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
    public function profileViews(){
        return 0;
    }
    public function unReadMessages(){
        return 0;
    }
    public function applicationsReceived(){
        return 0;
    }
    public function applicationsAnswered(){
        return 0;
    }
    public function interviewedApplicants(){
        return 0;
    }
    public function HiredApplicants()
    {
        return 0;
    }
    public function receivedApplicationsForLast8Month()
    {
        return 8;
    }
    public function receivedApplicationsForLastMonth()
    {
        return 1;
    }
    public function receivedApplicationsForLastWeek()
    {
        return 7;
    }

    public function rejectedApplicationsForLast8Month()
    {
        return 0;
    }
    public function rejectedApplicationsForLastMonth()
    {
        return 0;
    }
    public function rejectedApplicationsForLastWeek()
    {
        return 0;
    }
    public function interviwedApplicationsForLast8Month()
    {
        return 0;
    }
    public function interviwedApplicationsForLastMonth()
    {
        return 3;
    }
    public function interviwedApplicationsForLastWeek()
    {
        return 0;
    }
}
