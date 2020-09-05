<?php

namespace App\Repositories;

use App\Models\Account;

class AccountRepository extends BaseRepository
{
    /**
     * @param \App\Models\Account $model
     */
    public function __construct(Account $model)
    {
        parent::__construct($model);
    }
}
