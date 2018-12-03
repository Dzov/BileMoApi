<?php

namespace App\Controller\Customers;

use App\Controller\AbstractApiController;
use App\Entity\CompanyCustomer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Component\Routing\Annotation\Route;

class ShowCompanyCustomerController extends AbstractApiController
{
    /**
     * @Route("/api/customers/{id}", name="show_company_customer", methods={"GET"}, requirements={"id"="\d+"})
     * @Entity("CompanyCustomer", expr="repository.find(id)"))
     */
    public function show(CompanyCustomer $customer)
    {
        $company = $this->getUser();

        $customer = $this->getDoctrine()->getRepository(CompanyCustomer::class)->findOneBy(
            ['company' => $company->getId(), 'id' => $customer->getId()]
        );

        return $this->createJsonResponse($customer);
    }
}
