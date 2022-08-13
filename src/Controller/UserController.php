<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\UserService;
use App\Service\ValidatorService;
use Exception;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;

class UserController extends AbstractController
{


    public function __construct(private readonly UserService $userService, private readonly  SerializerInterface $serializer)
    {
    }

    /**
     *   This method return the list of all users.
     *
     * @OA\Response(
     *     response=200,
     *     description="Return the list of all users",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=User::class, groups={"getUser"}))
     *     )
     * )
     * @OA\Tag(name="User")
     *
     * @return JsonResponse
     */
    #[Route('/api/users', name: 'users', methods: ['GET'])]
    public function getAllUser(): JsonResponse
    {
        try {
            $users = $this->userService->getAllUser();
            $context = SerializationContext::create()->setGroups(["userList", "getUser"]);
            $jsonUsers = $this->serializer->serialize($users, 'json', $context);
            return new JsonResponse($jsonUsers, Response::HTTP_OK, [], true);
        } catch (Exception $exception) {
            return new JsonResponse($exception->getMessage(), $exception->getCode(), []);
        }
    }

    /**
     *   This method return the detail of a user.
     *
     * @OA\Response(
     *     response=200,
     *     description="Return the detail of a user",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=User::class, groups={"getUser"}))
     *     )
     * )
     * @OA\Tag(name="User")
     * @param int $id
     * @return JsonResponse
     */
    #[Route('/api/users/{id}', name: 'detail_user', methods: ['GET'])]
    public function getDetailUser(int $id): JsonResponse
    {
        try {
            $user = $this->userService->getUserDetail($id);
            $this->denyAccessUnlessGranted('CAN_ACCESS', $user);
            $context = SerializationContext::create()->setGroups(["userDetails", "getUser"]);
            $jsonUser = $this->serializer->serialize($user, 'json', $context);
            return new JsonResponse($jsonUser, Response::HTTP_OK, [], true);
        } catch (Exception $exception) {
            return new JsonResponse($exception->getMessage(), $exception->getCode(), []);
        }
    }

    /**
     *   This method create a user.
     *
     * @OA\Response(
     *     response=200,
     *     description="Return create a user",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=User::class, groups={"getUser"}))
     *     )
     * )
     * @OA\Tag(name="User")
     * @param Request $request
     * @return JsonResponse
     */
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


    /**
     *   This method delete a user.
     *
     * @OA\Response(
     *     response=200,
     *     description="Return delete a user",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=User::class, groups={"getUser"}))
     *     )
     * )
     * @OA\Tag(name="User")
     * @param int $id
     * @return JsonResponse
     */
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
