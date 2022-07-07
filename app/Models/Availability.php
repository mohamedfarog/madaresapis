<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
    use HasFactory;
    protected $fillable = ['teacher_id'];
    protected $guarded = ['id'];
    protected $hidden = ['updated_at', 'created_at'];
}
