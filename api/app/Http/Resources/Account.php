<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Account extends JsonResource
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
            'account_number' => $this->account_number,
            'owner'          => User::make($this->owner),
            'currency'       => Currency::make($this->currency),
            'balance'        => $this->account_number,
        ];
    }
}
