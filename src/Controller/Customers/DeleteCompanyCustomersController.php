<?php

namespace App\Controller\Customers;

use App\Controller\AbstractApiController;
use App\Entity\CompanyCustomer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @author Amélie Haladjian <amelie.haladjian@gmail.com>
 */
class DeleteCompanyCustomersController extends AbstractApiController
{
    /**
     * @Route("/api/customers/{id}", name="delete_company_customer", methods={"DELETE"}, requirements={"id"="\d+"})
     * @Entity("CompanyCustomer", expr="repository.find(id)"))
     */
    public function delete(CompanyCustomer $customer)
    {
        $company = $this->getUser();
        $customer = $this->getDoctrine()->getRepository(CompanyCustomer::class)->findOneBy(
            ['company' => $company->getId(), 'id' => $customer->getId()]
        );

        if (null === $customer) {
            return $this->createNotFoundResponse();
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($customer);
        $entityManager->flush();

        $message = ['status' => 200, 'message' => 'The ressource has been deleted'];

        return $this->createJsonResponse($message, []);
    }
}
