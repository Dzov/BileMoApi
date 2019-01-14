<?php

namespace App\Normalizer;

use App\Exception\InvalidFormDataException;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Amélie Haladjian <amelie.haladjian@gmail.com>
 */
class InvalidFormDataExceptionNormalizer extends AbstractNormalizer
{
    public function normalize(\Exception $exception)
    {
        $errors['errors'] = [];
        $errors['errors']['status'] = Response::HTTP_CONFLICT;
        foreach ($exception->getErrors() as $key => $error) {
            $errors['errors']['message'][$key] = $error;
        }

        return $errors;
    }

    protected function getExceptionTypes(): array
    {
        return [InvalidFormDataException::class];
    }
}
