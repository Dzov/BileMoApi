<?php

namespace App\Exception;

/**
 * @author Amélie Haladjian <amelie.haladjian@gmail.com>
 */
class InvalidFormDataException extends \Exception
{
    private $errors = [];

    public function __construct(array $errors)
    {
        $this->errors = $errors;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
