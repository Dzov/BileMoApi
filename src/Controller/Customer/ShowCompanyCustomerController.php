<?php

namespace App\Controller\Customer;

use App\Controller\AbstractApiController;
use App\Entity\CompanyCustomer;
use App\Manager\CompanyCustomer\CompanyCustomerManager;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

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
     *     default="Bearer JWT_TOKEN",
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
     */
    public function show(int $id, CompanyCustomerManager $manager, UserInterface $user)
    {
        $customer = $manager->getCustomer($id, $user->getId());

        return $this->createJsonResponse($customer);
    }
}
