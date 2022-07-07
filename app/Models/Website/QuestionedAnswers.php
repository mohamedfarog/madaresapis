<?php

namespace App\Models\Website;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionedAnswers extends Model
{
    use HasFactory;
   // public $translatable = ['title' ,'body'];
    protected $hidden = ['created_at','updated_at'];
    protected $guarded = ['id'];
}
