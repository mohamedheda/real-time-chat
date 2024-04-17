<?php

namespace App\Http\Requests\Api\V1\Message;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LoadMoreRequest extends FormRequest
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
            'chat_room_id' => ['required', Rule::exists('chat_rooms', 'id')],
            'last_message_id' => ['required', Rule::exists('messages', 'id')],
        ];
    }
}
