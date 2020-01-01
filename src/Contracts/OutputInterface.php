<?php

namespace ArrayConversion\src\Contracts;

interface OutputInterface
{
    public function toHtml();

    public function toJson();

    public function toXml();

    public function toCSV();
}