<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    protected $fillable = ['slug', 'status', 'event_date', 'location', 'published_at', 'updated_by'];

    protected $casts = ['event_date' => 'datetime', 'published_at' => 'datetime'];

    public function translations(): HasMany
    {
        return $this->hasMany(EventTranslation::class);
    }

    public function translationFor(string $locale): ?EventTranslation
    {
        return $this->translations->firstWhere('locale', $locale)
            ?? $this->translations->firstWhere('locale', 'en');
    }
}
