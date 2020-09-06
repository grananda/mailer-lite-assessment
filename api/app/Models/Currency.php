<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed exchange_rate
 */
class Currency extends Model
{
    use HasUuid;

    protected $fillable = [
        'symbol',
        'name',
        'symbol_native',
        'code',
        'name_plural',
        'exchange_rate',
        'is_default',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];
}
