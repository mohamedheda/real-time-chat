<?php

use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Api\V1\ChatRoom\ChatRoomController;
use App\Http\Controllers\Api\V1\Contacts\ContactsController;
use App\Http\Controllers\Api\V1\Message\MessageController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth', 'controller' => AuthController::class], function () {
    Route::group(['prefix' => 'sign'], function () {
        Route::post('provider', 'provider');
        Route::post('in', 'signIn');
        Route::post('up', 'signUp');
        Route::post('out', 'signOut');
    });
    Route::get('what-is-my-platform', 'whatIsMyPlatform'); // returns 'platform: mobile!'
});
Route::group(['middleware'=> 'auth:api'],function (){
    Route::get('contacts' ,[ContactsController::class,'index']);
    Route::get('unread/{chat_room}/reset' ,[ChatRoomController::class,'resetUnread']);
    Route::post('chatroom' ,[ChatRoomController::class,'create']);
    Route::get('chatroom' ,[ChatRoomController::class,'index']);
    Route::post('message' ,[MessageController::class,'create']);
});
