<?php

namespace Ms580\ConsultaCep;
class Search
{
    private $url = "https://viacep.com.br/ws/";

    public function run ($argc, $argv)
    {
        if ($argc != 2) {
            die("Error, 2 params expected, given $argc params.");
        }
        $zipCode = $argv[1];
        $result = $this->getAdderessFromZipcode($zipCode);

        print_r($result);
    }
    private function getAdderessFromZipcode(string $zipCode) : array
    {
        $zipCode = preg_replace('/[^0-9]/im', '', $zipCode);
        $get = file_get_contents($this->url . $zipCode . "/json");

        return (array) json_decode($get);
    }
}