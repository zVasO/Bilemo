<?php

namespace App\Service;

use App\Entity\Customer;
use App\Repository\CustomerRepository;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class CustomerService
{

    public function __construct(private readonly CustomerRepository $customerRepository)
    {
    }

    /**
     * @return Customer[]
     * @throws Exception
     */
    public function getAllCustomer(): array
    {
        $allCustomer = $this->customerRepository->findAll();
        if (empty($allCustomer)) {
            throw new Exception("No content", Response::HTTP_NO_CONTENT);
        }
        return $allCustomer;
    }

    /**
     * @param int $id
     * @return Customer
     * @throws Exception
     */
    public function getCustomerById(int $id): Customer
    {
        $customer = $this->customerRepository->find($id);
        if (null === $customer) {
            throw new Exception("No content", Response::HTTP_NO_CONTENT);
        }
        return $customer;
    }
}
