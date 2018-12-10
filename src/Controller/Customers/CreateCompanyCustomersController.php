<?php

namespace App\Controller\Customers;

use App\Controller\AbstractApiController;
use App\Entity\CompanyCustomer;
use App\Exception\InvalidFormDataException;
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
     *     name="customer",
     *     in="body",
     *     required=true,
     *     schema= {"$ref": "#/definitions/companyCustomer"}
     * )
     *
     * @SWG\Tag(name="customers")
     *
     * @Route("/api/customers", name="create_company_customer", methods={"POST"})
     */
    public function create(Request $request, SerializerInterface $serializer)
    {
        $data = $request->getContent();
        /** @var CompanyCustomer $customer */
        $customer = $serializer->deserialize($data, CompanyCustomer::class, 'json');
        $customer->setCompany($this->getUser());

        try {
            $errors['errors'] = [];
            if ($this->userAlreadyExists($customer)) {
                $errors['errors'] = ['status' => 409, 'message' => ['email' => 'This email address already exists']];
            }

            $this->validate($customer);

            if (!empty($errors['errors'])) {
                return $this->createJsonResponse($errors, Response::HTTP_CONFLICT);
            }

            $this->createCustomer($customer);

            return $this->createJsonResponse($customer, Response::HTTP_CREATED);
        } catch (InvalidFormDataException $e) {
            foreach ($e->getErrors() as $key => $error) {
                $errors['errors']['message'][$key] = $error;
            }

            return $this->createJsonResponse($errors, Response::HTTP_CONFLICT);
        }
    }

    private function userAlreadyExists(CompanyCustomer $customer): bool
    {
        return null !== $this->getDoctrine()->getRepository(CompanyCustomer::class)->findOneBy(
                ['email' => $customer->getEmail()]
            );
    }

    private function createCustomer($customer): void
    {
        $em = $this->getDoctrine()->getManager();
        $em->persist($customer);
        $em->flush();
    }
}
