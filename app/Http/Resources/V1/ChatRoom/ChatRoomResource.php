<?php

namespace App\Http\Resources\V1\ChatRoom;

use App\Http\Resources\V1\Message\MessageResource;
use App\Http\Resources\V1\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatRoomResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user' => UserResource::make($this->other_member, false),
            'messages' => $this->whenLoaded('messages', MessageResource::collection($this->messages)),
        ];
    }
}
