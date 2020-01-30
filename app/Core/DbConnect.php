<?php

namespace App\Core;

use Exception;

class DbConnect
{
    public $db_handle;

    public function __construct()
    {
        $this->connect();
    }

    private function connect()
    {
        try {
            $this->db_handle = mysqli_connect(
                env('DB_HOST'),
                env('DB_USER'),
                env('DB_PASSWORD'),
                env('DB_NAME')
            );
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
}
