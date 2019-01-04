<?php

namespace App\Controller\Customers;

use App\Controller\AbstractApiController;
use App\Entity\CompanyCustomer;
use App\Exception\CompanyCustomerNotFoundException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Swagger\Annotations as SWG;
use SwaggerFixures\Customer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @author Amélie Haladjian <amelie.haladjian@gmail.com>
 */
class DeleteCompanyCustomersController extends AbstractApiController
{
    /**
     * Deletes a customer.
     *
     * @SWG\Response(response=200, description="Deleted")
     * @SWG\Response(response=404, description="The resource does not exist")
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
     * @Route("/api/customers/{id}", name="delete_company_customer", methods={"DELETE"}, requirements={"id"="\d+"})
     * @Entity("CompanyCustomer", expr="repository.find(id)"))
     */
    public function delete(CompanyCustomer $customer): JsonResponse
    {
        try {
            $company = $this->getUser();
            $customer = $this->getDoctrine()->getRepository(CompanyCustomer::class)
                ->findOneCustomerByIdAndCompany($customer->getId(), $company->getId());

            $this->deleteCustomer($customer);

            $message = ['status' => Response::HTTP_OK, 'message' => 'The resource has been deleted'];

            return $this->createJsonResponse($message);
        } catch (CompanyCustomerNotFoundException $e) {
            throw new NotFoundHttpException();
        }
    }

    private function deleteCustomer(Customer $customer): void
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($customer);
        $entityManager->flush();
    }
}
