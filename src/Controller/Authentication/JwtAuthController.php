<?php

namespace App\Controller\Authentication;

use App\Controller\AbstractApiController;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Swagger\Annotations as SWG;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @author Amélie Haladjian <amelie.haladjian@gmail.com>
 */
class JwtAuthController extends AbstractApiController
{
    /**
     * Returns the necessary token to access api resources upon user authentication.
     *
     * @SWG\Response(response=200, description="Authorization granted, returns access token")
     * @SWG\Response(response=400, description="Bad request, credentials missing")
     * @SWG\Response(response=403, description="Forbidden, invalid credentials")
     *
     * @SWG\Parameter(
     *     name="X-API-KEY",
     *     in="header",
     *     required=true,
     *     type="string",
     *     description="The company's api key"
     * )
     *
     * @SWG\Parameter(
     *     name="X-API-PASSWORD",
     *     in="header",
     *     required=true,
     *     type="string",
     *     description="The company's api password"
     * )
     *
     * @SWG\Tag(name="authorization")
     *
     * @Route("/api/token", name="authentication", methods={"GET"})
     */
    public function authenticate(JWTTokenManagerInterface $jwtTokenManager, UserInterface $user)
    {
        return $this->createJsonResponse(['access_token' => $jwtTokenManager->create($user)]);
    }
}
