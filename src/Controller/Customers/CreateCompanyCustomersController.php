<?php

namespace App\Controller\Customers;

use App\Controller\AbstractApiController;
use App\Entity\CompanyCustomer;
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
    public function create(Request $request, SerializerInterface $serializer)
    {
        $data = $request->getContent();
        /** @var CompanyCustomer $customer */
        $customer = $serializer->deserialize($data, CompanyCustomer::class, 'json');
        $customer->setCompany($this->getUser());

        $this->validate($customer);

        $this->createCustomer($customer);

        $this->invalidateCache('customers.list');

        return $this->createJsonResponse($customer, [], Response::HTTP_CREATED);
    }

    private function createCustomer($customer): void
    {
        $em = $this->getDoctrine()->getManager();
        $em->persist($customer);
        $em->flush();
    }
}
