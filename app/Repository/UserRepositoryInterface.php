<?php

namespace App\Repository;

interface UserRepositoryInterface extends RepositoryInterface
{
    public function getActiveUsers();
    public function getContacts();
    public function updateLastSeen();
}
