<?php

namespace App\Models\Website;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class QuestionedAnswers extends Model
{
    use HasFactory , HasTranslations;

    public $translatable = ['title' , 'body'];
    
    protected $hidden = ['created_at','updated_at'];

    protected $guarded = ['id'];


}