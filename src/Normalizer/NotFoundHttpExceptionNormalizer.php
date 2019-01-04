<?php

namespace App\Normalizer;

use Symfony\Component\HttpFoundation\Response;

class NotFoundHttpExceptionNormalizer extends AbstractNormalizer
{
    public function normalize(\Exception $exception)
    {
        $response['errors'] = [
            'code'    => Response::HTTP_NOT_FOUND,
            'message' => 'The resource you are looking for does not exist',
        ];

        return $response;
    }
}
