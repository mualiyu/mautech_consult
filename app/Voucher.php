<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Voucher extends Model
{
    protected $fillable = [
        'pvno', 'totalamount',
    ];

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
