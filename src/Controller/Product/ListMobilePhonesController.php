<?php

namespace App\Controller\Product;

use App\Entity\MobilePhone;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ListMobilePhonesController extends AbstractController
{
    /**
     * @Route("/api/phones", name="list_mobile_phones")
     */
    public function list(SerializerInterface $serializer)
    {
        $phones = $this->getDoctrine()->getRepository(MobilePhone::class)->findAll();

        $data = $serializer->serialize($phones, 'json');

        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }
}
