<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function direction(): Attribute
    {
        return Attribute::make(get: fn() => $this->user_id == auth('api')->id() ? 'right' : 'left');
    }

    public function getContentAttribute($value)
    {
        return $this->type != 'TEXT' ? url($value) : $value;
    }
}
