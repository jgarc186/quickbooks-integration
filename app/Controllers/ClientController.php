<?php

class ClientController
{
    private $soap_instance;

    public function __construct()
    {
        $params = [
            'location' => 'http://192.168.1.164/soap/public/Server.php',
            'uri' => 'urn://192.168.1.164/soap/public/Server.php',
            'trace' => 1
        ];

        $this->soap_instance = new SoapClient(null, $params);
    }

    public function getAll()
    {
        try {
            // return $this->soap_instance->getAllProducts();
            $this->soap_instance->getAllProducts();

            return htmlentities($this->soap_instance->__getLastResponse());
        } catch (Exception $e) {
            die("Soap error: {$e->getMessage()}");
        }
    }

    public function getById($params)
    {
        try {
            // return $this->soap_instance->getProduct($params);
            $this->soap_instance->getProduct($params);

            return htmlentities($this->soap_instance->__getLastResponse());
        } catch (Exception $e) {
            die("Soap Error: {$e->getMessage()}");
        }
    }
}
