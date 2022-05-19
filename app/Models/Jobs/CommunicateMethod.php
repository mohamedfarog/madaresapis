<?php

namespace App\Models\Jobs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\belongsTo;
use Illuminate\Database\Eloquent\Model;

use App\Models\Jobs\JobAppSetting;


class CommunicateMethod extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $hidden = ['created_at' , 'updated_at'];


    public function app(): belongsTo
    {
        return $this->belongsTo(JobAppSetting::class);
    }

    
}
