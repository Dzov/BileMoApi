<?php

namespace App\Repository;

use App\Entity\CompanyCustomer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CompanyCustomer|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompanyCustomer|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompanyCustomer[]    findAll()
 * @method CompanyCustomer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompanyCustomerRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CompanyCustomer::class);
    }
}
