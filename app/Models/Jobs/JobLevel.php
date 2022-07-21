<?php

namespace App\Models\Jobs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Model;
use App\Models\Teachers\Teacher;
use App\Models\Jobs\Job;
use Illuminate\Support\Facades\App;

class JobLevel extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'title', 'avater', 'ar_title'];
    protected $guarded = ['id'];
    protected $hidden = ['created_at', 'updated_at','title','ar_title'];

    protected $appends = ['name'];

    public function jobs(): BelongsToMany
    {
        return $this->belongsToMany(Job::class);
    }
    public function teachers(): BelongsToMany
    {
        return $this->belongsToMany(Teacher::class);
    }

    public function getNameAttribute(): String
    {
        if(App::isLocale('en'))
        {
            
            return ucfirst($this->title);
        }
        return ucfirst($this->ar_title);
    }
}
