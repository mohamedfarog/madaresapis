<?php

namespace App\Models\Academies;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademyFile extends Model
{
    use HasFactory;
    protected $fillable = ['academy_id', 'file_url'];
    protected $guarded = ['id'];
    protected $hidden = ['created_at', 'updated_at'];
}
