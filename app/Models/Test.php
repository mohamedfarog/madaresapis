<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Test extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'age', 'occupation'];
    protected $guarded = ['id'];
    protected $hidden =  ['updated_at', 'created_at'];
}
