<?php

namespace App\Http\Requests\Api\V1\Message;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MessageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    private $file = [

        'IMAGE' => [
            'file' => ['required', 'image', 'max:10000']
        ],
        'TEXT' => [
            'content' => ['required'],
        ],
        'FILE' => [
            'file' => ['required', 'mimes:pdf', 'max:10000']
        ],
        'RECORD' => [
            'file' => ['required', 'mimes:mp3', 'max:10000']
        ],
    ];

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
            'type' => ['required', Rule::in(['TEXT', 'FILE', 'IMAGE', 'RECORD'])],
            ...$this->file[$this->type],
        ];
    }
}
