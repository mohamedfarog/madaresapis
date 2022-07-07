<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skills extends Model
{
    use HasFactory;
    protected $table = 'skills';
    protected $fillable = ['teacher_id','kill_id'];
    protected $guarded = ['id'];
    protected $hidden = ['updated_at', 'created_at'];
}
