<?php

namespace App\Controller\Customers;

use App\Entity\CompanyCustomer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ListCompanyCustomersController extends AbstractController
{
    /**
     * @Route("/api/customers", name="list_company_customers")
     */
    public function list(SerializerInterface $serializer)
    {
        $company = $this->getUser();

        $customers = $this->getDoctrine()->getRepository(CompanyCustomer::class)->findAllByCompany($company->getId());

        $data = $serializer->serialize($customers, 'json');

        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }
}
