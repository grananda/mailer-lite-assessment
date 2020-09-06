<?php

namespace Tests\Unit\Services;

use App\Models\Currency;
use App\Services\CurrencyService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @coversNothing
 */
class CurrencyServiceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_amount_is_converted_within_the_same_currency()
    {
        // Given
        /** @var CurrencyService $service */
        $service = resolve(CurrencyService::class);

        /** @var Currency $currency */
        $currency = Currency::where('is_default', true)->first();

        $initialAmount = 100;

        // When
        $response = $service->convertAmount($initialAmount, $currency, $currency);

        // Then
        $this->assertEquals($initialAmount, $response);
    }

    /** @test */
    public function an_amount_is_converted_between_different_currencies()
    {
        // Given
        /** @var CurrencyService $service */
        $service = resolve(CurrencyService::class);

        /** @var Currency $currencyCanadianDollar */
        $currencyCanadianDollar = Currency::where('code', 'CAD')->first();

        /** @var Currency $currencyUsaDollar */
        $currencyUsaDollar = Currency::where('code', 'USD')->first();

        $initialAmount = 100;

        $finalAmount = $initialAmount / $currencyCanadianDollar->exchange_rate * $currencyUsaDollar->exchange_rate;

        // When
        $response = $service->convertAmount($initialAmount, $currencyCanadianDollar, $currencyUsaDollar);

        // Then
        $this->assertEquals($finalAmount, $response);
    }
}
