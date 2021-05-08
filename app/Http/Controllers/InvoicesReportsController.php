<?php

namespace App\Http\Controllers;

use App\Invoices;
use Illuminate\Http\Request;

class InvoicesReportsController extends Controller
{
    public function index()
    {
        return view('reports.invoices');
    }

    public function show(Request $request)
    {
        $this->validate($request, [
            'item' => 'required|in:*,0,1,2'
        ], [
            'item.required' => 'قم بإختيار نوع الفواتير',
            'item.in' => 'خطأ في نوع الفواتير'
        ]);

        $item = $request->item;
        $from = $request->from;
        $to = $request->to;

        if ($item !== "*") {

            if ($from == null || $to == null) {
                $invoices = Invoices::where('status', $item)->select('id', 'invoice_number', 'invoice_date', 'discount', 'dve_date', 'rate_vat', 'value_vat', 'total', 'status')->get();
                return view('reports.invoices', compact('invoices', 'item'));
            }else{
                $invoices = Invoices::whereBetween('invoice_date', [$from, $to])->where('status', $item)->select('id', 'invoice_number', 'invoice_date', 'discount', 'rate_vat', 'value_vat', 'total', 'status')->get();
                return view('reports.invoices', compact('invoices', 'item', 'from', 'to'));
            }

        }else{

            if ($from == null || $to == null) {
                $invoices = Invoices::select('id', 'invoice_number', 'invoice_date', 'discount', 'rate_vat', 'value_vat', 'total', 'status')->get();
                return view('reports.invoices', compact('invoices', 'item'));
            }else{
                $invoices = Invoices::whereBetween('invoice_date', [$from, $to])->select('id', 'invoice_number', 'invoice_date', 'discount', 'rate_vat', 'value_vat', 'total', 'status')->get();
                    return view('reports.invoices', compact('invoices', 'item', 'from', 'to'));
                }

        }
    }
}
