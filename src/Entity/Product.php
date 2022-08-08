<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["productList"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["productList", "productDetails"])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(["productList", "productDetails"])]
    private ?string $brand = null;

    #[ORM\Column]
    #[Groups(["productList", "productDetails"])]
    private ?float $screenSize = null;

    #[ORM\Column]
    #[Groups(["productList", "productDetails"])]
    private ?int $ram = null;

    #[ORM\Column]
    #[Groups(["productList", "productDetails"])]
    private ?int $storage = null;

    #[ORM\Column(length: 255)]
    #[Groups(["productList", "productDetails"])]
    private ?string $color = null;

    #[ORM\Column]
    #[Groups(["productList"])]
    private ?float $price = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(["productList"])]
    private ?string $description = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getScreenSize(): ?float
    {
        return $this->screenSize;
    }

    public function setScreenSize(float $screenSize): self
    {
        $this->screenSize = $screenSize;

        return $this;
    }

    public function getRam(): ?int
    {
        return $this->ram;
    }

    public function setRam(int $ram): self
    {
        $this->ram = $ram;

        return $this;
    }

    public function getStorage(): ?int
    {
        return $this->storage;
    }

    public function setStorage(int $storage): self
    {
        $this->storage = $storage;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
