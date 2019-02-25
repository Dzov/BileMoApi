<?php

namespace App\Service\CompanyCustomer;

use App\Entity\CompanyCustomer;
use App\Repository\CompanyCustomerRepository;
use App\Service\AbstractCacheService;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @author Amélie Haladjian <amelie.haladjian@gmail.com>
 */
class CompanyCustomerCacheService extends AbstractCacheService
{
    const COMPANY_ID  = 'companyId';

    const CUSTOMER_ID = 'customerId';

    /**
     * @var CompanyCustomerRepository
     */
    private $repository;

    public function __construct(CompanyCustomerRepository $repository, AdapterInterface $cache)
    {
        parent::__construct($cache);
        $this->repository = $repository;
    }

    public function getCompanyCustomers(int $companyId)
    {
        return $this->getCacheList([self::COMPANY_ID => $companyId]);
    }

    public function getCompanyCustomer(int $customerId, int $companyId)
    {
        return $this->getCacheItem([self::CUSTOMER_ID => $customerId, self::COMPANY_ID => $companyId]);
    }

    /**
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function deleteCompanyCustomer(int $customerId, int $companyId)
    {
        $this->removeCacheItem([self::CUSTOMER_ID => $customerId, self::COMPANY_ID => $companyId]);
    }

    /**
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function createCompanyCustomer(CompanyCustomer $customer): void
    {
        $this->repository->insert($customer);
        $this->clearCache();
    }

    protected function getItemKey(array $parameters = []): ?string
    {
        if (isset($parameters[CompanyCustomerCacheService::CUSTOMER_ID])) {
            return 'customers.' . $parameters[CompanyCustomerCacheService::CUSTOMER_ID];
        }

        return null;
    }

    protected function getListKey(): string
    {
        return 'customers.list';
    }

    protected function getItem(array $parameters = []): CompanyCustomer
    {
        return $this->findByIdAndCompany($parameters);
    }

    /**
     * @return CompanyCustomer[]
     */
    protected function getList(array $parameters = []): array
    {
        return $this->repository->findBy(
            ['company' => $parameters[CompanyCustomerCacheService::COMPANY_ID]]
        );
    }

    protected function removeItem(array $parameters = []): void
    {
        $customer = $this->findByIdAndCompany($parameters);

        $this->repository->delete($customer);
    }

    protected function findByIdAndCompany(array $parameters = []): CompanyCustomer
    {
        try {
            return $this->repository->findOneCustomerByIdAndCompany(
                $parameters[CompanyCustomerCacheService::CUSTOMER_ID],
                $parameters[CompanyCustomerCacheService::COMPANY_ID]
            );
        } catch (NoResultException $e) {
            throw new NotFoundHttpException();
        } catch (NonUniqueResultException $e) {
        }
    }
}
