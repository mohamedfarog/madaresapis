<?php
namespace App\Models\Jobs;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Model;
use App\Models\Teachers\Teacher;
use App\Models\Jobs\Job;



class JobLevel extends Model
{
    use HasFactory;
    protected $fillable = ['id','title', 'avater', 'ar_title'];
    protected $guarded = ['id'];
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
