<?php

namespace App\Http\Controllers;

use App\Invoices;
use App\InvoicesDetails;
use App\InvoicesAttachments;

class InvoicesDetailsController extends Controller
{
    public function show($id)
    {

        Invoices::findOrFail($id);

        $invoice = Invoices::where('id', $id)->select('id', 'invoice_number', 'invoice_date', 'dve_date', 'product', 'section', 'discount', 'rate_vat', 'value_vat', 'collected_money', 'commission', 'total', 'status', 'note', 'created_at')->first();

        $invoiceDetails = InvoicesDetails::where('invoice_id', $id)->select('status', 'user', 'created_at', 'note')->get();

        $invoiceAttachments = InvoicesAttachments::where('invoice_id', $id)->select('id', 'file_name', 'user', 'created_at')->get();

        return view('invoices.details', compact('invoice', 'invoiceDetails', 'invoiceAttachments'));
    }
}
