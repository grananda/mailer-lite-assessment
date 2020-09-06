<?php

namespace Tests\Unit\Rules;

use App\Models\Account;
use App\Rules\ValidAccountRule;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

/**
 * @coversNothing
 */
class ValidAccountRuleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_valid_account_passes_validation_rule()
    {
        // Given
        /** @var Account $account */
        $account = factory(Account::class)->create();

        // Then
        $this->assertTrue($this->validator(['target_account' => $account->account_number])->passes());
    }

    /** @test */
    public function a_valid_account_fails_validation_rule()
    {
        // Then
        $this->assertFalse($this->validator(['target_account' => $this->faker->bankAccountNumber])->passes());
    }

    /**
     * @param array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    private function validator(array $data)
    {
        $rules = [
            'target_account' => [
                'required',
                'string',
                new ValidAccountRule(),
            ],
        ];

        return Validator::make($data, $rules);
    }
}
