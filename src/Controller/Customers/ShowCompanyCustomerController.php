<?php

namespace App\Controller\Customers;

use App\Controller\AbstractApiController;
use App\Entity\CompanyCustomer;
use Nelmio\ApiDocBundle\Annotation\Model;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Swagger\Annotations as SWG;
use Symfony\Component\Routing\Annotation\Route;

class ShowCompanyCustomerController extends AbstractApiController
{
    /**
     * Returns a specific customer.
     *
     * @SWG\Response(response=200, description="Returns the customer", @SWG\Schema(type="array",
     *                             @SWG\Items(ref=@Model(type=CompanyCustomer::class)))))
     * @SWG\Response(response=404, description="The resource does not exist")
     *
     * @SWG\Parameter(
     *     name="Authorization",
     *     in="header",
     *     required=true,
     *     type="string",
     *     default="Bearer {jwt}",
     *     description="Your Json Web Token"
     * )
     *
     * @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     type="integer",
     *     description="The field used to identify a specific customer within a company"
     * )
     *
     * @SWG\Tag(name="customers")
     *
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
