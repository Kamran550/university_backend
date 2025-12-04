<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DegreeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $faculties = collect();
        
        if ($this->relationLoaded('programs')) {
            $faculties = $this->programs
                ->pluck('faculty')
                ->filter()
                ->unique('id')
                ->values();
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'faculties' => FacultyResource::collection($faculties),
        ];
    }
}
