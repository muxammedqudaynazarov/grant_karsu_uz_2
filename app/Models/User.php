<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

#[Fillable(['id', 'name', 'token', 'role', 'lang', 'department_id', 'specialty_id', 'group_id', 'data'])]
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $casts = [
        'data' => 'json'
    ];
}
