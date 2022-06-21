<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skills extends Model
{
    use HasFactory;
    protected $fillable = ['teacher_id','skill_ar_name', 'skill_en_name'];
    protected $guarded = ['id'];
    protected $hidden = ['updated_at', 'created_at'];
}
