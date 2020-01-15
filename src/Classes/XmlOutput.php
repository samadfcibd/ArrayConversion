<?php


namespace ArrayConversion\Classes;


use ArrayConversion\Contracts\OutputInterface;
use SimpleXMLElement;

class XmlOutput implements OutputInterface
{

    public function getOutput($array_type, $array)
    {
        // Creating a object of simple XML element
        $xml = new SimpleXMLElement('<?xml version="1.0"?><dataTable></dataTable>');

        // Visit all key value pair
        foreach ($array as $k => $v) {
            // If there is nested array then
            if (is_array($v)) {
                $child = $xml->addChild("row_$k");
                foreach ($v as $key => $value) {
                    $child->addChild($key, $value);
                }
            } else {
                $xml->addChild($k, $v);
            }
        }
        return $xml->saveXML();
    }
}