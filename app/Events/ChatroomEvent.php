<?php

namespace App\Events;

use App\Http\Resources\V1\ChatRoom\ChatRoomGeneralResource;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChatroomEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public $chat_room;
    public function __construct($room)
    {
        $this->chat_room=ChatRoomGeneralResource::make($room);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('private.chatrooms.'.auth('api')->id()),
        ];
    }
    public function broadcastAs()
    {
        return 'new.chatroom';
    }
}
