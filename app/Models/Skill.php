<?php



namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;
    protected $table = 'skill';
    protected $fillable = ['id', 'en_skill_name','ar_skill_name'];
    protected $guarded = ['id'];
    protected $hidden = ['updated_at', 'created_at'];
}
