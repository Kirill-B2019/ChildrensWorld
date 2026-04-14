<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventTranslation extends Model
{
    protected $fillable = ['event_id', 'locale', 'title', 'text'];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
