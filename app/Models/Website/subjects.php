<?php

namespace App\Models\Website;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class subjects extends Model
{
    use HasFactory;
    public function getCountAttribute()
    {
        return 0;
    }
}
