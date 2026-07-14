<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable(['uuid', 'user_id', 'status', 'finished_at', 'score'])]
class Test extends Model
{
    protected function casts(): array
    {
        return [
            'finished_at' => 'datetime'
        ];
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
