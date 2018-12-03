<?php

namespace App\Controller\Customers;

use App\Controller\AbstractApiController;
use App\Entity\CompanyCustomer;
use Symfony\Component\Routing\Annotation\Route;

class ListCompanyCustomersController extends AbstractApiController
{
    /**
     * @Route("/api/customers", name="list_company_customers", methods={"GET"})
     */
    public function list()
    {
        $company = $this->getUser();

        $customers = $this->getDoctrine()->getRepository(CompanyCustomer::class)->findBy(
            ['company' => $company->getId()]
        );

        return $this->createJsonResponse($customers, ['public']);
    }
}
