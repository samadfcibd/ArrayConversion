<?php


namespace ArrayConversion\Classes;


use ArrayConversion\Contracts\OutputInterface;

class JsonOutput implements OutputInterface
{

    public function getOutput($array_type, $array)
    {
        return json_encode($array);
    }
}