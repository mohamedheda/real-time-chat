<?php

namespace App\Http\Services\Api\V1\Home;

use App\Http\Resources\V1\ChatRoom\ChatRoomGeneralResource;
use App\Http\Resources\V1\User\UserGeneralResource;
use App\Http\Traits\Responser;
use App\Repository\ChatRoomRepositoryInterface;
use App\Repository\UserRepositoryInterface;

class HomeService
{
    use Responser;
    public function __construct(
        private readonly ChatRoomRepositoryInterface $chatRoomRepository ,
        private readonly UserRepositoryInterface $userRepository ,
    ){

    }

    public function index(){
        $data=[
            'contacts'=> UserGeneralResource::collection($this->userRepository->getContacts()),
            'chatrooms'=> ChatRoomGeneralResource::collection($this->chatRoomRepository->getRooms())
        ];
        return $this->responseSuccess(data: $data);
    }
}
