<?php

namespace Tests\Feature\AccountController;

use App\Models\Account;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @coversNothing
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
        $response = $this->get(route('api.account.show', $account->uuid));
        $data     = json_decode($response->content())->data;
        // Then
        $response->assertOk();

        $this->assertEquals($account->uuid, $data->id);
    }
}
