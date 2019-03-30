<?php

namespace App\Controller\Customer;

use App\Controller\AbstractApiController;
use App\Entity\CompanyCustomer;
use App\Manager\CompanyCustomer\CompanyCustomerManager;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

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
     *     default="Bearer JWT_TOKEN",
     *     description="Your Json Web Token"
     * )
     *
     * @SWG\Tag(name="customers")
     *
     * @Route("/api/customers", name="list_company_customers", methods={"GET"})
     */
    public function list(CompanyCustomerManager $manager, UserInterface $user)
    {
        $customers = $manager->listCustomers($user->getId());

        return $this->createJsonResponse($customers);
    }
}
