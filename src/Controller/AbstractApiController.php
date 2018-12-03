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
     * @param array|\ArrayObject $data
     */
    public function createJsonResponse($data): JsonResponse
    {
        $jsonData = $this->serializer->serialize($data, 'json', ['groups' => 'public']);

        return new JsonResponse($jsonData, Response::HTTP_OK, [], true);
    }
}
