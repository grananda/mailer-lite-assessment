<?php

namespace Tests\Feature\AccountController;

use App\Models\Account;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @coversNothing
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
        $response = $this->get(route('api.account.index'));
        $data     = json_decode($response->content())->data;
        // Then
        $response->assertOk();

        $this->assertCount(5, $data);
    }
}
