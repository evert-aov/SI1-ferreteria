<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'gender' => ['required', 'in:male,female'],
            'address' => ['nullable', 'string', 'max:500'],
            'document_type' => ['required', 'in:CI,NIT,PASSPORT'],
            'document_number' => [
                'required',
                'string',
                'max:20',
                Rule::unique(User::class)->ignore($this->user()->id)
            ]
        ];
    }
}
