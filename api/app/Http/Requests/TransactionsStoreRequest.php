<?php

namespace App\Http\Requests;

use App\Models\Account;
use App\Rules\ValidAccountRule;

class TransactionsStoreRequest extends Request
{
    /**
     * @var Account
     */
    public $accountFrom;

    /**
     * @var Account
     */
    public $accountTo;

    /**
     * @var float
     */
    public $amount;

    /**
     * @var string
     */
    public $details;

    /**
     * @return bool
     */
    public function authorize()
    {
        $this->accountFrom = Account::findByUuidOrFail($this->route('id'));

        $this->accountTo = Account::where('account_number', $this->post('target_account'))->first();

        $this->amount = $this->post('amount');

        $this->details = $this->post('details');

        return true;
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'target_account' => [
                'required',
                'string',
                new ValidAccountRule(),
            ],
            'details' => [
                'nullable',
                'string',
            ],
            'amount' => [
                'required',
                'numeric',
                'min:1',
            ],
        ];
    }
}
