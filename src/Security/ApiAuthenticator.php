<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

/**
 * @author Amélie Haladjian <amelie.haladjian@gmail.com>
 */
class ApiAuthenticator extends AbstractGuardAuthenticator
{
    public function start(Request $request, AuthenticationException $authException = null)
    {
        $data = ['message' => 'Authentication Required'];

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }

    public function supports(Request $request)
    {
        return true;
    }

    public function getCredentials(Request $request)
    {
        return [
            'apiKey'      => $request->headers->get('X-API-KEY'),
            'apiPassword' => $request->headers->get('X-API-PASSWORD'),
        ];
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $apiKey = $credentials['apiKey'];
        $apiPassword = $credentials['apiPassword'];

        if (null === $apiKey || null === $apiPassword) {
            return null;
        }

        $user = $userProvider->loadUserByUsername($apiKey);

        return $user;
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        return true;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $credentials = $exception->getToken()->getCredentials();
        $data = [];

        if (null === $credentials['apiKey']) {
            $data['message'] = ['X-API-KEY' => 'Vous devez renseigner une clef d\'authentification'];
        }
        if (null === $credentials['apiPassword']) {
            $data['message'] += ['X-API-PASSWORD' => 'Vous devez renseigner un mot de passe'];
        }

        $data['message'] = 'Vos identifiants sont erronés';

        return new JsonResponse($data, Response::HTTP_FORBIDDEN);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return null;
    }

    public function supportsRememberMe()
    {
        return false;
    }
}
