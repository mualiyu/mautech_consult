<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Voucher;
use App\Payment;

class Budget extends Model
{
    protected $fillable = [
        'account_code', 'description', 'amount'
    ];

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
