<?php

namespace App\Http\Controllers\Api\V1\Message;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Message\LoadMoreRequest;
use App\Http\Requests\Api\V1\Message\MessageRequest;
use App\Http\Services\Api\V1\Message\MessageService;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function __construct(
        private readonly MessageService $messageService
    ){

    }
    public function create(MessageRequest $request){
        return $this->messageService->create($request);
    }
    public function loadMore(LoadMoreRequest $request){
        return $this->messageService->loadMore($request);
    }
}
