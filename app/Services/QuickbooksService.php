<?php

namespace App\Services;

use QuickBooks_Utilities;
use QuickBooks_WebConnector_Queue;
use QuickBooks_WebConnector_Server;

class QuickBooksService extends QuickBooks_Utilities
{
    protected $queue;
    protected $dsn = "";
    protected $errMap = [];
    protected $handlerOptions = [];
    protected $driverOptions = [];
    protected $callbackOptions = [];

    protected $soapOptions = [
        // See http://www.php.net/soap
    ];

    // Map QuickBooks actions to handler functions
    protected $map = [
            QUICKBOOKS_ADD_CUSTOMER => [
                '_quickbooks_customer_add_request',
                '_quickbooks_customer_add_response'
            ]
    ];

    // An array of callback hooks
    protected $hooks = [
        // There are many hooks defined which allow you to run your own functions/methods when certain events happen within the framework
        // QuickBooks_WebConnector_Handlers::HOOK_LOGINSUCCESS => '_quickbooks_hook_loginsuccess', 	// Run this function whenever a successful login occurs
    ];

    /**
     * QuickBooksService constructor.
     * @param string $dsn
     * @param string $user
     * @param string $pass
     */
    public function __construct(string $dsn, string $user, string $pass)
    {
        $this->dsn = $dsn;

        if (! static::initialized($dsn)) {
            static::initialize($dsn);
            static::createUser($dsn, $user, $pass);
            $this->queue = new QuickBooks_WebConnector_Queue($dsn);
        }
    }

    /**
     * Create a new QuickBooks SOAP server
     */
    public function sendRequest()
    {
        $Server = new QuickBooks_WebConnector_Server(
            $this->dsn,
            $this->map,
            $this->errMap,
            $this->hooks,
            QUICKBOOKS_LOG_NORMAL,
            QUICKBOOKS_SOAPSERVER_PHP,
            QUICKBOOKS_WSDL,
            $this->soapOptions,
            $this->handlerOptions,
            $this->driverOptions,
            $this->callbackOptions
        );

        return $Server->handle(true, true);
    }

    /**
     * Adding a new customer to QuickBooks
     *
     * @param int $customerId
     */
    public function addCustomer(int $customerId)
    {
        $this->queue->enqueue(QUICKBOOKS_ADD_CUSTOMER, $customerId, 10);
    }

    /**
     * Adding a new invoice to QuickBooks
     *
     * @param int $orderId
     */
    public function addInvoice(int $orderId)
    {
        $this->queue->enqueue(QUICKBOOKS_ADD_INVOICE, $orderId, 0);
    }
}
