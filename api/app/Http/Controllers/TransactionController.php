<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionsListRequest;
use App\Http\Requests\TransactionsStoreRequest;
use App\Http\Resources\Transaction;
use App\Repositories\TransactionRepository;
use App\Services\TransactionService;
use Exception;
use Illuminate\Http\JsonResponse;
use Throwable;

class TransactionController extends Controller
{
    /**
     * @var TransactionRepository
     */
    private $transactionRepository;

    /**
     * @var TransactionService
     */
    private $transactionService;

    /**
     * TransactionController constructor.
     *
     * @param TransactionRepository $transactionRepository
     * @param TransactionService    $transactionService
     */
    public function __construct(TransactionRepository $transactionRepository, TransactionService $transactionService)
    {
        $this->transactionRepository = $transactionRepository;
        $this->transactionService    = $transactionService;
    }

    /**
     * @param TransactionsListRequest $request
     *
     * @return JsonResponse
     */
    public function index(TransactionsListRequest $request)
    {
        try {
            $transactions = $this->transactionRepository->findAllAccountRelatedTransactions($request->account);

            return $this->responseOk(Transaction::collection($transactions));
        } catch (Exception $exception) {
            return $this->responseInternalError($exception->getMessage());
        }
    }

    /**
     * @param TransactionsStoreRequest $request
     *
     * @throws Throwable
     *
     * @return JsonResponse
     */
    public function store(TransactionsStoreRequest $request)
    {
        try {
            $transaction = $this->transactionService->processTransaction($request->accountFrom, $request->accountTo, $request->amount, $request->details);

            return $this->responseOk(Transaction::make($transaction));
        } catch (Exception $exception) {
            return $this->responseInternalError($exception->getMessage());
        }
    }
}
