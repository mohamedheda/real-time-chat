<?php

namespace App\Http\Resources\V1\Message;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageGeneralResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id ,
            'type' => $this->type ,
            'content' => $this->content ,
            'created_at' => $this->createdTime ,
            'direction' => $this->direction ,
        ];
    }
}
