<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    protected $fillable = ['slug', 'status', 'published_at', 'updated_by'];

    protected $casts = ['published_at' => 'datetime'];

    public function translations(): HasMany
    {
        return $this->hasMany(PostTranslation::class);
    }

    public function translationFor(string $locale): ?PostTranslation
    {
        return $this->translations->firstWhere('locale', $locale)
            ?? $this->translations->firstWhere('locale', 'en');
    }
}
