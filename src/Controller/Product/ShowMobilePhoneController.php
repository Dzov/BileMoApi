<?php

namespace App\Controller\Product;

use App\Controller\AbstractApiController;
use App\Entity\MobilePhone;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @author Amélie Haladjian <amelie.haladjian@gmail.com>
 */
class ShowMobilePhoneController extends AbstractApiController
{
    /**
     * @Route("/api/phones/{id}", name="show_phone", methods={"GET"}, requirements={"id"="\d+"})
     * @Entity("MobilePhone", expr="repository.find(id)")
     */
    public function show(MobilePhone $phone)
    {
        return $this->createJsonResponse($phone, ['public']);
    }
}
