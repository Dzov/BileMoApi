<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @author Amélie Haladjian <amelie.haladjian@gmail.com>
 */
abstract class AbstractApiController extends AbstractController
{
    public function createJsonResponse(array $data): JsonResponse
    {

    }

    public function serialize($object, SerializerInterface $serializer)
    {
        return $serializer->serialize($object, 'json');
    }
}
