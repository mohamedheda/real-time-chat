<?php

namespace App\Http\Services\Api\V1\Auth;

use App\Http\Requests\Api\V1\Auth\ProviderRequest;
use App\Http\Requests\Api\V1\Auth\SignInRequest;
use App\Http\Requests\Api\V1\Auth\SignUpRequest;
use App\Http\Resources\V1\User\UserResource;
use App\Http\Services\Mutual\FileManagerService;
use App\Http\Services\PlatformService;
use App\Http\Traits\Responser;
use App\Models\User;
use App\Repository\UserRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite;
use Tymon\JWTAuth\Facades\JWTAuth;

abstract class AuthService extends PlatformService
{
    use Responser;

    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly FileManagerService $fileManagerService
    )
    {
    }

    public function signUp(SignUpRequest $request) {
        try {
            DB::beginTransaction();
            $data = $request->except('image');
            if($request->image)
                $data['image']=$this->fileManagerService->handle('image','users');

            $user = $this->userRepository->create($data);
            DB::commit();
            return $this->responseSuccess(message: __('messages.created successfully'), data: new UserResource($user, false));
        } catch (Exception $e) {
            DB::rollBack();
            //return $e;
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    public function provider(ProviderRequest $request) {
        try {
            DB::beginTransaction();
            $providerUser = Socialite::driver($request->provider)->userFromToken($request->access_provider_token);
            $user = User::firstOrCreate(
                [
                    'email' => $providerUser->getEmail()
                ],
                [
                    'name' => $providerUser->getName(),
                    'image' => $providerUser->getImage(),
                ]
            );
            $token = JWTAuth::fromUser($user);
            DB::commit();
            return $this->responseSuccess(message: __('messages.created successfully'), data: new UserResource($user, false));
        } catch (Exception $e) {
            DB::rollBack();
            return $e;
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }
    public function signIn(SignInRequest $request) {
        $credentials = $request->only('email', 'password');
        $token = auth('api')->attempt($credentials);
        if ($token) {
            return $this->responseSuccess(message: __('messages.Successfully authenticated'), data: new UserResource(auth('api')->user(), true));
        }

        return $this->responseFail(status: 401, message: __('messages.wrong credentials'));
    }

    public function signOut() {
        auth('api')->logout();
        return $this->responseSuccess(message: __('messages.Successfully loggedOut'));
    }

}
