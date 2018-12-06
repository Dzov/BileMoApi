<?php

namespace App\Controller;

use App\Exception\InvalidFormDataException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @author Amélie Haladjian <amelie.haladjian@gmail.com>
 */
abstract class AbstractApiController extends AbstractController
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    public function __construct(SerializerInterface $serializer, ValidatorInterface $validator)
    {
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    public function createJsonResponse($data, array $groups = [], int $response = Response::HTTP_OK): JsonResponse
    {
        if (empty($data)) {
            return $this->createNotFoundResponse();
        }

        $jsonData = $this->serializer->serialize($data, 'json', ['groups' => $groups]);

        return new JsonResponse($jsonData, $response, [], true);
    }

    public function createNotFoundResponse(): JsonResponse
    {
        $errors['errors'] = [
            'status'  => 404,
            'message' => 'La ressource n\'existe pas',
        ];

        return new JsonResponse(json_encode($errors, 256), Response::HTTP_NOT_FOUND, [], true);
    }

    /**
     * @throws InvalidFormDataException
     */
    public function validate($data)
    {
        $errors = $this->validator->validate($data);

        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[$error->getPropertyPath()] = $error->getMessage();
            }

            throw new InvalidFormDataException($errorMessages);
        }
    }
}
