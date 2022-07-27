<?php

namespace App\Models\Jobs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobMinimumExperience extends Model
{
    use HasFactory;
    protected $fillable = ['ar_title', 'en_title'];
}
