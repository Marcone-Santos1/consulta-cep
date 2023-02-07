<?php

namespace Ms580\ConsultaCep;
class Search
{
    private $url = "https://viacep.com.br/ws/";

    public function run (int $argc, array $argv) : void
    {

        $zipCode = $argv[1];
        $this->validation($argc, $zipCode);
        $result = $this->getAdderessFromZipcode($zipCode);
        print_r($result);
    }
    private function getAdderessFromZipcode(string $zipCode) : array
    {
        $zipCode = preg_replace('/[^0-9]/im', '', $zipCode);
        return $this->consultaCep($zipCode);
    }

    private function validation(int $argc, string $zipCode) {
        if ($argc != 2) {
            die("Error: 2 params expected, given $argc params.");
        }
        if (strlen($zipCode) <> 8) {
            die("Error: The zip code must be a length of 8 characters, given " .strlen($zipCode));
        }
    }

    private function consultaCep(string $zipCode) : array
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->url . $zipCode . '/json',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        return (array) json_decode($response);
    }
}