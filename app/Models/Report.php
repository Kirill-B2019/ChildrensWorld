<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Report extends Model
{
    protected $fillable = ['slug', 'status', 'period', 'file_path', 'published_at', 'updated_by'];

    protected $casts = ['published_at' => 'datetime'];

    public function translations(): HasMany
    {
        return $this->hasMany(ReportTranslation::class);
    }

    public function translationFor(string $locale): ?ReportTranslation
    {
        return $this->translations->firstWhere('locale', $locale)
            ?? $this->translations->firstWhere('locale', 'en');
    }
}
