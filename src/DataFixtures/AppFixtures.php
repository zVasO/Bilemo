<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use App\Entity\Product;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{


    public function __construct(private readonly UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $customer = new Customer();
        $customer->setEmail("dev.dyger@gmail.com")
            ->setFullAddress("3 rue du test 01100 Oyonnax");
        $manager->persist($customer);

        $firstUser = new User();
        $firstUser->setEmail("dev.dyger@gmail.com")
            ->setPassword($this->passwordHasher->hashPassword($firstUser, "motdepasse"))
            ->setFirstName("Tom")
            ->setLastName("Cruise")
            ->setCustomer($customer)
            ->setRoles(['ROLE_USER', 'ROLE_MANAGER']);
        $manager->persist($firstUser);


        $secondUser = new User();
        $secondUser->setEmail("defv.dyger@gmail.com")
            ->setPassword($this->passwordHasher->hashPassword($secondUser, "motdepasse"))
            ->setFirstName("Test")
            ->setLastName("Second")
            ->setCustomer($customer)
            ->setRoles(['ROLE_USER']);
        $manager->persist($secondUser);


        $firstProduct = new Product();
        $firstProduct->setDescription("Lorem la description")
            ->setName("Iphone 11")
            ->setBrand("Apple")
            ->setColor("Red")
            ->setPrice(1000.99)
            ->setRam(4)
            ->setScreenSize(6)
            ->setStorage(128);
        $manager->persist($firstProduct);


        $secondProduct = new Product();
        $secondProduct->setDescription("Lorem la description")
            ->setName("Galaxy 13")
            ->setBrand("Samsung")
            ->setColor("Blue")
            ->setPrice(1200.99)
            ->setRam(6)
            ->setScreenSize(7)
            ->setStorage(512);
        $manager->persist($secondProduct);

        $manager->flush();
    }
}
