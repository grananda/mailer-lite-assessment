<?php

namespace Tests\Feature\TransactionController;

use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @covers \App\Http\Controllers\TransactionController::index
 */
class ListTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_list_of_account_related_transactions_is_returned_with_200_code()
    {
        // Given
        /** @var Account $account1 */
        $account1 = factory(Account::class)->create();

        /** @var Account $account2 */
        $account2 = factory(Account::class)->create();

        /** @var Account $account3 */
        $account3 = factory(Account::class)->create();

        /** @var Transaction $transaction1 */
        $transaction1 = factory(Transaction::class)->create([
            'account_from_id' => $account1->id,
            'account_to_id'   => $account2->id,
        ]);

        /** @var Transaction $transaction2 */
        $transaction2 = factory(Transaction::class)->create([
            'account_from_id' => $account2->id,
            'account_to_id'   => $account1->id,
        ]);

        /** @var Transaction $transaction3 */
        $transaction3 = factory(Transaction::class)->create([
            'account_from_id' => $account3->id,
            'account_to_id'   => $account2->id,
        ]);

        // When
        $response = $this->api()->get(route('api.transaction.index', $account1->uuid));

        // Then
        $response->assertOk();
        $response->assertJsonFragment(['account_from' => $account1->account_number]);
        $response->assertJsonFragment(['account_from' => $account2->account_number]);
        $response->assertJsonMissing(['account_from' => $account3->account_number]);
    }
}
