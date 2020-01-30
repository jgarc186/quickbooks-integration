<?php

namespace App\Services;

class Product
{
    public $id;
    public $title;
    public $description;
    public $price;

    public function __construct($id, $title, $description, $price)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->price = $price;
    }
}
