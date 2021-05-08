<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\InvoicesRequest;
use App\Invoices;
use App\InvoicesDetails;
use App\InvoicesAttachments;
use App\Sections;
use App\Products;
use App\Notifications\InvoiceCreation;
use Illuminate\Support\Facades\Notification;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\InvoicesExport;

class InvoicesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Invoices::select(
            'invoice_number',
            'invoice_date',
            'dve_date',
            'discount',
            'rate_vat',
            'value_vat',
            'total',
            'status',
            'id'
        )->get();

        return view('invoices.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sections = Sections::select('id', 'name')->get();

        return view('invoices.create', compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InvoicesRequest $request)
    {
        $this->validate($request, [
            'invoice_number' => 'unique:invoices,invoice_number'
        ], [
            'invoice_number.unique' => 'توجد فاتورة بهذا الرقم بالفعل',
        ]);

        Invoices::create([
            'invoice_number' => $request->invoice_number,
            'invoice_date' => $request->invoice_date,
            'dve_date' => $request->dve_date,
            'product' => $request->product,
            'section' => $request->section,
            'discount' => $request->discount,
            'rate_vat' => $request->rate_vat,
            'value_vat' => $request->value_vat,
            'collected_money' => $request->collected_money,
            'commission' => $request->commission,
            'total' => $request->total,
            'status' => 0,
            'note' => $request->note
        ]);

        $invoiceId = Invoices::latest()->first()->id;

        InvoicesDetails::create([
            'invoice_id' => $invoiceId,
            'status' => 0,
            'note' => $request->note,
            'user' => auth()->user()->id
        ]);

        if ($request->hasfile('attachment')) {

            $this->validate($request, ['attachment' => 'mimes:pdf,jpg,jpeg,png,gif'], [
                'attachments.mimes' => 'صيغ الملفات المتاحة فقط هي: pdf, jpg, jpeg, png, gif'
            ]);

            $file = $request->file('attachment');
            $fileName = time() . '-' . $file->getClientOriginalName();

            $file->move(public_path('invoices_attachments'), $fileName);

            InvoicesAttachments::create([
                'file_name' => $fileName,
                'invoice_id' => $invoiceId,
                'user' => auth()->user()->id
            ]);
        }

        return redirect()->back()->with(['success' => 'تم حفظ الفاتورة بنجاح']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        Invoices::findOrFail($id);

        $invoice = Invoices::where('id', $id)->select('invoice_number', 'invoice_date', 'dve_date', 'section', 'product', 'collected_money', 'commission', 'discount', 'rate_vat', 'value_vat', 'total', 'status', 'note', 'id')->first();

        $sections = Sections::select('id', 'name')->get();

        return view('invoices.edit')->with(['sections' => $sections, 'invoice' => $invoice]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(InvoicesRequest $request, $id)
    {
        Invoices::findOrFail($id);

        Invoices::where('id', $id)->update([
            'invoice_number' => $request->invoice_number,
            'invoice_date' => $request->invoice_date,
            'dve_date' => $request->dve_date,
            'product' => $request->product,
            'section' => $request->section,
            'discount' => $request->discount,
            'rate_vat' => $request->rate_vat,
            'value_vat' => $request->value_vat,
            'collected_money' => $request->collected_money,
            'commission' => $request->commission,
            'total' => $request->total,
            'status' => 0,
            'note' => $request->note
        ]);

        $getInvoiceStatus = Invoices::where('id', $id)->select('status')->first();

        $invoiceStatus = $getInvoiceStatus->status;

        if ($invoiceStatus != $request->payment_status) {
            $this->validate($request, [
                'payment_status' => 'numeric',
                'payment_date' => 'required|date'
            ], [
                'payment_date.required' => 'حقل التاريخ مطلوب',
                'payment_date.date' => 'قم بكتابة تاريخ صالح',
                'payment_status.required' => 'خطأ في حالة الدفع',
                'payment_status.max' => 'خطأ في حالة الدفع'
            ]);

            InvoicesDetails::create([
                'invoice_id' => $id,
                'status' => $request->payment_status,
                'note' => $request->payment_note,
                'payment_date' => $request->payment_date,
                'user' => auth()->user()->id
            ]);

            Invoices::where('id', $id)->update([
                'status' => $request->payment_status
            ]);
        }

        return redirect()->back()->with(['success' => 'تم تحديث الفاتورة بنجاح']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Invoices::findOrFail($request->id);

        Invoices::where('id', $request->id)->delete();

        return redirect()->back()->with(['success' => 'تم أرشفة الفاتورة بنجاح']);
    }

    public function getProducts($id)
    {
        $products = Products::where('section_id', $id)->select('product_name', 'id')->get();
        return json_encode($products);
    }

    public function show_archive()
    {
        $invoices = Invoices::onlyTrashed()->get();

        return view('invoices.archive', compact('invoices'));
    }

    public function force_delete(Request $request)
    {
        Invoices::findOrFail($request->id);

        Invoices::where('id', $request->id)->forceDelete();

        return redirect()->back()->with(['success' => 'تم حذف الفاتورة بنجاح']);
    }

    public function restore_invoice(Request $request)
    {
        Invoices::where('id', $request->id)->restore();
    }

    public function show_custom(Request $request)
    {
        $page = $request->page;
        $pages = ['paid' => 'paid', 'unpaid' => 'unpaid', 'partly' => 'partly'];

        if (empty($page) || !in_array($page, $pages)) {
            abort(404);
            die();
        }

        if ($page === $pages['paid']) {

            $invoices = Invoices::where('status', 2)->select(
                'invoice_number',
                'invoice_date',
                'dve_date',
                'discount',
                'rate_vat',
                'value_vat',
                'total',
                'status',
                'id'
            )->get();

            $title = 'الفواتير المدفوعة';

            return view('invoices.custom', compact('title', 'invoices'));
        } else if ($page === $pages['unpaid']) {

            $invoices = Invoices::where('status', 0)->select(
                'invoice_number',
                'invoice_date',
                'dve_date',
                'discount',
                'rate_vat',
                'value_vat',
                'total',
                'status',
                'id'
            )->get();

            $title = 'الفواتير الغير مدفوعة';

            return view('invoices.custom', compact('title', 'invoices'));
        } else if ($page === $pages['partly']) {

            $invoices = Invoices::where('status', 1)->select(
                'invoice_number',
                'invoice_date',
                'dve_date',
                'discount',
                'rate_vat',
                'value_vat',
                'total',
                'status',
                'id'
            )->get();

            $title = 'الفواتير المدفوعة جزئياً';

            return view('invoices.custom', compact('title', 'invoices'));
        }
    }

    public function print($id)
    {
        Invoices::findOrFail($id);

        $invoice = Invoices::where('id', $id)->select(
            'invoice_number',
            'invoice_date',
            'dve_date',
            'discount',
            'section',
            'product',
            'collected_money',
            'commission',
            'rate_vat',
            'value_vat',
            'total',
            'status',
            'note'
        )->first();

        return view('invoices.print', compact('invoice'));
    }

    function excel_export()
    {
        return Excel::download(new InvoicesExport, 'invoices.xlsx');
    }
}
