<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\ApplicationTypeEnum;
use Illuminate\Validation\Rule;
use App\Enums\DegreeTypeEnum;
use App\Enums\GenderEnum;


class TransferApplicationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    protected function prepareForValidation(): void
    {
        $this->merge([
            'applicant_type' => ApplicationTypeEnum::TRANSFER->value,
        ]);
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
            'program_id' => ['required', 'integer', 'exists:programs,id'],
            'degree_id' => ['required', 'integer', 'exists:degrees,id'],
            // Student personal information
            'passport_number' => ['required', 'string', 'max:50'],
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
            'email' => ['required', 'email', 'max:255', Rule::unique('student_applications', 'email')],
            
            // Address
            'country' => ['required', 'string', 'max:100'],
            'city' => ['required', 'string', 'max:100'],
            'address_line' => ['required', 'string'],
            
            // Documents (files)
            'photo_id' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
            'profile_photo' => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:5120'],
            'high_school_diploma' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
            'high_school_transcript' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
            'bachelor_diploma' => ['nullable', 'file', 'max:5120'],
            'bachelor_transcript' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
            'master_diploma' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
            'master_transcript' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
            'teachingLanguage' => ['required', 'string', 'max:50'],
            // Optional metadata
            'locale' => ['nullable', 'string', 'max:5'],
            'degree_type' => ['required', 'string', 'max:50'],
            'current_university' => ['required', 'string', 'max:255'],
            'current_course' => ['required', 'integer', 'min:1', 'max:10'],
        ];
    }
}