<?php

namespace App\Controller\Authentication;

use App\Controller\AbstractApiController;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @author Amélie Haladjian <amelie.haladjian@gmail.com>
 */
class JwtAuthController extends AbstractApiController
{
    /**
     * @Route("/api/token", name="authentication", methods={"POST"})
     */
    public function authenticate(JWTTokenManagerInterface $jwtTokenManager, UserInterface $user)
    {
        return $this->createJsonResponse(['access_token' => $jwtTokenManager->create($user)]);
    }
}
