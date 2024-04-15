<?php

namespace App\Repository\Eloquent;

use App\Models\User;
use App\Repository\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class UserRepository extends Repository implements UserRepositoryInterface
{
    protected Model $model;

    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function getActiveUsers()
    {
        return $this->model::query()->where('is_active', true);
    }

    public function getContacts()
    {
        $query = $this->model::query()
            ->whereNot('id', auth('api')->id());
        if (request()->search) {
            $query->where('name', 'LIKE', '%' . request()->search . '%')
                ->orWhere('email', 'LIKE', '%' . request()->search . '%');
        }
        return $query->get();
    }
}
