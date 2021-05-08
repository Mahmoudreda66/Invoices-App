<?php

namespace App\Http\Controllers;

use App\Invoices;
use App\Sections;
use Illuminate\Http\Request;

class CustomersReportsController extends Controller
{
    public function index()
    {
        $sections = Sections::orderBy('name', 'ASC')->select('name', 'id')->get();
        return view('reports.customers', compact('sections'));
    }

    public function show(Request $request)
    {
        $this->validate($request, [
            'section' => 'required|numeric|not_in:NULL',
            'product' => 'required|numeric|not_in:NULL'
        ], [
            'section.required' => 'قم بإختيار القسم',
            'section.numeric' => 'قم بإختيار القسم',
            'section.not_in' => 'قم بإختيار القسم',
            'product.required' => 'قم بإختيار المنتج',
            'product.numeric' => 'قم بإختيار المنتج',
            'product.not_in' => 'قم بإختيار المنتج'
        ]);

        $section = $request->section;
        $product = $request->product;
        $from = $request->from;
        $to = $request->to;

        $sections = Sections::orderBy('name', 'ASC')->select('name', 'id')->get();

        if ($from == null || $to == null) {

            $invoices = Invoices::where([
                ['section', '=', $section],
                ['product', '=', $product]
            ])->select('id', 'invoice_number', 'dve_date', 'invoice_date', 'discount', 'rate_vat', 'value_vat', 'total', 'status')->get();

            return view('reports.customers', compact('invoices', 'sections'));
            
        } else {

            $invoices = Invoices::whereBetween('invoice_date', [$from, $to])->where([
                ['section', '=', $section],
                ['product', '=', $product]
            ])->select('id', 'invoice_number', 'dve_date', 'invoice_date', 'discount', 'rate_vat', 'value_vat', 'total', 'status')->get();

            return view('reports.customers', compact('invoices', 'sections'));

        }
    }
}
