<?php

namespace App\Controller\Product;

use App\Controller\AbstractApiController;
use App\Entity\MobilePhone;
use Symfony\Component\Routing\Annotation\Route;

class ListMobilePhonesController extends AbstractApiController
{
    /**
     * @Route("/api/phones", name="list_mobile_phones", methods={"GET"})
     */
    public function list()
    {
        $phones = $this->getDoctrine()->getRepository(MobilePhone::class)->findAll();

        return $this->createJsonResponse($phones);
    }
}
