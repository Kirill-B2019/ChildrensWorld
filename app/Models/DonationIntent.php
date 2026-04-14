<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DonationIntent extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'currency',
        'type',
        'campaign',
        'donor_name',
        'donor_email',
        'donor_phone',
        'locale',
        'status',
        'external_reference',
        'idempotency_key',
        'expires_at',
        'paid_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'expires_at' => 'datetime',
        'paid_at' => 'datetime',
    ];

    public function transactions(): HasMany
    {
        return $this->hasMany(DonationTransaction::class);
    }
}
