<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Locations extends Model
{
    use HasFactory;
    protected $fillable = ['country','city', 'street','academy_id','teacher_id'];
    protected $guarded = ['id'];
    protected $hidden = ['updated_at', 'created_at'];
}
