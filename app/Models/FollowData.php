<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FollowData extends Model
{
    use HasFactory;
    protected $table = 'follow_data';
    public $timestamps = false;
}
