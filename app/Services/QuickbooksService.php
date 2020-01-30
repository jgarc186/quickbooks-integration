<?php

namespace App\Services;

use QuickBooks_Utilities;
use QuickBooks_WebConnector_Queue;
use QuickBooks_WebConnector_Server;

class QuickBooksService extends QuickBooks_Utilities
{
    protected $queue;
    protected $log_level = QUICKBOOKS_LOG_DEBUG;
    protected $soapserver = QUICKBOOKS_SOAPSERVER_BUILTIN;
    protected $soap_options = [
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

    public function __construct(string $dsn, string $user, string $pass)
    {
        if (! static::initialized($dsn)) {
            static::initialize($dsn);
            static::createUser($dsn, $user, $pass);
            $this->queue = new QuickBooks_WebConnector_Queue($dsn);
        }
    }

    /**
     * Create a new QuickBooks SOAP server
     *
     * @param mixed $dsn        		Either a DSN-style connection string *or* a database resource (if reusing an existing connection)
     * @param array $map				An associative array mapping queued commands to function/method calls
     * @param array $errmap			    An associative array mapping error codes to function/method calls
     * @param array $hooks				An associative array mapping events to hook function/method calls
     * @param string $logLevel			The path to the WSDL file to use for the SOAP server methods
     * @param array $soap_options		Options to pass to the SOAP server (these mirror the default PHP SOAP server options)
     * @param array $handler_options	Options to pass to the handler class
     * @param array $driver_options		Options to pass to the driver class (i.e.: MySQL, etc.)
     */
    public function sendRequest(
        string $dsn,
        array $map,
        array $errmap,
        array $hooks,
        string $logLevel = QUICKBOOKS_LOG_NORMAL,
        $soap = QUICKBOOKS_SOAPSERVER_PHP,
        $wsdl = QUICKBOOKS_WSDL,
        $soap_options = array(),
        $handler_options = array(),
        $driver_options = array(),
        $callback_options = array()
    ) {
        $Server = new QuickBooks_WebConnector_Server(
            $dsn,
            $map,
            $errmap,
            $hooks,
            $logLevel,
            $soapserver,
            QUICKBOOKS_WSDL,
            $soap_options,
            $handler_options,
            $driver_options,
            $callback_options
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
