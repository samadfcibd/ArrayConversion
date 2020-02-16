<?php

namespace ArrayConversion\Contracts;

/**
 * Interface OutputInterface
 * @package ArrayConversion\Contracts
 *
 * Output interface
 */
interface OutputInterface
{
    public function getOutput($array_type, $array);
}