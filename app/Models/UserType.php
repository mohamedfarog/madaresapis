<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class UserType extends Model
{
    use HasFactory;
     protected $table = 'user_types';
    protected $fillable = ['user_id','type'];
    protected $hidden = [
        'created_at', 'updated_at'
    ];
    public function users(){  
        return $this->belongsToMany(User::class) ;
    }
}
