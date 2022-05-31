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


class Academy extends Model
{
    use HasFactory;

    // protected $fillable = ['user_id', 'name' , 'website','contact_number' , 'contact_email' ,'bio' , 'avatar' , 'banner' ];
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
}
