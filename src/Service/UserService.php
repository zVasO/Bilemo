<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class UserService
{

    public function __construct(private readonly UserRepository $userRepository)
    {
    }


    /**
     * @return User[]
     * @throws Exception
     */
    public function getAllUser(): array
    {
        $usersList = $this->userRepository->findAll();
        if (empty($usersList)) {
            throw new Exception("No content", Response::HTTP_NO_CONTENT);
        }
        return $usersList;
    }

    /**
     * @param int $id
     * @return User
     * @throws Exception
     */
    public function getUserDetail(int $id): User
    {
        $user = $this->userRepository->find($id);
        if ($user === null) {
            throw new Exception("No content", Response::HTTP_NO_CONTENT);
        }
        return $user;
    }

    /**
     * @param array $userInformation
     * @return void
     */
    public function createUser(array $userInformation): void
    {
        $newUser = new User();
        $newUser->setUsername($userInformation["email"])
            ->setPassword($userInformation["password"])
            ->setFirstName($userInformation["firstname"])
            ->setLastName($userInformation["lastname"])
            ->setCustomer($userInformation["customer"]);

        $this->userRepository->add($newUser, true);
    }

    /**
     * @param int $id
     * @return void
     * @throws Exception
     */
    public function deleteUser(int $id): void
    {
        $user = $this->userRepository->find($id);
        if ($user === null) {
            throw new Exception("No content", Response::HTTP_NO_CONTENT);
        }
        $this->userRepository->remove($user, true);
    }
}
