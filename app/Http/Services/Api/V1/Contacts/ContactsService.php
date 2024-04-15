<?php

namespace App\Http\Services\Api\V1\Contacts;

use App\Http\Resources\V1\User\ContactResource;
use App\Http\Resources\V1\User\UserResource;
use App\Http\Traits\Responser;
use App\Models\User;
use App\Repository\UserRepositoryInterface;

class ContactsService
{
    use Responser;
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ){

    }
    public function index(){
        try {
            $users=$this->userRepository->getContacts();
            $appendix=[];
            if($users){
                foreach ($users as $user){
                    $firstLetter=substr($user->name,0,1);
                    $appendix[$firstLetter][]=ContactResource::make($user,false);
                }
            }
            return $this->responseSuccess(data: $appendix);
        }catch (\Exception $e){
//            return $e;
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }
}
