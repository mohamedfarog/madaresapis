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

    
    public function getFileUrlAttribute($value){
        return "http://127.0.0.1:8802/".$value;
    }  

}


