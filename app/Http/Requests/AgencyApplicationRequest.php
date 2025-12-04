<?php

namespace App\Http\Requests;

class AgencyApplicationRequest extends ApiFormRequest
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
            
            // Agency information
            'agency_name' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:100'],
            'city' => ['required', 'string', 'max:100'],
            'address' => ['required', 'string'],
            'website' => ['nullable', 'url', 'max:255'],
            
            // Contact person
            'contact_name' => ['required', 'string', 'max:100'],
            'contact_phone' => ['required', 'string', 'max:20'],
            'contact_email' => ['required', 'email', 'max:255'],
            
            // Documents (files)
            'business_license' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
            'company_logo' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
            
            // Optional metadata
            'locale' => ['nullable', 'string', 'max:5'],
        ];
    }
}
