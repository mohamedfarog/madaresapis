<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blogs extends Model
{
    use HasFactory;
    protected $table = 'blogs';
    protected $fillable = ['title','body', 'like_unlike'];
    protected $guarded = ['id'];
    protected $hidden = ['updated_at', 'created_at'];
}
