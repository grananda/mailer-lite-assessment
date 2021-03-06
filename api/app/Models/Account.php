<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo as BelongsToAlias;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int      id
 * @property float    balance
 * @property string   account_number
 * @property Currency currency
 */
class Account extends Model
{
    use HasUuid;

    protected $fillable = [
        'balance',
    ];

    /**
     * @return BelongsToAlias
     */
    protected function owner()
    {
        return $this->belongsTo(User::class, 'owner_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'owner_id', 'id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    /**
     * @param Account $account
     *
     * @return bool
     */
    public function equals(self $account)
    {
        return $this->uuid === $account->uuid;
    }
}
