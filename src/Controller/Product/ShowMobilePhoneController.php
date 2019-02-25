<?php

namespace App\Controller\Product;

use App\Controller\AbstractApiController;
use App\Entity\MobilePhone;
use App\Manager\Product\ProductManager;
use Nelmio\ApiDocBundle\Annotation\Model;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Swagger\Annotations as SWG;

/**
 * @author Amélie Haladjian <amelie.haladjian@gmail.com>
 */
class ShowMobilePhoneController extends AbstractApiController
{
    /**
     * Returns the details of a selected mobile phone.
     *
     * @SWG\Response(response=200, description="Returns the details of a specific mobile phone",
     *     @SWG\Schema(type="array", @SWG\Items(ref=@Model(type=MobilePhone::class, groups={"details"}))))
     * @SWG\Response(response=404, description="The resource does not exist")
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
     * @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     type="integer",
     *     description="The field used to identify a specific phone"
     * )
     *
     * @SWG\Tag(name="phones")
     *
     * @Route("/api/phones/{id}", name="show_phone", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function show(int $id, ProductManager $manager)
    {
        $phone = $manager->showMobilePhone($id);

        return $this->createJsonResponse($phone, ['details']);
    }
}
