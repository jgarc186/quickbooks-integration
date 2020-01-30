<?php

namespace App\Services;

class InvoiceService extends QuickBooksService
{
    /**
     * Adding a new order to QuickBooks
     *
     * @param int $id
     */
    public function create(int $id)
    {
        $this->queue->enqueue(QUICKBOOKS_ADD_INVOICE, $id, 10);
    }

    /**
     * Edit existing order in QuickBooks
     *
     * @param int $id
     */
    public function edit(int $id)
    {
        $this->queue->enqueue(QUICKBOOKS_MOD_INVOICE, $id, 0);
    }

    /**
     * Delete existing order in QuickBooks
     *
     * @param int $id
     */
    public function delete(int $id)
    {
        $this->queue->enqueue(QUICKBOOKS_ADD_CUSTOMER, $id, 10);
    }
}
