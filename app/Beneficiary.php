<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Payment;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Beneficiary extends Model
{
    protected $fillable = [
        'name', 'code', 'account', 'bank', 'tin'
    ];

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
