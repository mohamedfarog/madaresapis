<?php


namespace App\Models\Teachers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherFiles extends Model
{
    use HasFactory;

    protected $fillable = ['teacher_id', 'file_url'];
    protected $guarded = ['id'];
    protected $hidden = ['created_at', 'updated_at'];

    public function getFileUrlAttribute($value){
        return "http://api.madaresweb.mvp-apps.ae".$value;
    }  
}
