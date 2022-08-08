<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\UserService;
use App\Service\ValidatorService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class UserController extends AbstractController
{


    public function __construct(private readonly UserService $userService, private readonly  SerializerInterface $serializer)
    {
    }

    #[Route('/api/users', name: 'users', methods: ['GET'])]
    public function getAllUser(): JsonResponse
    {
        try {
            $users = $this->userService->getAllUser();
            $jsonUsers = $this->serializer->serialize($users, 'json', ["groups" => "userList"]);
            return new JsonResponse($jsonUsers, Response::HTTP_OK, [], true);
        } catch (Exception $exception) {
            return new JsonResponse($exception->getMessage(), $exception->getCode(), []);
        }
    }

    #[Route('/api/users/{id}', name: 'detail_user', methods: ['GET'])]
    public function getDetailUser(int $id): JsonResponse
    {
        try {
            $user = $this->userService->getUserDetail($id);
            $jsonUser = $this->serializer->serialize($user, 'json', ["groups" => "userDetails"]);
            return new JsonResponse($jsonUser, Response::HTTP_OK, [], true);
        } catch (Exception $exception) {
            return new JsonResponse($exception->getMessage(), $exception->getCode(), []);
        }
    }

    #[Route('/api/users', name: 'create_user', methods: ['POST'])]
    public function createUser(Request $request): JsonResponse
    {
       try {
           /** @var User $manager */
           $manager = $this->getUser();
           if (null !== $manager) {
               $userInformation = json_decode($request->getContent(), true);
               ValidatorService::validateCreateUserArray($userInformation);
               $this->userService->createUser($userInformation, $manager);
               return new JsonResponse("User correctly added", Response::HTTP_OK, []);
           }
       } catch (Exception $exception) {
           return new JsonResponse($exception->getMessage(), $exception->getCode(), []);
       }
    }

    #[Route('/api/users/{id}', name: 'delete_user', methods: ['DELETE'])]
    public function deleteUser(int $id): JsonResponse
    {
        try {
           $this->userService->deleteUser($id);
            return new JsonResponse("User correctly deleted", Response::HTTP_OK, []);
        } catch (Exception $exception) {
            return new JsonResponse($exception->getMessage(), $exception->getCode(), []);
        }
    }
}
