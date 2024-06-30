<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "title"=>$this->title,
            "description"=>$this->description,
            "created_at"=>Carbon::parse($this->created_at)->format("d/m/y H:i:s"),
            "updated_at"=>Carbon::parse($this->updated_at)->format('d/m/Y H:i:s')
        ];
    }
}
