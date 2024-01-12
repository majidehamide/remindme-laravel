<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\BaseRepository;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function getByEmail($email): ?User
    {
        return $this->model::where('email', $email)->first();
    }

    public function create($data): ?User
    {
        return $this->model::create($data);
    }

}
