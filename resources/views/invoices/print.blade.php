@extends('layouts.master')
@section('title')
طباعة الفاتورة
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ طباعة الفاتورة</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->
<div class="row row-sm">
    <div class="col-md-12 col-xl-12">
        <div class=" main-content-body-invoice">
            <div class="card card-invoice">
                <div class="card-body">
                    <div class="invoice-header">
                        <h1 class="invoice-title">فاتورة</h1>
                        <div class="billed-from">
                            <h6>{{ env('APP_NAME') }}</h6>
                            <p>العنوان: المحلة الكبرى - السكة الوسطى - شارع زين حارس<br>
                                رقم الهاتف: 01093668025<br>
                                الإيميل: mahmodreda219@gmail.com</p>
                        </div><!-- billed-from -->
                    </div><!-- invoice-header -->
                    <div class="row mg-t-20">
                        <div class="col-md">
                            <label class="tx-gray-600">القسم: </label>
                            <div class="billed-to">
                                <h6>{{ $invoice->foreignSection->name }}</h6>
                                <p>{{ $invoice->foreignSection->description }}</p>
                            </div>
                        </div>
                        <div class="col-md">
                            <label>تفاصيل الفاتورة</label>
                            <p class="invoice-info-row"><span>رقم الفاتورة: </span> <span>{{ $invoice->invoice_number }}</span></p>
                            <p class="invoice-info-row"><span>تاريخ الفاتورة: </span> <span>{{ $invoice->invoice_date }}</span></p>
                            <p class="invoice-info-row"><span>تاريخ الإستحقاق: </span> <span>{{ $invoice->dve_date }}</span></p>
                        </div>
                    </div>
                    <div class="table-responsive mg-t-40">
                        <table class="table table-invoice text-center border text-md-nowrap mb-0">
                            <thead>
                                <tr>
                                    <th class="wd-20p">القسم</th>
                                    <th class="wd-40p">المنتج</th>
                                    <th class="wd-40p">الحالة</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $invoice->foreignSection->name }}</td>
                                    <td class="tx-12">{{ $invoice->foreignProduct->product_name }}</td>
                                    <td class="tx-12">
                                        @if ($invoice->status == 0)
                                        لم يتم الدفع
                                        @elseif($invoice->status == 1)
                                        تم الدفع جزئياً
                                        @else
                                        تم الدفع
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="table table-invoice border text-md-nowrap mt-3 mb-0">
                            <tr>
                                <td class="tx-right" colspan="2">مبلغ التحصيل</td>
                                <td class="tx-right">{{ $invoice->collected_money }}ج</td>
                            </tr>
                            <tr>
                                <td class="tx-right" colspan="2">مبلغ العمولة</td>
                                <td class="tx-right">{{ $invoice->commission }}ج</td>
                            </tr>
                            <tr>
                                <td class="tx-right" colspan="2">قيمة الضريبة ({{ $invoice->rate_vat }}%)</td>
                                <td class="tx-right">{{ $invoice->value_vat }}ج</td>
                            </tr>
                            <tr>
                                <td class="tx-right" colspan="2">الخصم</td>
                                <td class="tx-right">
                                {{ $invoice->discount }}@if ($invoice->discount != 0)ج@endif
                                </td>
                            </tr>
                            <tr>
                                <td class="tx-right tx-uppercase tx-bold tx-inverse" colspan="2">المبلغ الكلي</td>
                                <td class="tx-right">
                                    <h4 class="tx-primary tx-bold">{{ $invoice->total }}ج</h4>
                                </td>
                            </tr>
                            <tr>
                                <td class="valign-middle" colspan="3">
                                    <div class="invoice-notes">
                                        <label class="main-content-label tx-13">ملاحظات</label>
                                        <p class="text-dark mb-1">
                                            @if (empty($invoice->note))
                                            لا يوجد ملاحظات
                                            @else
                                            {{ $invoice->note }}
                                            @endif
                                        </p>
                                    </div><!-- invoice-notes -->
                                </td>
                            </tr>
                        </table>
                    </div>
                    <button onclick="window.print();" class="btn btn-danger float-left mt-3 print-btn mr-2">
                        <i class="mdi mdi-printer ml-1"></i>طباعة
                    </button>
                </div>
            </div>
        </div>
    </div><!-- COL-END -->
</div>
<!-- row closed -->
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->
@endsection
@section('js')
<!--Internal  Chart.bundle js -->
<script src="{{URL::asset('assets/plugins/chart.js/Chart.bundle.min.js')}}"></script>
@endsection