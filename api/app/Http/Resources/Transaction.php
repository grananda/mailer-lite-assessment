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
            'id'             => $this->uuid,
            'owner_account'  => Account::make($this->ownerAccount),
            'target_account' => Account::make($this->targetAccount),
            'amount'         => $this->amount,
            'status'         => $this->status,
            'created_at'     => $this->created_at,
        ];
    }
}
