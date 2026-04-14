<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReportTranslation extends Model
{
    protected $fillable = ['report_id', 'locale', 'title'];

    public function report(): BelongsTo
    {
        return $this->belongsTo(Report::class);
    }
}
