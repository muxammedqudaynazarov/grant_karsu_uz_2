<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

#[Fillable(['name', 'status', 'limit'])]
class Category extends Model
{
    use HasTranslations;

    protected $translatable = ['name'];

    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }
}
