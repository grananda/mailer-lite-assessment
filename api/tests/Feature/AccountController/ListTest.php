<?php

namespace Tests\Feature\AccountController;

use App\Models\Account;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @covers \App\Http\Controllers\AccountController::index
 */
class ListTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_list_of_accounts_is_returned_with_200_code()
    {
        // Given
        factory(Account::class, 5)->create();

        // When
        $response = $this->api()->get(route('api.account.index'));

        // Then
        $response->assertOk();
        $response->assertJsonCount(5);
    }
}
