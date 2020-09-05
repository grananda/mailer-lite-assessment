<?php

namespace App\Repositories;

use App\Models\Transaction;

class TransactionRepository extends BaseRepository
{
    /**
     * @param \App\Models\Transaction $model
     */
    public function __construct(Transaction $model)
    {
        parent::__construct($model);
    }
}
