<?php

namespace Tests\Feature\AccountController;

use App\Models\Account;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @covers \App\Http\Controllers\AccountController::show
 */
class ShowTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_single_account_is_returned_by_id_with_200_code()
    {
        // Given
        /** @var Account $account */
        $account = factory(Account::class)->create();

        // When
        $response = $this->api()->get(route('api.account.show', $account->account_number));

        // Then
        $response->assertOk();
        $response->assertJsonFragment(['id' => $account->uuid]);
    }
}
