<?php

namespace App\Models\Jobs;
use App\Models\Academies\Academy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class JobActApply extends Model
{
    protected $table = 'job_act_apply';
    use HasFactory;
    

    public function academy(): BelongsTo
    {
        return $this->belongsTo(Academy::class);
    }
    public function jobs(): BelongsTo
    {
        return $this->belongsTo(Jobs::class);
    }
    
}
