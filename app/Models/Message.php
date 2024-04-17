<?php

namespace App\Models;

use Carbon\Carbon;
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
    public function createdTime(): Attribute
    {
        return Attribute::make(get: function (){
            $time=Carbon::parse($this->created_at);
            if($time->isToday())
                return $time->format('h:i A');
            else
                return $time->format('M d, h:i A');
        } );
    }

    public function typeValue(): Attribute
    {
        return Attribute::make(get: function (){
            return __('messages.'.strtolower($this->type));
        });
    }

    public function getContentAttribute($value)
    {
        return $this->type != 'TEXT' ? url($value) : $value;
    }
}
