<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo as BelongsToAlias;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Account extends Model
{
    use HasUuid;

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
}
