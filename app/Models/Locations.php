<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Locations extends Model
{
    use HasFactory;
    protected $fillable = ['en_country','ar_city_name', 'en_city_name', 'ar_street', 'en_street','academy_id','teacher_id'];
    protected $guarded = ['id'];
    protected $hidden = ['updated_at', 'created_at'];
}
