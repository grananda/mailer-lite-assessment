<?php

namespace Tests\Feature\TransactionController;

use App\Models\Account;
use App\Models\Currency;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

/**
 * @covers \App\Http\Controllers\TransactionController::store
 */
class StoreTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_transaction_is_successfully_processed_with_200_code()
    {
        // Given

        /** @var Currency $currency */
        $currency = Currency::where('is_default', true)->first();

        $initialAccount1Balance = 100;

        /** @var Account $account1 */
        $account1 = factory(Account::class)->create([
            'balance'     => $initialAccount1Balance,
            'currency_id' => $currency->id,
        ]);

        $initialAccount2Balance = 200;

        /** @var Account $account2 */
        $account2 = factory(Account::class)->create([
            'balance'     => $initialAccount2Balance,
            'currency_id' => $currency->id,
        ]);

        $transactionAmount = 50;

        // When

        $response = $this->api()->post(route('api.transaction.store', $account1->uuid), [
            'target_account' => $account2->account_number,
            'details'        => $this->faker->text,
            'amount'         => $transactionAmount,
        ]);

        // Then
        $response->assertOk();
        $response->assertJsonFragment(['account_from' => $account1->account_number]);
        $response->assertJsonFragment(['account_to' => $account2->account_number]);
    }

    /** @test */
    public function a_transaction_is_rejected_with_non_minimum_amount_with_422_code()
    {
        // Given

        /** @var Currency $currency */
        $currency = Currency::where('is_default', true)->first();

        $initialAccount1Balance = 100;

        /** @var Account $account1 */
        $account1 = factory(Account::class)->create([
            'balance'     => $initialAccount1Balance,
            'currency_id' => $currency->id,
        ]);

        $initialAccount2Balance = 200;

        /** @var Account $account2 */
        $account2 = factory(Account::class)->create([
            'balance'     => $initialAccount2Balance,
            'currency_id' => $currency->id,
        ]);

        $transactionAmount = 0.5;

        // When

        $response = $this->api()->post(route('api.transaction.store', $account1->uuid), [
            'target_account' => $account2->account_number,
            'details'        => $this->faker->text,
            'amount'         => $transactionAmount,
        ]);

        // Then
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function a_transaction_is_rejected_with_a_non_existing_target_account_with_422_code()
    {
        // Given

        /** @var Currency $currency */
        $currency = Currency::where('is_default', true)->first();

        $initialAccount1Balance = 100;

        /** @var Account $account1 */
        $account1 = factory(Account::class)->create([
            'balance'     => $initialAccount1Balance,
            'currency_id' => $currency->id,
        ]);

        $transactionAmount = 0.5;

        // When

        $response = $this->api()->post(route('api.transaction.store', $account1->uuid), [
            'target_account' => $this->faker->bankAccountNumber,
            'details'        => $this->faker->text,
            'amount'         => $transactionAmount,
        ]);

        // Then
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function a_transaction_is_canceled_due_to_insufficient_balance_with_500_code()
    {
        // Given
        /** @var Currency $currency */
        $currency = Currency::where('is_default', true)->first();

        $initialAccount1Balance = 10;

        /** @var Account $account1 */
        $account1 = factory(Account::class)->create([
            'balance'     => $initialAccount1Balance,
            'currency_id' => $currency->id,
        ]);

        $initialAccount2Balance = 200;

        /** @var Account $account2 */
        $account2 = factory(Account::class)->create([
            'balance'     => $initialAccount2Balance,
            'currency_id' => $currency->id,
        ]);

        $transactionAmount = 50;

        // When

        $response = $this->api()->post(route('api.transaction.store', $account1->uuid), [
            'target_account' => $account2->account_number,
            'details'        => $this->faker->text,
            'amount'         => $transactionAmount,
        ]);

        // Then
        $response->assertStatus(Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /** @test */
    public function a_transaction_is_canceled_when_both_accounts_are_the_same_with_500_code()
    {
        // Given
        /** @var Currency $currency */
        $currency = Currency::where('is_default', true)->first();

        $initialAccount1Balance = 100;

        /** @var Account $account1 */
        $account1 = factory(Account::class)->create([
            'balance'     => $initialAccount1Balance,
            'currency_id' => $currency->id,
        ]);

        $transactionAmount = 50;

        // When

        $response = $this->api()->post(route('api.transaction.store', $account1->uuid), [
            'target_account' => $account1->account_number,
            'details'        => $this->faker->text,
            'amount'         => $transactionAmount,
        ]);

        // Then
        $response->assertStatus(Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
