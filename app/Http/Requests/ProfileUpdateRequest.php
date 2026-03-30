<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'              => ['required', 'string', 'max:255'],
            'email'             => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            'avatar'            => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:10240'],
            'phone'             => ['nullable', 'string', 'max:20'],
            'emergency_contact' => ['nullable', 'string', 'max:20'],
            'address'           => ['nullable', 'string', 'max:500'],
            'birth_date'        => ['nullable', 'date'],
            'gender'            => ['nullable', 'in:male,female'],
            'national_id'       => ['nullable', 'string', 'max:20'],
            'bank_iban'         => ['nullable', 'string', 'max:34'],
        ];
    }
}
