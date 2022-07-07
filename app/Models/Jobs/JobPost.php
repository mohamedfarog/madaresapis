<?php

namespace App\Models\Jobs;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Academies\Academy;
use Illuminate\Http\Request;

class JobPost extends Model
{
    use HasFactory;

    public function jobsPosts(): HasMany
    {
        return $this->hasMany(Academy::class);
    }

    public function getAcademiesInfoAttribute()
    {
            $academy = Academy::select('name','avatar')->where('id', $this->id)->get();
            return $academy;

        }
    }
