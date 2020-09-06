<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountShowRequest;
use App\Http\Resources\Account;
use App\Repositories\AccountRepository;
use Exception;
use Illuminate\Http\JsonResponse;

class AccountController extends Controller
{
    /**
     * @var AccountRepository
     */
    private $accountRepository;

    /**
     * AccountController constructor.
     *
     * @param AccountRepository $accountRepository
     */
    public function __construct(AccountRepository $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $accounts = $this->accountRepository->findAll();

            return $this->responseOk(Account::collection($accounts));
        } catch (Exception $exception) {
            return $this->responseInternalError($exception->getMessage());
        }
    }

    /**
     * @param AccountShowRequest $request
     *
     * @return JsonResponse
     */
    public function show(AccountShowRequest $request)
    {
        try {
            return $this->responseOk(Account::make($request->account));
        } catch (Exception $exception) {
            return $this->responseInternalError($exception->getMessage());
        }
    }
}
