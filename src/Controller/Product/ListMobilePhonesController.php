<?php

namespace App\Controller\Product;

use App\Controller\AbstractApiController;
use App\Entity\MobilePhone;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;

class ListMobilePhonesController extends AbstractApiController
{
    /**
     * Returns the list of all of BileMo's mobile phones.
     *
     * @SWG\Response(response=200, description="Returns the list of all of BileMo's mobile phones",
     *     @SWG\Schema(type="array", @SWG\Items(ref=@Model(type=MobilePhone::class, groups={"list"}))))
     *
     * @SWG\Parameter(
     *     name="Authorization",
     *     in="header",
     *     required=true,
     *     type="string",
     *     default="Bearer {jwt}",
     *     description="Your Json Web Token"
     * )
     *
     * @SWG\Tag(name="phones")
     *
     * @Route("/api/phones", name="list_mobile_phones", methods={"GET"})
     */
    public function list()
    {
        $phones = $this->getDoctrine()->getRepository(MobilePhone::class)->findAll();

        return $this->createJsonResponse($phones, ['list']);
    }
}
