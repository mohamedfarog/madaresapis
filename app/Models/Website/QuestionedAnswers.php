<?php

namespace App\Models\Website;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class QuestionedAnswers extends Model
{
    use HasFactory , HasTranslations;
    public $translatable = ['en_title' , 'ar_title', 'ar_body', 'ar_title'];
    protected $hidden = ['created_at','updated_at'];
    protected $guarded = ['id'];
}
