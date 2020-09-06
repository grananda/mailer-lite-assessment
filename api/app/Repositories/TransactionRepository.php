<?php

namespace App\Repositories;

use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Collection;
use Throwable;

class TransactionRepository extends BaseRepository
{
    /**
     * @param Transaction $model
     */
    public function __construct(Transaction $model)
    {
        parent::__construct($model);
    }

    /**
     * @param \App\Models\Account $accountFrom
     * @param \App\Models\Account $accountTo
     * @param                     $amount
     * @param                     $details
     * @param bool                $status
     *
     * @throws Throwable
     *
     * @return Transaction
     */
    public function createTransaction(Account $accountFrom, Account $accountTo, $amount, $details, $status = true)
    {
        /** @var Transaction $transaction */
        $transaction = $this->create([
            'amount'  => $amount,
            'details' => $details,
            'status'  => $status,
        ]);

        $transaction->ownerAccount()->associate($accountFrom);
        $transaction->targetAccount()->associate($accountTo);

        $transaction->save();

        return $transaction;
    }

    /**
     * @param Account $account
     *
     * @return Collection
     */
    public function findAllAccountRelatedTransactions(Account $account)
    {
        return $this->getQuery()
            ->whereHas('ownerAccount', function ($query) use ($account) {
                $query->where('id', $account->id);
            })
            ->orWhereHas('targetAccount', function ($query) use ($account) {
                $query->where('id', $account->id);
            })
            ->get()
        ;
    }
}
