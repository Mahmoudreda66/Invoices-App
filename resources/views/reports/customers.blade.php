@extends('layouts.master')

@section('css')
<!-- Internal Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection

@section('title')
تقارير العملاء
@endsection

@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">التقارير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تقارير العملاء</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')
<div class="card">
    <div class="card-header pb-0">
        <div class="d-flex justify-content-between">
            <h4 class="card-title mg-b-0">تقارير العملاء</h4>
            <i class="mdi mdi-dots-horizontal text-gray"></i>
        </div>
        <p class="tx-12 tx-gray-500 mb-0">عرض جميع تقارير العملاء الموجودة</p>
    </div>
    <div class="card-body">
        <form action="{{ route('reports.customers.show') }}" method="post" id="get-report">
            @csrf
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-3 mb-md-0">
                    <label for="section">القسم</label>
                    <select name="section" id="section" class="form-control 
                        @error('section')
                            is-invalid
                        @enderror">
                        <option value="NULL" disabled selected>إختر القسم</option>
                        @foreach ($sections as $section)
                        <option value="{{ $section->id }}">
                            {{ $section->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('section')
                    <small class="invalid-feedback">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-3 mb-md-0">
                    <label for="product">المنتج</label>
                    <select name="product" disabled id="product" class="form-control 
                        @error('product')
                            is-invalid
                        @enderror">
                        <option value="NULL">إختر المنتج</option>
                    </select>
                    @error('product')
                    <small class="invalid-feedback">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-3 mb-md-0">
                    <label for="from">من تاريخ</label>
                    <input type="date" value="{{ $from ?? '' }}" name="from" id="from" class="form-control">
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-3 mb-md-0">
                    <label for="to">إلى تاريخ</label>
                    <input type="date" value="{{ $to ?? '' }}" name="to" id="to" class="form-control">
                </div>
            </div>
            <button class="btn btn-primary mt-3">
                عرض التقرير
            </button>
        </form>
        <script>
            var section = document.getElementById('section'),
                productsSelect = document.getElementById('product');

            section.onchange = function() {

                productsSelect.setAttribute('disabled', '');
                productsSelect.innerHTML = '<option value="NULL" disabled selected>إختر المنتج</option>';

                let sectionValue = this.value,
                    getProducts = new XMLHttpRequest();
                getProducts.open('GET', '/invoices/getProducts/' + sectionValue);

                getProducts.onload = function() {
                    if (this.readyState === 4 && this.status === 200) { // succes
                        productsSelect.removeAttribute('disabled', '');
                        let products = JSON.parse(this.responseText);
                        products.forEach(function(item) {
                            let option = document.createElement('option'),
                                text = document.createTextNode(item['product_name']);
                            option.appendChild(text);
                            option.value = item['id'];
                            productsSelect.appendChild(option);
                        });
                    } else {
                        alert('لقد حدث خطأ غير متوقع');
                    }
                }

                getProducts.send();

            }
        </script>
        @isset($invoices)
        <div class="card-body-c mt-3">
            <div class="table-responsive">
                <table class="table table-hover text-md-nowrap" id="example1">
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
                                                @can('طباعةالفاتورة')
                                                <a href="{{ route('invoices.print', $invoice->id) }}" class="dropdown-item">طباعة الفاتورة</a>
                                                @endcan
                                                @can('ارشفة الفاتورة')
                                                <a data-id="{{ $invoice->id }}" href="{{ route('invoices.archive_invoice') }}" class="dropdown-item archive-item">أرشفة الفاتورة</a>
                                                @endcan
                                                @can('تعديل الفاتورة')
                                                <a class="dropdown-item" href="{{ route('invoices.edit', $invoice->id) }}">تعديل</a>
                                                @endcan
                                                @can('حذف الفاتورة')
                                                <a data-toggle="modal" href="#modaldemo6" data-id="{{ $invoice->id }}" data-number="{{ $invoice->invoice_number }}" class="dropdown-item cursor-pointer text-danger delete-invoice" href="#">حذف نهائياً</a>
                                                @endcan
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
        @endisset
    </div>
</div>
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