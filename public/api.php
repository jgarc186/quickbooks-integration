<?php

require "../app/Controllers/ClientController.php";

$client = new ClientController();

if (! isset($_REQUEST['op'])) {
    die("Operation name required");
}

if (! method_exists($client, $_REQUEST['op']) || ! in_array($_REQUEST['op'], ['getAll', 'getById'])) {
    die("Invalid operation name");
}

switch ($_REQUEST['op']) {
    case 'getAll':
        $products = $client->getAll();
        echo "<pre>";
        print_r($products);
        echo "</pre>";

        break;

        case 'getById';
        if (! isset($_REQUEST['id'])) {
            die("id parameter required");
        }
        $product = $client->getById(
            [
                'id' => $_REQUEST['id']
            ]
        );
        echo "<pre>";
        print_r($product);
        echo "</pre>";
        break;

        default;

        break;
}