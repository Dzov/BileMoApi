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
    const MESSAGE = 'message';

    public function start(Request $request, AuthenticationException $authException = null)
    {
        $data = [self::MESSAGE => 'Authentication Required'];

        return new JsonResponse($data);
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

        switch (true) {
            case (empty($credentials['apiKey']) && empty($credentials['apiPassword'])) :
                $errors['errors'] = ['status' => 400, self::MESSAGE => 'Authentication required'];

                return $this->createJsonResponse($errors);
            case (empty($credentials['apiKey'])):
                $errors['errors'] = ['status' => 400, self::MESSAGE => 'Required parameter missing : X-API-KEY'];

                return $this->createJsonResponse($errors);
            case (empty($credentials['apiPassword'])) :
                $errors['errors'] = ['status' => 400, self::MESSAGE => 'Required parameter missing : X-API-PASSWORD'];

                return $this->createJsonResponse($errors);
            default :
                $errors['errors'] = ['status' => 403, self::MESSAGE => 'Please provide valid credentials'];

                return $this->createJsonResponse($errors, Response::HTTP_FORBIDDEN);
        }
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return null;
    }

    public function supportsRememberMe()
    {
        return false;
    }

    private function createJsonResponse(array $errors, int $status = Response::HTTP_BAD_REQUEST): JsonResponse
    {
        return new JsonResponse(json_encode($errors, 256), $status, [], true);
    }
}
