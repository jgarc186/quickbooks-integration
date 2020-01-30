<?php

namespace App\Services;

class CustomerService extends QuickBooksService
{
    /**
     * Adding a new customer to QuickBooks
     *
     * @param int $id
     */
    public function create(int $id)
    {
        $this->queue->enqueue(QUICKBOOKS_ADD_CUSTOMER, $id, 10);
    }

    /**
     * Edit existing customer in QuickBooks
     *
     * @param int $id
     */
    public function edit(int $id)
    {
        $this->queue->enqueue(QUICKBOOKS_MOD_CUSTOMER, $id, 0);
    }

    /**
     * Delete existing customer in QuickBooks
     *
     * @param int $id
     */
    public function delete(int $id)
    {
        $this->queue->enqueue(QUICKBOOKS_ADD_CUSTOMER, $id, 10);
    }
}
