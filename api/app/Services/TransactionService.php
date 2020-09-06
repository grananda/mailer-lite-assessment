<?php

namespace App\Services;

use App\Exceptions\InsufficientFundsException;
use App\Exceptions\TransactionExecutionException;
use App\Models\Account;
use App\Models\Transaction;
use App\Repositories\AccountRepository;
use App\Repositories\TransactionRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Throwable;

class TransactionService
{
    /**
     * @var CurrencyService
     */
    private $currencyService;

    /**
     * @var AccountRepository
     */
    private $accountRepository;

    /**
     * @var TransactionRepository
     */
    private $transactionRepository;

    /**
     * @param CurrencyService                         $currencyService
     * @param AccountRepository                       $accountRepository
     * @param \App\Repositories\TransactionRepository $transactionRepository
     */
    public function __construct(CurrencyService $currencyService, AccountRepository $accountRepository, TransactionRepository $transactionRepository)
    {
        $this->currencyService       = $currencyService;
        $this->accountRepository     = $accountRepository;
        $this->transactionRepository = $transactionRepository;
    }

    /**
     * @param \App\Models\Account $accountFrom
     * @param \App\Models\Account $accountTo
     * @param                     $amount
     * @param                     $details
     *
     * @throws InsufficientFundsException
     * @throws TransactionExecutionException
     * @throws Throwable
     *
     * @return void|Transaction
     */
    public function processTransaction(Account $accountFrom, Account $accountTo, $amount, $details)
    {
        if ($accountFrom->balance < $amount) {
            $transaction = $this->transactionRepository->createTransaction($accountFrom, $accountTo, $amount, $details, false);

            throw new InsufficientFundsException("Insufficient funds to complete requested transaction: {$transaction->uuid}}");
        }

        try {
            DB::beginTransaction();

            $amountTarget = $this->currencyService->convertAmount($amount, $accountFrom->currency, $accountTo->currency);

            $transaction = $this->transactionRepository->createTransaction($accountFrom, $accountTo, $amount, $details, true);

            $this->accountRepository->update($accountFrom, [
                'balance' => $accountFrom->balance - $amount,
            ]);

            $this->accountRepository->update($accountTo, [
                'balance' => $accountTo->balance + $amountTarget,
            ]);

            DB::commit();

            return $transaction;
        } catch (Exception $transactionException) {
            throw new TransactionExecutionException($transactionException->getMessage());
        }
    }
}
