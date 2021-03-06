<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CompanyRepository")
 *
 * @ExclusionPolicy("all")
 */
class Company extends User
{
    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $apiKey;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $apiPassword;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Expose
     */
    private $name;

    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    public function setApiKey(string $apiKey): self
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    public function getApiPassword(): string
    {
        return $this->apiPassword;
    }

    public function setApiPassword(string $apiPassword): self
    {
        $this->apiPassword = $apiPassword;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->apiPassword;
    }

    public function getUsername(): string
    {
        return $this->apiKey;
    }
}
