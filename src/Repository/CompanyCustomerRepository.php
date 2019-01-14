<?php

namespace App\Repository;

use App\Entity\CompanyCustomer;
use App\Exception\CompanyCustomerNotFoundException;
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

    /**
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\NoResultException
     */
    public function findOneCustomerByIdAndCompany(int $customerId, int $companyId)
    {
        return $this->createQueryBuilder('cc')
            ->addSelect('c')
            ->leftJoin('cc.company', 'c')
            ->andWhere('cc.id = :customerId')
            ->setParameter('customerId', $customerId)
            ->andWhere('c.id = :companyId')
            ->setParameter('companyId', $companyId)
            ->getQuery()
            ->getSingleResult();
    }

    public function insert(CompanyCustomer $customer)
    {
        $this->_em->persist($customer);
        $this->_em->flush();
    }

    public function delete(CompanyCustomer $customer)
    {
        $this->_em->remove($customer);
        $this->_em->flush();
    }
}
