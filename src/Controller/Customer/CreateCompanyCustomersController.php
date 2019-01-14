<?php

namespace App\Controller\Customer;

use App\Controller\AbstractApiController;
use App\Entity\CompanyCustomer;
use App\Manager\CompanyCustomer\CompanyCustomerManager;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class CreateCompanyCustomersController extends AbstractApiController
{
    /**
     * Creates a new customer tied to a company and returns it.
     *
     * @SWG\Response(response=201, description="Created", @SWG\Schema(type="array",
     *                             @SWG\Items(ref=@Model(type=CompanyCustomer::class))))
     * @SWG\Response(response=409, description="Conflict, invalid field")
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
     *     name="customer",
     *     in="body",
     *     required=true,
     *     schema= {"$ref": "#/definitions/companyCustomer"}
     * )
     *
     * @SWG\Tag(name="customers")
     *
     * @Route("/api/customers", name="create_company_customer", methods={"POST"})
     * @throws \App\Exception\InvalidFormDataException
     */
    public function create(Request $request, SerializerInterface $serializer, CompanyCustomerManager $manager)
    {
        $customer = $this->handleRequest($request->getContent(), $serializer);

        $manager->createCustomer($customer);

        return $this->createJsonResponse($customer, [], Response::HTTP_CREATED);
    }

    /**
     * @throws \App\Exception\InvalidFormDataException
     */
    private function handleRequest(string $data, SerializerInterface $serializer): CompanyCustomer
    {
        /** @var CompanyCustomer $customer */
        $customer = $serializer->deserialize($data, CompanyCustomer::class, 'json');
        $customer->setCompany($this->getUser());

        $this->validate($customer);

        return $customer;
    }
}
