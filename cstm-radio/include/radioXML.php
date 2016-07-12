<?php

class radioXML
{
    protected $xml_file;

    public function __construct($conf)
    {
        $this->xml_file = $conf->xml;
    }

    public function getXmlFile()
    {
        return simplexml_load_file($this->xml_file);
    }
}
