<?php

namespace App\Http\Resources\V1\ChatRoom;

use App\Http\Resources\V1\Message\MessageGeneralResource;
use App\Http\Resources\V1\Message\MessageResource;
use App\Http\Resources\V1\User\UserGeneralResource;
use App\Http\Resources\V1\User\UserResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatRoomGeneralResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'chat_room_id' => $this->id,
            'unread_count' => $this->authedMember?->unread_count,
            'lastMessageContent' => $this->lastMessageContent,
            'last_update' => Carbon::parse($this->updated_at)->diffForHumans(),
            'user' => UserGeneralResource::make($this->otherMember?->user , false),
        ];
    }
}
