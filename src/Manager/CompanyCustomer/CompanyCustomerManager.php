<?php

namespace App\Manager\CompanyCustomer;

use App\Entity\CompanyCustomer;
use App\Service\CompanyCustomer\CompanyCustomerCacheService;

/**
 * @author Amélie Haladjian <amelie.haladjian@gmail.com>
 */
class CompanyCustomerManager
{
    /**
     * @var CompanyCustomerCacheService
     */
    protected $cacheService;

    public function __construct(CompanyCustomerCacheService $cacheService)
    {
        $this->cacheService = $cacheService;
    }

    /**
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function createCustomer(CompanyCustomer $customer): void
    {
        $this->cacheService->createCompanyCustomer($customer);
    }

    /**
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function deleteCustomer(int $customerId, int $companyId): void
    {
        $this->cacheService->deleteCompanyCustomer($customerId, $companyId);
    }

    /**
     * @return CompanyCustomer[]
     */
    public function listCustomers(int $companyId): array
    {
        return $this->cacheService->getCompanyCustomers($companyId);
    }

    /**
     * @return CompanyCustomer
     */
    public function getCustomer(int $customerId, int $companyId): CompanyCustomer
    {
        return $this->cacheService->getCompanyCustomer($customerId, $companyId);
    }
}
