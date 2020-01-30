<?php

namespace App\Services;

use QuickBooks_Utilities;
use QuickBooks_WebConnector_Queue;

class QuickbooksService extends QuickBooks_Utilities
{
    protected $queue;

    public function __construct(string $dsn, string $user, string $pass)
    {
        QuickBooks_Utilities::initialized($dsn);

        QuickBooks_Utilities::initialize($dsn);

        QuickBooks_Utilities::createUser($dsn, $user, $pass);

        $this->queue = new QuickBooks_WebConnector_Queue($dsn);

        QuickBooks_Utilities::createUser();
    }

    public function addCustomerToQB(int $customerId)
    {
        $this->queue->enqueue(QUICKBOOKS_ADD_CUSTOMER, $customerId);
    }

    public function addInvoiceToQB(int $orderId)
    {
        $this->enqueue(QUICKBOOKS_ADD_INVOICE, $orderId);
    }
}