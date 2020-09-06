<?php

namespace App\Http\Requests;

use App\Models\Account;

class TransactionsListRequest extends Request
{
    /**
     * @var Account
     */
    public $account;

    /**
     * @return bool
     */
    public function authorize()
    {
        $this->account = Account::where('account_number', $this->route('id'))->firstOrFail();

        return true;
    }
}
