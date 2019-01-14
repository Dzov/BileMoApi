<?php

namespace App\Normalizer;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class NotFoundHttpExceptionNormalizer extends AbstractNormalizer
{
    public function normalize(\Exception $exception)
    {
        $response['errors'] = [
            'status'  => Response::HTTP_NOT_FOUND,
            'message' => 'The resource you are looking for does not exist',
        ];

        return $response;
    }

    protected function getExceptionTypes(): array
    {
        return [NotFoundHttpException::class];
    }
}
