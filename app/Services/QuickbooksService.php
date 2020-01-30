<?php

namespace App\Services;

use QuickBooks_Utilities;
use QuickBooks_WebConnector_Queue;
use QuickBooks_WebConnector_Server;

abstract class QuickBooksService extends QuickBooks_Utilities
{
    protected $server;
    protected $queue;
    protected $dsn = "";
    protected $errMap = [];
    protected $handlerOptions = [];
    protected $driverOptions = [];
    protected $callbackOptions = [];

    protected $soapOptions = [
        // See http://www.php.net/soap
    ];

    /**
     * Map QuickBooks actions to handler functions
     */
    protected $map = [
            QUICKBOOKS_ADD_CUSTOMER => [
                '_quickbooks_customer_add_request',
                '_quickbooks_customer_add_response'
            ]
    ];

    /**
     * An array of callback hooks
     */
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

        $this->server = new QuickBooks_WebConnector_Server(
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
    }

    /**
     * Create a new QuickBooks SOAP server
     */
    public function sendRequest()
    {
        return $this->server->handle(true, true);
    }

    /**
     * Adding a new customer to QuickBooks
     *
     * @param int $id
     */
    abstract public function create(int $id);

    /**
     * Edit existing customer in QuickBooks
     *
     * @param int $id
     */
    abstract public function edit(int $id);

    /**
     * Delete existing customer in QuickBooks
     *
     * @param int $id
     */
    abstract public function delete(int $id);
}
