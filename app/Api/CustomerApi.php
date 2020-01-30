<?php

require "../../vendor/autoload.php";

use App\Services\CustomerService;

$QuickBooksCustomer = new CustomerService(
    'mysql://root:@127.0.0.1/quickbooks_import',
    "root",
    "Specbooks0113!"
);
$QuickBooksCustomer->create(1);
dd($QuickBooksCustomer->sendRequest());
