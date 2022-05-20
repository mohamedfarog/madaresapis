<?php

namespace App\Models\Academies;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Illuminate\Database\Eloquent\Model;

use App\Models\Academies\Academy;

class Branch extends Model
{
    use HasFactory;


    public function academy(): BelongsTo
    {
        return $this->belongsTo(Academy::class);
    }
}
