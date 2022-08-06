<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use App\Entity\Product;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $customer = new Customer();
        $customer->setPassword("motdepasse")
            ->setEmail("dev.dyger@gmail.com")
            ->setFullAddress("3 rue du test 01100 Oyonnax");
        $manager->persist($customer);

        $firstUser = new User();
        $firstUser->setUsername("firstUser")
            ->setPassword("password")
            ->setFirstName("Tom")
            ->setLastName("Cruise")
            ->setCustomer($customer);
        $manager->persist($firstUser);


        $secondUser = new User();
        $secondUser->setUsername("secondUser")
            ->setPassword("password")
            ->setFirstName("Test")
            ->setLastName("Second")
            ->setCustomer($customer);
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
