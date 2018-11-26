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

    public function findAllByCompany(int $companyId)
    {
        return $this->createQueryBuilder('cc')
            ->select('cc.firstName, cc.lastName, cc.email')
            ->addSelect('c.name AS company')
            ->leftJoin('cc.company', 'c')
            ->andWhere('c.id = :id')
            ->setParameter('id', $companyId)
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return CompanyCustomer[] Returns an array of CompanyCustomer objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CompanyCustomer
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
