<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tax extends Model
{
    protected $fillable = [
        'percentage', 'type', 'created_at', 'updated_at'
    ];

    // public function payments(): HasMany
    // {
    //     return $this->hasMany(Payment::class);
    // }
}
