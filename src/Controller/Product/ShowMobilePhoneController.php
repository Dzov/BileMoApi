<?php

namespace App\Controller\Product;

use App\Entity\MobilePhone;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @author Amélie Haladjian <amelie.haladjian@gmail.com>
 */
class ShowMobilePhoneController extends AbstractController
{
    /**
     * @Route("/api/phones/{id}", name="show_phone", methods={"GET"}, requirements={"id"="\d+"})
     * @Entity("MobilePhone", expr="repository.find(id)")
     */
    public function show(MobilePhone $phone, SerializerInterface $serializer)
    {
        $data = $serializer->serialize($phone, 'json');

        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }
}
