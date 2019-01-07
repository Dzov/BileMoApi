<?php

namespace App\Repository;

use App\Entity\CompanyEmployee;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CompanyEmployee|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompanyEmployee|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompanyEmployee[]    findAll()
 * @method CompanyEmployee[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompanyEmployeeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CompanyEmployee::class);
    }
}
