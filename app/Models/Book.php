<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Book extends Model
{
    use HasTranslations;

    protected $fillable = [
        'name',
        'user_id',
        'category_id',
        'status'
    ];
    public $translatable = ['name'];
}
