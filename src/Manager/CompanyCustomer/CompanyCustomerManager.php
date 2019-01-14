<?php

namespace App\Manager\CompanyCustomer;

use App\Entity\CompanyCustomer;
use App\Manager\AbstractManager;
use App\Repository\CompanyCustomerRepository;
use Symfony\Component\Cache\Adapter\AdapterInterface;

/**
 * @author Amélie Haladjian <amelie.haladjian@gmail.com>
 */
class CompanyCustomerManager extends AbstractManager
{
    /**
     * @var CompanyCustomerRepository
     */
    private $repository;

    public function __construct(CompanyCustomerRepository $repository, AdapterInterface $cache)
    {
        parent::__construct($cache);
        $this->repository = $repository;
    }

    public function createCustomer(CompanyCustomer $customer): void
    {
        $this->repository->insert($customer);
        $this->invalidateCache('customers.list');
    }

    /**
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function deleteCustomer(int $customerId, int $companyId): void
    {
        $customer = $this->repository->findOneCustomerByIdAndCompany($customerId, $companyId);

        $this->repository->delete($customer);
        $this->invalidateCache('customers.list');
    }

    /**
     * @return CompanyCustomer[]
     */
    public function listCustomers(int $companyId): array
    {
        $cacheItem = $this->cacheItem('customers.list');

        if (!$cacheItem->isHit()) {
            $customers = $this->repository->findBy(['company' => $companyId]);;

            $this->setCacheItem($cacheItem, $customers);
        }

        return $cacheItem->get();
    }

    public function showCustomer(int $customerId, int $companyId): CompanyCustomer
    {
        $cacheItem = $this->cacheItem('customers.' . $customerId);

        if (!$cacheItem->isHit()) {
            $customer = $this->repository->findOneBy(['id' => $customerId, 'company' => $companyId]);

            $this->setCacheItem($cacheItem, $customer);
        }

        return $cacheItem->get();
    }
}
