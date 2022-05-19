<?php

namespace App\Models\Jobs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;
use App\Models\Jobs\CommunicateMethod;


class JobAppSetting extends Model
{
    use HasFactory;


    protected $guarded = ['id'];
    protected $hidden = ['created_at' , 'updated_at'];


    public function communicate(): HasOne
    {
        return $this->hasOne(CommunicateMethod::class);
    }
}
