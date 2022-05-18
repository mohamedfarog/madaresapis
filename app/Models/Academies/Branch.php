<?php

namespace App\Models\Academies;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Academies\Academy;

class Branch extends Model
{
    use HasFactory;


    public function academy(): belongsTo
    {
        return $this->belongsTo(Academy::class);
    }
}
