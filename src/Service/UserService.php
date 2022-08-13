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
     * @param User $manager
     * @return void
     * @throws Exception
     */
    public function createUser(array $userInformation, User $manager): void
    {
        if ($this->ensureEmailExist($userInformation["email"]))
        {
            throw new Exception("This email is already linked to an user, u should try with an other email", Response::HTTP_NOT_ACCEPTABLE);
        }
        $newUser = new User();
        $newUser->setEmail($userInformation["email"])
            ->setPassword($userInformation["password"])
            ->setFirstName($userInformation["firstname"])
            ->setLastName($userInformation["lastname"])
            ->setCustomer($manager->getCustomer());

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
            throw new Exception("No content", Response::HTTP_NOT_FOUND);
        }
        $this->userRepository->remove($user, true);
    }

    /**
     * @param string $email
     * @return bool
     */
    public function ensureEmailExist(string $email): bool
    {
        $user = $this->userRepository->findOneBy(["email" => $email]);
        if ($user === null) {
            return false;
        }
        return true;
    }
}
