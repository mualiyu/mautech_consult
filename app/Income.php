<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    protected $fillable = [
        'payer', 'ref_num', 'amount', 'type', 'created_at'
    ];
}
