<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DonationTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'donation_intent_id',
        'status',
        'transaction_id',
        'bank_reference',
        'fee',
        'payload',
    ];

    protected $casts = [
        'fee' => 'decimal:2',
        'payload' => 'array',
    ];

    public function intent(): BelongsTo
    {
        return $this->belongsTo(DonationIntent::class, 'donation_intent_id');
    }
}
