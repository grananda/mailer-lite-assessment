<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Currency extends JsonResource
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
            'id'            => $this->uuid,
            'symbol'        => $this->symbol,
            'symbol_native' => $this->symbol_native,
            'code'          => $this->code,
            'name'          => $this->name,
            'name_plural'   => $this->name_plural,
        ];
    }
}
