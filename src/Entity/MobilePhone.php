<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Hateoas\Configuration\Annotation as Hateoas;
use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MobilePhoneRepository")
 *
 * @Hateoas\Relation("self", href = @Hateoas\Route("show_phone", parameters = { "id" = "expr(object.getId())" },
 *                           absolute = true), exclusion = @Hateoas\Exclusion(groups={"list"}))
 * @Hateoas\Relation("list", href = @Hateoas\Route("list_mobile_phones", absolute = true), exclusion =
 *                           @Hateoas\Exclusion(groups={"details"}))
 */
class MobilePhone
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     *
     * @Groups({"list", "details"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"list", "details"})
     */
    private $brand;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Groups({"list", "details"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"list", "details"})
     */
    private $os;

    /**
     * @ORM\Column(type="float")
     * @Groups({"list", "details"})
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"details"})
     */
    private $screenSize;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"details"})
     */
    private $storage;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getOs(): ?string
    {
        return $this->os;
    }

    public function setOs(string $os): self
    {
        $this->os = $os;

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

    public function getScreenSize(): ?string
    {
        return $this->screenSize;
    }

    public function setScreenSize(?string $screenSize): self
    {
        $this->screenSize = $screenSize;

        return $this;
    }

    public function getStorage(): ?string
    {
        return $this->storage;
    }

    public function setStorage(?string $storage): self
    {
        $this->storage = $storage;

        return $this;
    }
}
