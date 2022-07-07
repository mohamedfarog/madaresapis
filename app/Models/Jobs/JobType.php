<?php

namespace App\Models\Jobs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Jobs\Job;
use App\Models\Teachers\Teacher;
use Illuminate\Database\Eloquent\Model;


class JobType extends Model
{
    use HasFactory;

    protected $fillable = ['title'] ;
    protected $hidden = ['created_at' , 'updated_at'];

    public function jobs(): BelongsToMany
    {
        return $this->belongsToMany(Job::class);
    }


    public function teachers(): BelongsToMany
    {
        return $this->belongsToMany(Teacher::class);
    }


    public function getTitleAttribute($value): String
    {
        return ucfirst($value);
    }

}
