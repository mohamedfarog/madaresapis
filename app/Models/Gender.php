<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Model;
use App\Models\Jobs\Job;

use App\Models\Teachers\Teacher;

class Gender extends Model
{
    use HasFactory;

    protected $fillable = ['title'];

    protected $hidden = ['created_at' , 'updated_at'];




    public function teachers(): BelongsToMany
    {
        return $this->belongsToMany(Teacher::class);
    }

    
    public function jobs(): BelongsToMany
    {
        return $this->belongsToMany(Job::class);
    }


    public function getTitleAttribute($value): String
    {
        return ucfirst($value);
    }
}
