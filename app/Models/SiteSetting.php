<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = ['group', 'key', 'locale', 'value'];

    public static function getValue(string $group, string $key, ?string $locale = null, ?string $default = null): ?string
    {
        $query = static::query()->where('group', $group)->where('key', $key);

        if ($locale !== null) {
            $localeValue = (clone $query)->where('locale', $locale)->value('value');
            if ($localeValue !== null) {
                return $localeValue;
            }
        }

        return (clone $query)->whereNull('locale')->value('value') ?? $default;
    }
}
