<?php

require "../vendor/autoload.php";

use Config\Core\DbConnect;
use App\Services\Product;

class Server extends DbConnect
{
    const TABLE = "products";

    public function getAllProducts()
    {
        $query = mysqli_query($this->db_handle, "SELECT * FROM " . self::TABLE );
        $products = [];
        while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
            array_push(
                $products,
                new Product(
                    $row['id'],
                    $row['title'],
                    $row['description'],
                    $row['price']
                )
            );
        }
        return $products;
    }

    public function getProduct(array $params)
    {
        $query = mysqli_query($this->db_handle, "SELECT * FROM " . self::TABLE . " WHERE id='{$params['id']}'");
        $row = mysqli_fetch_row($query);

        if ($row) {
            return new Product(
                $row[0],
                $row[1],
                $row[2],
                $row[3]
            );
        }

        return "No such product";
    }
}

$params = [
    'uri' => 'http://192.168.1.164/soap/public/Server.php'
];

$soapServer = new SoapServer(null, $params);
$soapServer->setClass('Server');
$soapServer->handle();
