<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/api/users', name: 'users', methods: ['GET'])]
    public function getAllUser(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/UserController.php',
        ]);
    }

    #[Route('/api/users/{id}', name: 'detail_user', methods: ['GET'])]
    public function getDetailUser(int $id): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller detail!',
            'path' => 'src/Controller/UserController.php',
        ]);
    }

    #[Route('/api/users', name: 'create_user', methods: ['POST'])]
    public function createUser(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller creation!',
            'path' => 'src/Controller/UserController.php',
        ]);
    }

    #[Route('/api/users/{id}', name: 'delete_user', methods: ['DELETE'])]
    public function deleteUser(int $id): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller delete!',
            'path' => 'src/Controller/UserController.php',
        ]);
    }
}
