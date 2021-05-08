@extends('layouts.master')

@section('title')
قائمة الفواتير
@endsection

@section('css')
<!-- Internal Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection

@section('page-header')

@if(Session::has('success'))
<div class="alert alert-success mt-3" role="alert">
    <button aria-label="Close" class="close" data-dismiss="alert" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
    {{ Session::get('success') }}
</div>
@endif

<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ قائمة الفواتير</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection

@section('content')
<div class="modal effect-slide-in-right" id="modaldemo6">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">حذف الفاتورة</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form action="invoices/force_delete" method="post" id="delete-invoice">
                    @csrf
                    {{ method_field('delete') }}
                    <p class="mb-2">سيتم حذف الفاتورة نهائياً ولا يمكن إستعادتها هل أنت متأكد من عملية الحذف؟ </p>
                    <input type="hidden" name="id" id="delIdVal">
                    <input type="text" disabled id="delNameVal" class="form-control">
                </form>
            </div>
            <div class="modal-footer">
                <button onclick="document.getElementById('delete-invoice').submit();" class="btn ripple btn-danger" type="button">حذف</button>
                <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">إغلاق</button>
            </div>
        </div>
    </div>
</div>
<!-- row opened -->
<div class="row row-sm">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title mg-b-0">قائمة الفواتير</h4>
                    <i class="mdi mdi-dots-horizontal text-gray"></i>
                </div>
                <p class="tx-12 tx-gray-500 mb-2">عرض جميع بيانات الفواتير الموجودة</p>
                <button class="btn btn-outline-primary">
                    <a style="color: inherit;" href="{{ route('invoices.create') }}">إضافة فاتورة</a>
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table text-md-nowrap" id="example1">
                        <thead>
                            <tr>
                                <th class="border-bottom-0">#</th>
                                <th class="border-bottom-0">رقم الفاتورة</th>
                                <th class="border-bottom-0">تاريخ الفاتورة</th>
                                <th class="border-bottom-0">تاريخ الإستحقاق</th>
                                <th class="border-bottom-0">الخصم</th>
                                <th class="border-bottom-0">معدل الضريبة</th>
                                <th class="border-bottom-0">قيمة الضريبة</th>
                                <th class="border-bottom-0">الإجمالي</th>
                                <th class="border-bottom-0">الحالة</th>
                                <th class="border-bottom-0">خيارات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($invoices as $invoice)
                            <tr>
                                <td>{{ $invoice->id }}</td>
                                <td>
                                    <a href="{{ route('invoice_info', $invoice->id) }}">
                                        {{ $invoice->invoice_number }}
                                    </a>
                                </td>
                                <td>{{ $invoice->invoice_date }}</td>
                                <td>{{ $invoice->dve_date }}</td>
                                <td>{{ $invoice->discount }}</td>
                                <td>{{ $invoice->rate_vat }}%</td>
                                <td>{{ $invoice->value_vat }}</td>
                                <td>{{ $invoice->total }}</td>
                                <td>
                                    @if($invoice->status == 0)
                                    <button class="btn btn-sm btn-warning">لم تُدفع</button>
                                    @elseif($invoice->status == 1)
                                    <button class="btn btn-sm btn-info">دُفعت جزئياً</button>
                                    @else
                                    <button class="btn btn-sm btn-success">تم الدفع</button>
                                    @endif
                                </td>
                                <td>
                                    <div class="row row-xs">
                                        <div class="col-sm-6 col-md-3">
                                            <div class="dropdown dropright">
                                                <button aria-expanded="false" aria-haspopup="true" class="btn btn-sm ripple btn-primary" data-toggle="dropdown" id="droprightMenuButton" type="button"><i class="fas fa-caret-right ml-1"></i></button>
                                                <div aria-labelledby="droprightMenuButton" class="dropdown-menu tx-13">
                                                    <a href="{{ route('invoices.print', $invoice->id) }}" class="dropdown-item">طباعة الفاتورة</a>
                                                    <a data-id="{{ $invoice->id }}" href="{{ route('invoices.archive_invoice') }}" class="dropdown-item archive-item">أرشفة الفاتورة</a>
                                                    <a class="dropdown-item" href="{{ route('invoices.edit', $invoice->id) }}">تعديل</a>
                                                    <a data-toggle="modal" href="#modaldemo6" data-id="{{ $invoice->id }}" data-number="{{ $invoice->invoice_number }}" class="dropdown-item cursor-pointer text-danger delete-invoice" href="#">حذف نهائياً</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="12">
                                    <div class="alert alert-info mb-0 text-center">لا توجد فواتير حتى الآن</div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <script>
                        const archiveBtns = document.getElementsByClassName('archive-item');

                        for (let i = 0; i < archiveBtns.length; i++) {
                            archiveBtns[i].onclick = function(e) {
                                e.preventDefault();
                                const deleteObject = new XMLHttpRequest();
                                deleteObject.open('post', '{{ route("invoices.archive_invoice") }}');
                                deleteObject.onload = function() {
                                    if (this.readyState === 4 && this.status === 200) {
                                        location.reload();
                                    } else {
                                        alert('لقد حدث خطأ غير متوقع');
                                    }
                                }
                                deleteObject.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                                deleteObject.send('_token=' + '{{ csrf_token() }}' + '&id=' + this.dataset.id);
                            }
                        }

                        const deleteBtns = document.getElementsByClassName('delete-invoice'),
                            deleteModal = document.getElementById('modaldemo6');
                        for (let i = 0; i < deleteBtns.length; i++) {
                            deleteBtns[i].onclick = function() {
                                let name = deleteModal.querySelector('input#delNameVal'),
                                    id = deleteModal.querySelector('input#delIdVal');

                                name.value = this.dataset.number;
                                id.value = this.dataset.id;
                            }
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /row -->
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->
@endsection

@section('js')
<!-- Internal Data tables -->
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
<!--Internal  Datatable js -->
<script src="{{URL::asset('assets/js/table-data.js')}}"></script>
@endsection