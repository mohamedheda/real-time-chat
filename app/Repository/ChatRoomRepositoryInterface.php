<?php

namespace App\Repository;

interface ChatRoomRepositoryInterface extends RepositoryInterface
{
    public function checkRoomExist($user_id);
    public function getRoom($user_id);
    public function getRooms();
    }
