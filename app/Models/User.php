<?php

namespace App\Models;

use App\Repository\ChatRoomRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'image',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function token()
    {
        return JWTAuth::fromUser($this);
    }

    public function imageUrl(): Attribute
    {
        return Attribute::make(get: fn() => $this->image != null ? url($this->image)
            : Cache::rememberForever('default_user_image', fn() => url('storage/users/default.jpeg')));
    }

    public function isActive() :Attribute
    {
        return Attribute::make(get: function () {
            return Carbon::parse($this->last_seen )->isLastMinute() ? 'online' : 'offline';
        });
    }
    public function lastSeenValue() :Attribute
    {
        return Attribute::make(get: function () {
            return $this->last_seen != null ? Carbon::parse($this->last_seen)->diffForHumans() : null;
        });
    }


    public function chatrooms()
    {
        return $this->hasMany(ChatRoomMember::class, 'user_id');
    }

    public function rooms()
    {
        return $this->hasManyThrough(ChatRoom::class, ChatRoomMember::class, 'chat_room_id', 'id');
    }


}
