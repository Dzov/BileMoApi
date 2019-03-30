<?php

namespace App\Controller\Customer;

use App\Controller\AbstractApiController;
use App\Entity\CompanyCustomer;
use App\Manager\CompanyCustomer\CompanyCustomerManager;
use Doctrine\ORM\NoResultException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @author Amélie Haladjian <amelie.haladjian@gmail.com>
 */
class DeleteCompanyCustomersController extends AbstractApiController
{
    /**
     * Deletes a customer.
     *
     * @SWG\Response(response=200, description="The resource has been deleted")
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
     * @Route("/api/customers/{id}", name="delete_company_customer", methods={"DELETE"}, requirements={"id"="\d+"})
     * @Entity("CompanyCustomer", expr="repository.find(id)"))
     */
    public function delete(
        CompanyCustomer $customer,
        CompanyCustomerManager $manager,
        UserInterface $user
    ): JsonResponse {
        try {
            $customerId = $customer->getId();
            $manager->deleteCustomer($customerId, $user->getId());

            return $this->createJsonResponse([]);
        } catch (NoResultException $e) {
            throw new NotFoundHttpException();
        }
    }
}
