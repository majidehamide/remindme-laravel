<?php

namespace App\Services\UserService;

use App\DataTransferObjects\StoreUserDTO;
use App\Models\User;
use App\Repositories\User\UserRepositoryInterface;

class UserService implements UserServiceInterface
{
    protected $userRepository;
    
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function create(StoreUserDTO $storeUserDTO):User{
        return $this->userRepository->create($storeUserDTO->toArray());
    }
    public function getByEmail($email):?User{
        return $this->userRepository->getByEmail($email);
    }
}
