<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo as BelongsToAlias;

class Transaction extends Model
{
    use HasUuid;

    protected $fillable = [
        'amount',
    ];

    /**
     * @return BelongsToAlias
     */
    protected function ownerAccount()
    {
        return $this->belongsTo(Account::class, 'account_from_id', 'id');
    }

    /**
     * @return BelongsToAlias
     */
    protected function targetAccount()
    {
        return $this->belongsTo(Account::class, 'account_to_id', 'id');
    }
}
