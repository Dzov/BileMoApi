<?php

namespace App\Controller\Authentication;

use App\Controller\AbstractApiController;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @author Amélie Haladjian <amelie.haladjian@gmail.com>
 */
class JwtAuthController extends AbstractApiController
{
    /**
     * @Route("/api/token", name="authentication")
     */
    public function authenticate(JWTEncoderInterface $encoder)
    {
        $user = $this->getUser();

        $token = $encoder->encode(['username' => $user->getUsername()]);

        return $this->createJsonResponse(['Autorization token' => $token]);
    }
}
