<?php

namespace App\Controller\Customers;

use App\Controller\AbstractApiController;
use App\Entity\CompanyCustomer;
use App\Exception\InvalidFormDataException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class CreateCompanyCustomersController extends AbstractApiController
{
    /**
     * @Route("/api/customers", name="create_company_customer", methods={"POST"})
     */
    public function create(Request $request, SerializerInterface $serializer)
    {
        $data = $request->getContent();
        $customer = $serializer->deserialize($data, CompanyCustomer::class, 'json');
        $customer->setCompany($this->getUser());

        try {
            $this->validate($customer);

            $em = $this->getDoctrine()->getManager();
            $em->persist($customer);
            $em->flush();

            return $this->createJsonResponse($customer, ['public'], Response::HTTP_CREATED);
        } catch (InvalidFormDataException $e) {
            return $this->createJsonResponse($e->getErrors(), [], Response::HTTP_CONFLICT);
        }
    }
}
