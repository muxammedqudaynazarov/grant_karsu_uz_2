<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

#[Fillable(['answer', 'question_id', 'correct', 'status'])]
class Answer extends Model
{
    use HasTranslations;

    public $translatable = ['answer'];
}
