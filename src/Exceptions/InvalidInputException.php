<?php


namespace ArrayConversion\Exceptions;


class InvalidInputException extends \Exception
{
    public function getError()
    {
        echo '<b>Error</b> : ' . $this->getMessage() . '. <br/><b>File</b> :' . $this->getFile() . '. <br/><b>Line</b> :' . $this->getLine();
        exit();
    }
}