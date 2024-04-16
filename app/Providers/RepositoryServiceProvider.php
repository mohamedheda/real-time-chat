<?php

namespace App\Providers;

use App\Repository\ChatRoomMemberRepositoryInterface;
use App\Repository\ChatRoomRepositoryInterface;
use App\Repository\Eloquent\ChatRoomMemberRepository;
use App\Repository\Eloquent\ChatRoomRepository;
use App\Repository\Eloquent\MessageRepository;
use App\Repository\Eloquent\Repository;
use App\Repository\Eloquent\UserRepository;
use App\Repository\MessageRepositoryInterface;
use App\Repository\RepositoryInterface;
use App\Repository\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(RepositoryInterface::class, Repository::class);
        $this->app->singleton(UserRepositoryInterface::class, UserRepository::class);
        $this->app->singleton(ChatRoomRepositoryInterface::class, ChatRoomRepository::class);
        $this->app->singleton(ChatRoomMemberRepositoryInterface::class, ChatRoomMemberRepository::class);
        $this->app->singleton(MessageRepositoryInterface::class, MessageRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
