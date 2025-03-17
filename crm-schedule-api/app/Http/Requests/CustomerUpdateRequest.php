<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CustomerUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'       => 'nullable|string|max:255',
            'email'      => 'nullable|string|max:255|' . Rule::unique('customers')->ignore($this->id),
            'cellphone'  => 'nullable|string',
            'birthday'  => 'nullable|date_format:Y-m-d|before:' . now()->subYears(16)->toDateString()
        ];
    }
}
