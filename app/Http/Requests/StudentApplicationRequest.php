<?php

namespace App\Http\Requests;

use App\Enums\GenderEnum;
use Illuminate\Validation\Rule;

class StudentApplicationRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Application fields
            'degree_id' => ['required', 'integer', 'exists:degrees,id'],
            'faculty_id' => ['required', 'integer', 'exists:faculties,id'],
            
            // Student personal information
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'father_name' => ['required', 'string', 'max:100'],
            'gender' => ['required', Rule::enum(GenderEnum::class)],
            'date_of_birth' => ['required', 'date', 'before:today'],
            'place_of_birth' => ['required', 'string', 'max:100'],
            'nationality' => ['required', 'string', 'max:100'],
            'native_language' => ['required', 'string', 'max:50'],
            
            // Contact information
            'phone' => ['required', 'string', 'max:20'],
            'email' => ['required', 'email', 'max:255'],
            
            // Address
            'country' => ['required', 'string', 'max:100'],
            'city' => ['required', 'string', 'max:100'],
            'address_line' => ['required', 'string'],
            
            // Documents (file paths)
            'photo_id_path' => ['nullable', 'max:255'],
            'profile_photo_path' => ['nullable', 'max:255'],
            'diploma_path' => ['nullable', 'max:255'],
            'transcript_path' => ['required', 'max:255'],
            
            // Optional metadata
            'locale' => ['nullable', 'string', 'max:5'],
        ];
    }
}
