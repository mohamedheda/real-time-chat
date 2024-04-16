<?php

namespace App\Repository\Eloquent;

use App\Models\Message;
use App\Repository\MessageRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class MessageRepository extends Repository implements MessageRepositoryInterface
{
    public function __construct(Message $model)
    {
        parent::__construct($model);
    }
}
