<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=>$this->id,
            "category"=>new CategoryResource($this->category),
            "amount"=>number_format($this->amount/100,2),
            "description"=>$this->description,
            "transaction_date"=>Carbon::parse($this->date)->format('d/m/y'),
        ];
    }
}
