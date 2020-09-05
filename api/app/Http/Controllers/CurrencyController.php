<?php

namespace App\Http\Controllers;

use App\Http\Resources\Currency;
use App\Repositories\CurrencyRepository;
use Exception;
use Illuminate\Http\JsonResponse;

class CurrencyController extends Controller
{
    /**
     * @var  CurrencyRepository
     */
    private $currencyRepository;

    /**
     * @param CurrencyRepository $currencyRepository
     */
    public function __construct(CurrencyRepository $currencyRepository)
    {
        $this->currencyRepository = $currencyRepository;
    }

    /**
     * @return JsonResponse
     */
    public function index()
    {
        try {
            $currencies = $this->currencyRepository->findAll();

            return $this->responseOk(Currency::collection($currencies));
        } catch (Exception $exception) {
            return $this->responseInternalError($exception->getMessage());
        }
    }
}
