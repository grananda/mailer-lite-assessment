<?php

namespace Tests\Feature\CurrencyController;

use App\Models\Currency;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @covers \App\Http\Controllers\CurrencyController::index
 */
class ListTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_list_of_currencies_is_displayed_with_200_code()
    {
        // When
        $response = $this->api()->get(route('api.currency.index'));

        // Then
        $response->assertOk();
        $response->assertJsonCount(Currency::count());
    }
}
