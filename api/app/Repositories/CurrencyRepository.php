<?php

namespace App\Repositories;

use App\Models\Currency;

class CurrencyRepository extends BaseRepository
{
    /**
     * @param \App\Models\Currency $model
     */
    public function __construct(Currency $model)
    {
        parent::__construct($model);
    }
}
