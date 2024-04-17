<?php

namespace App\Repository;

interface MessageRepositoryInterface extends RepositoryInterface
{
    public function loadMoreMessages($chat_room_id, $last_message_id);
}
