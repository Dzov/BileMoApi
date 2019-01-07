<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Hateoas\Configuration\Annotation as Hateoas;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @Hateoas\Relation("self", href = @Hateoas\Route("show_company_customer", parameters = { "id" =
 *                              "expr(object.getId())" }, absolute = true))
 * @Hateoas\Relation("list", href = @Hateoas\Route("list_company_customers", absolute = true))
 * @Hateoas\Relation("create", href = @Hateoas\Route("create_company_customer", absolute = true))
 * @Hateoas\Relation("delete", href = @Hateoas\Route("delete_company_customer", parameters = { "id" =
 *                             "expr(object.getId())" }, absolute = true))
 *
 * @Hateoas\Relation("company", embedded = @Hateoas\Embedded("expr(object.getCompany())"))
 *
 * @ORM\Entity(repositoryClass="App\Repository\CompanyCustomerRepository")
 * @UniqueEntity("email")
 *
 * @ExclusionPolicy("all")
 */
class CompanyCustomer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     *
     * @Expose
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Company")
     * @ORM\JoinColumn(nullable=false)
     */
    private $company;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\Email()
     * @Assert\NotBlank()
     *
     * @Expose
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     *
     * @Expose
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     *
     * @Expose
     */
    private $lastName;

    public function getId(): int
    {
        return $this->id;
    }

    public function getCompany(): Company
    {
        return $this->company;
    }

    public function setCompany(Company $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }
}
