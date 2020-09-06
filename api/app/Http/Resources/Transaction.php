<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Transaction extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'account_from' => $this->ownerAccount->account_number,
            'account_to'   => $this->targetAccount->account_number,
            'amount'       => $this->ownerAccount->currency->symbol.number_format($this->amount, 2),
            'status'       => $this->status ? 'Completed' : 'Failed',
            'details'      => $this->details,
            'date'         => $this->created_at->format('Y/m/d H:s'),
        ];
    }
}
