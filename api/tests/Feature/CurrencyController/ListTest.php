<?php

namespace Tests\Feature\CurrencyController;

use App\Models\Currency;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @coversNothing
 */
class ListTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_list_of_currencies_is_displayed()
    {
        // When
        $response = $this->get(route('api.currency.index'));
        $data     = json_decode($response->content())->data;

        // Then
        $this->assertCount(Currency::count(), $data);
    }
}
