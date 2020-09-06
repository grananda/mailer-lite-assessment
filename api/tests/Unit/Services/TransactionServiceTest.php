<?php

namespace Tests\Unit\Services;

use App\Exceptions\InsufficientFundsException;
use App\Exceptions\SameAccountTransactionForbiddenException;
use App\Models\Account;
use App\Models\Currency;
use App\Services\TransactionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @coversNothing
 */
class TransactionServiceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_transaction_between_two_accounts_is_completed()
    {
        // Given
        /** @var TransactionService $service */
        $service = resolve(TransactionService::class);

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
        $service->processTransaction($account1, $account2, $transactionAmount, $this->faker->text);

        // Then
        $this->assertDatabaseHas('accounts', [
            'id'      => $account1->id,
            'balance' => $initialAccount1Balance - $transactionAmount,
        ]);
        $this->assertDatabaseHas('accounts', [
            'id'      => $account2->id,
            'balance' => $initialAccount2Balance + $transactionAmount,
        ]);
        $this->assertDatabaseHas('transactions', [
            'status'          => true,
            'account_from_id' => $account1->id,
            'account_to_id'   => $account2->id,
            'amount'          => $transactionAmount,
        ]);
    }

    /** @test */
    public function a_transaction_between_two_accounts_of_different_currencies_is_completed()
    {
        // Given
        /** @var TransactionService $service */
        $service = resolve(TransactionService::class);

        /** @var Currency $currencyCanadianDollar */
        $currencyCanadianDollar = Currency::where('code', 'CAD')->first();

        /** @var Currency $currencyUsaDollar */
        $currencyUsaDollar = Currency::where('code', 'USD')->first();

        $initialAccount1Balance = 100;

        /** @var Account $account1 */
        $account1 = factory(Account::class)->create([
            'balance'     => $initialAccount1Balance,
            'currency_id' => $currencyCanadianDollar->id,
        ]);

        $initialAccount2Balance = 200;

        /** @var Account $account2 */
        $account2 = factory(Account::class)->create([
            'balance'     => $initialAccount2Balance,
            'currency_id' => $currencyUsaDollar->id,
        ]);

        $transactionAmount = 50;

        $transactionAmountTarget = $transactionAmount / $currencyCanadianDollar->exchange_rate * $currencyUsaDollar->exchange_rate;

        // When
        $service->processTransaction($account1, $account2, $transactionAmount, $this->faker->text);

        // Then
        $this->assertDatabaseHas('accounts', [
            'id'      => $account1->id,
            'balance' => $initialAccount1Balance - $transactionAmount,
        ]);
        $this->assertDatabaseHas('accounts', [
            'id'      => $account2->id,
            'balance' => $initialAccount2Balance + $transactionAmountTarget,
        ]);
        $this->assertDatabaseHas('transactions', [
            'status'          => true,
            'account_from_id' => $account1->id,
            'account_to_id'   => $account2->id,
            'amount'          => $transactionAmount,
        ]);
    }

    /** @test */
    public function a_transaction_between_two_accounts_failed_because_of_insufficient_funds()
    {
        // Given
        $this->expectException(InsufficientFundsException::class);

        /** @var TransactionService $service */
        $service = resolve(TransactionService::class);

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
        $service->processTransaction($account1, $account2, $transactionAmount, $this->faker->text);

        // Then
        $this->assertDatabaseHas('accounts', [
            'id'      => $account1->id,
            'balance' => $account1->balance,
        ]);
        $this->assertDatabaseHas('transactions', [
            'id'      => $account2->id,
            'balance' => $account2->balance,
        ]);
        $this->assertDatabaseHas('transactions', [
            'status'          => false,
            'account_from_id' => $account1->id,
            'account_to_id'   => $account2->id,
            'amount'          => $transactionAmount,
        ]);
    }

    /** @test */
    public function a_transaction_between_two_accounts_failed_because_they_are_the_same_account()
    {
        // Given
        $this->expectException(SameAccountTransactionForbiddenException::class);

        /** @var TransactionService $service */
        $service = resolve(TransactionService::class);

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
        $service->processTransaction($account1, $account1, $transactionAmount, $this->faker->text);

        // Then
        $this->assertDatabaseHas('accounts', [
            'id'      => $account1->id,
            'balance' => $account1->balance,
        ]);
    }
}
