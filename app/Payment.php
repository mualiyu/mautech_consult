<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Beneficiary;
use App\Tax;
use App\Voucher;
use App\Mandate;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Payment extends Model
{

    protected $fillable = [
        'amount', 'description', 'duedate', 'beneficiary_id', 'voucher_id', 'tax_id',
    ];

    public function beneficiary(): BelongsTo
    {
        return $this->belongsTo(Beneficiary::class);
    }

    public function voucher(): BelongsTo
    {
        return $this->belongsTo(Voucher::class);
    }

    public function tax(): BelongsTo
    {
        return $this->belongsTo(Tax::class);
    }

    public function mandate(): HasMany
    {
        return $this->hasMany(mandate::class);
    }
}
