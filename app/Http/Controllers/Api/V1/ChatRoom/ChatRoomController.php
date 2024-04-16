<?php

namespace App\Http\Controllers\Api\V1\ChatRoom;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\ChatRoom\ChatRoomRequest;
use App\Http\Services\Api\V1\ChatRoom\ChatRoomService;
use Illuminate\Http\Request;

class ChatRoomController extends Controller
{
    public function __construct(
        private readonly ChatRoomService $chatRoomService
    ){

    }
    public function index(){
        return $this->chatRoomService->index();
    }
    public function create(ChatRoomRequest $request){
        return $this->chatRoomService->create($request);
    }
    public function resetUnread($room_id){
        return $this->chatRoomService->resetUnread($room_id);
    }
}
