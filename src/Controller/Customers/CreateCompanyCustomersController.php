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
                return $this->createJsonResponse($errors, [], Response::HTTP_CONFLICT);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($customer);
            $em->flush();

            return $this->createJsonResponse($customer, ['public'], Response::HTTP_CREATED);
        } catch (InvalidFormDataException $e) {
            foreach ($e->getErrors() as $key => $error) {
                $errors['errors']['message'][$key] = $error;
            }

            return $this->createJsonResponse($errors, [], Response::HTTP_CONFLICT);
        }
    }

    private function userAlreadyExists(CompanyCustomer $customer): bool
    {
        return null !== $this->getDoctrine()->getRepository(CompanyCustomer::class)->findOneBy(
                ['email' => $customer->getEmail()]
            );
    }
}
