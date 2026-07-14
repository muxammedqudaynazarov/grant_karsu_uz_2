<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['key', 'value'])]
class Option extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $casts = [
        'key' => 'string',
    ];
}
