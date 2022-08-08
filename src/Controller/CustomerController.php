<?php

namespace App\Controller;

use App\Service\CustomerService;
use Exception;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CustomerController extends AbstractController
{
    public function __construct(private readonly CustomerService $customerService, private readonly SerializerInterface $serializer)
    {
    }


    /**
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('/api/customers', name: 'customers', methods: ['GET'])]
    public function getAllCustomer(): JsonResponse
    {
        try {
            $customers = $this->customerService->getAllCustomer();
            $context = SerializationContext::create()->setGroups(["customerList"]);
            $jsonCustomers = $this->serializer->serialize($customers, 'json', $context);
            return new JsonResponse($jsonCustomers, Response::HTTP_OK, [], true);
        } catch (Exception $exception) {
            return new JsonResponse($exception->getMessage(), $exception->getCode(), []);
        }
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    #[Route('/api/customers/{id}', name: 'customers_details', methods: ['GET'])]
    public function getCustomerById(int $id): JsonResponse
    {
        try {
            $customer = $this->customerService->getCustomerById($id);
            $context = SerializationContext::create()->setGroups(["customerDetails"]);
            $jsonCustomer = $this->serializer->serialize($customer, 'json', $context);
            return new JsonResponse($jsonCustomer, Response::HTTP_OK, [], true);
        } catch (Exception $exception) {
            return new JsonResponse($exception->getMessage(), $exception->getCode(), []);
        }
    }
}
