<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRegistrationRequest extends FormRequest
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
        $locations = array_keys(config('registration.locations'));
        $programs = config('registration.programs');

        return [
            'full_name' => ['required', 'string', 'max:150'],
            'school' => ['required', 'string', 'max:150'],
            'phone' => ['required', 'string', 'max:20', 'regex:/^[0-9+\\s-]+$/'],
            'study_location' => ['required', 'string', 'in:' . implode(',', $locations)],
            'program' => ['required', 'string', 'in:' . implode(',', $programs)],
            'class_level' => ['required', 'string', 'max:50'],
            'permission_letter' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:4096'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'full_name' => trim((string) $this->input('full_name')),
            'school' => trim((string) $this->input('school')),
            'class_level' => trim((string) $this->input('class_level')),
            'phone' => preg_replace('/\\s+/', '', (string) $this->input('phone')),
        ]);
    }
}
