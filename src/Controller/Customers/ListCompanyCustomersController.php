<?php

namespace App\Controller\Customers;

use App\Controller\AbstractApiController;
use App\Entity\CompanyCustomer;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\Routing\Annotation\Route;

class ListCompanyCustomersController extends AbstractApiController
{
    /**
     * Returns the list of a company's customers.
     *
     * @SWG\Response(response=200, description="Returns the list of all company customers",
     *     @SWG\Schema(type="array", @SWG\Items(ref=@Model(type=CompanyCustomer::class))))
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
     * @SWG\Tag(name="customers")
     *
     * @Route("/api/customers", name="list_company_customers", methods={"GET"})
     */
    public function list()
    {
        $company = $this->getUser();

        $customers = $this->getDoctrine()->getRepository(CompanyCustomer::class)->findBy(
            ['company' => $company->getId()]
        );

        return $this->createJsonResponse($customers);
    }
}
