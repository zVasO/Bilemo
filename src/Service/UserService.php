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
     * return all users of the same customer (customer of logged user)
     * @return User[]
     * @throws Exception
     */
    public function getAllUserOfTheSameCustomer(User $connectedUser): array
    {
        $customer = $connectedUser->getCustomer();
        return $customer->getUsers()->toArray();
    }

    /**
     * @param int $id
     * @return User|null
     */
    public function getUserDetail(int $id): ?User
    {
        return $this->userRepository->find($id);
    }

    /**
     * @param array $userInformation
     * @param User $manager
     * @return void
     * @throws Exception
     */
    public function createUser(array $userInformation, User $manager): void
    {
        $newUser = new User();
        $newUser->setEmail($userInformation["email"])
            ->setPassword($userInformation["password"])
            ->setFirstName($userInformation["firstname"])
            ->setLastName($userInformation["lastname"])
            ->setCustomer($manager->getCustomer())
            ->setRoles(["ROLE_USER"]);

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
