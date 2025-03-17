<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class MeetingCreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string|ValidationRule|array>
     */
    public function rules(): array
    {
        return [
            'subject'         => 'required|string',
            'description'     => 'nullable|string|max:350',
            'meeting_start'   => 'required|date_format:Y-m-d H:i|after:now',
            'meeting_end'     => 'nullable|date_format:Y-m-d H:i|after:meeting_start',
            'participants_id' => 'nullable|array|exists:customers,id',
        ];
    }
}
