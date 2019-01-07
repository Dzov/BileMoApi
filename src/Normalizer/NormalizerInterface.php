<?php

namespace App\Normalizer;

/**
 * @author Amélie Haladjian <amelie.haladjian@gmail.com>
 */
interface NormalizerInterface
{
    public function supports(\Exception $exception);

    public function normalize(\Exception $exception);
}
