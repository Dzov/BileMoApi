<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @author Amélie Haladjian <amelie.haladjian@gmail.com>
 */
abstract class AbstractApiController extends AbstractController
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param array|Object $data
     */
    public function createJsonResponse($data): JsonResponse
    {
        if (empty($data)) {
            return $this->createNotFoundResponse();
        }

        $jsonData = $this->serializer->serialize($data, 'json', ['groups' => 'public']);

        return new JsonResponse($jsonData, Response::HTTP_OK, [], true);
    }

    private function createNotFoundResponse(): JsonResponse
    {
        $data = [
            'message' => 'La ressource n\'existe pas',
        ];

        return new JsonResponse(json_encode($data, 256), Response::HTTP_NOT_FOUND, [], true);
    }
}
