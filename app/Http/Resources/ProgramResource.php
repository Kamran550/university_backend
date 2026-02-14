<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProgramResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price_per_year' => $this->price_per_year,
            'degree' => $this->whenLoaded('degree', function () {
                return [
                    'id' => $this->degree->id,
                    'name' => $this->degree->name,
                ];
            }),
            'faculty' => $this->whenLoaded('faculty', function () {
                return [
                    'id' => $this->faculty->id,
                    'name' => $this->faculty->name,
                ];
            }),
            'is_thesis' => $this->is_thesis ? "Thesis" : "Without Thesis",
        ];
    }
}
