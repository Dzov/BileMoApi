<?php

namespace App\Controller\Customers;

use App\Entity\CompanyCustomer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ShowCompanyCustomerController extends AbstractController
{
    /**
     * @Route("/api/customers/{id}", name="show_company_customer", methods={"GET"}, requirements={"id"="\d+"})
     * @Entity("CompanyCustomer", expr="repository.find(id)"))
     */
    public function show(SerializerInterface $serializer, CompanyCustomer $customer)
    {
        $company = $this->getUser();

        $customer = $this->getDoctrine()->getRepository(CompanyCustomer::class)->findOneByCompany(
            $company->getId(),
            $customer->getId()
        );

        $data = $serializer->serialize($customer, 'json');

        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }
}
