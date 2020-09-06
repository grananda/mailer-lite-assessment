<?php

namespace App\Services;

use App\Models\Currency;

class CurrencyService
{
    /**
     * @param          $amount
     * @param Currency $currencyFrom
     * @param Currency $currencyTo
     *
     * @return float
     */
    public function convertAmount($amount, Currency $currencyFrom, Currency $currencyTo)
    {
        return (float) ($amount / $currencyFrom->exchange_rate * $currencyTo->exchange_rate);
    }
}
