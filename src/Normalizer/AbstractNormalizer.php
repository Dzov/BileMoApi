<?php

namespace App\Normalizer;

/**
 * @author Amélie Haladjian <amelie.haladjian@gmail.com>
 */
abstract class AbstractNormalizer implements NormalizerInterface
{
    /**
     * @var array
     */
    protected $exceptionTypes;

    public function __construct()
    {
        $this->exceptionTypes = $this->getExceptionTypes();
    }

    public function supports(\Exception $exception): bool
    {
        return in_array(get_class($exception), $this->exceptionTypes);
    }
}
