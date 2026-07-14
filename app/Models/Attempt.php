<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Attempt extends Model
{
    protected $fillable = [
        'user_id',
        'test_id',
        'question_id',
        'answer_id',
        'pos'
    ];

    public function question(): HasOne
    {
        return $this->hasOne(Question::class, 'id', 'question_id');
    }
}
