@extends('layouts.master')

@section('title')
تفاصيل الفاتورة
@endsection

@section('css')
<!--- Internal Select2 css-->
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
<!---Internal Fileupload css-->
<link href="{{URL::asset('assets/plugins/fileuploads/css/fileupload.css')}}" rel="stylesheet" type="text/css"/>
<!---Internal Fancy uploader css-->
<link href="{{URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css')}}" rel="stylesheet" />
<!--Internal Sumoselect css-->
<link rel="stylesheet" href="{{URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css')}}">
<!--Internal  TelephoneInput css-->
<link rel="stylesheet" href="{{URL::asset('assets/plugins/telephoneinput/telephoneinput-rtl.css')}}">
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
			<h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تفاصيل الفاتورة</span>
		</div>
	</div>
</div>
<!-- breadcrumb -->
@endsection

@section('content')
        <div class="bg-white p-3 rounded">
            <div class="panel panel-primary tabs-style-2">
                <div class=" tab-menu-heading">
                    <div class="tabs-menu1">
                        <!-- Tabs -->
                        <ul class="nav panel-tabs main-nav-line">
                            <li><a href="#tab4" class="nav-link active" data-toggle="tab">تفاصيل الفاتورة</a></li>
                            <li><a href="#tab5" class="nav-link" data-toggle="tab">حالات الدفع</a></li>
                            <li><a href="#tab6" class="nav-link" data-toggle="tab">المرفقات</a></li>
                        </ul>
                    </div>
                </div>
                <div class="panel-body tabs-menu-body main-content-body-right border">
                    <div class="tab-content">
                        <div class="tab-pane active table-responsive" id="tab4">
                            <table class="table text-center mg-b-0 table-striped text-md-nowrap mb-3">
                                <thead>
                                    <tr>
                                        <td>رقم الفاتورة</td>
                                        <td>تاريخ الفاتورة</td>
                                        <td>تاريخ الإستحقاق</td>
                                        <td>تاريخ الإضافة</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $invoice->invoice_number }}</td>
                                        <td>{{ $invoice->invoice_date }}</td>
                                        <td>{{ $invoice->dve_date }}</td>
                                        <td>{{ $invoice->created_at }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="table text-center mg-b-0 table-striped text-md-nowrap mb-3">
                                <thead>
                                    <tr>
                                        <td>مبلغ التحصيل</td>
                                        <td>مبلغ العمولة</td>
                                        <td>نسبة الضريبة</td>
                                        <td>الخصم</td>
                                        <td>قيمة الضريبة</td>
                                        <td>الإجمالي</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $invoice->collected_money }}</td>
                                        <td>{{ $invoice->commission }}</td>
                                        <td>{{ $invoice->rate_vat }}%</td>
                                        <td>{{ $invoice->discount }}</td>
                                        <td>{{ $invoice->value_vat }}</td>
                                        <td>{{ $invoice->total }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="table text-center mg-b-0 table-striped text-md-nowrap">
                                <thead>
                                    <tr>
                                        <td>القسم</td>
                                        <td>المنتج</td>
                                        <td>الحالة</td>
                                        <td>ملاحظات</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $invoice->foreignSection->name }}</td>
                                        <td>{{ $invoice->foreignProduct->product_name }}</td>
                                        <td>
                                            @if ($invoice->status == 0)
                                            <button class="btn btn-sm btn-warning">
                                                لم تُدفع
                                            </button>
                                            @elseif($invoice->status == 1)
                                            <button class="btn btn-sm btn-info">
                                                دُفعت جزئياً
                                            </button>
                                            @else
                                            <button class="btn btn-sm btn-success">
                                                تم الدفع
                                            </button>
                                            @endif
                                        </td>
                                        <td>
                                            @if(empty($invoice->note))
                                            لا يوجد ملاحظات
                                            @else
                                            {{ $invoice->note }}
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane" id="tab5">
                            <div class="table-responsive">
                                <table class="table text-center mg-b-0 table-striped text-md-nowrap">
                                    <thead>
                                        <tr>
                                            <td>الحالة</td>
                                            <td>المستخدم</td>
                                            <td>التاريخ</td>
                                            <td>ملاحظات</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($invoiceDetails as $details)
                                            <tr>
                                                <td>
                                                    @if ($details->status == 0)
                                                    <button class="btn btn-sm btn-warning">
                                                        لم تُدفع
                                                    </button>
                                                    @elseif($details->status == 1)
                                                    <button class="btn btn-sm btn-info">
                                                        دُفعت جزئياً
                                                    </button>
                                                    @else
                                                    <button class="btn btn-sm btn-success">
                                                        تم الدفع
                                                    </button>
                                                    @endif
                                                </td>
                                                <td>{{ $details->userInfo->name }}</td>
                                                <td>{{ $details->created_at }}</td>
                                                <td>
                                                    @if(empty($details->note))
                                                    لا يوجد ملاحظات
                                                    @else
                                                    {{ $details->note }}
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4">
                                                    <div class="alert alert-danger mb-0">لا توجد تفاصيل للفاتورة الحالية</div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab6">
                            @can('حذف المرفق')
                            <div class="modal effect-slide-in-right" id="modaldemo6">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content modal-content-demo">
                                        <div class="modal-header">
                                            <h6 class="modal-title">حذف المرفق</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('attachment.delete') }}" method="post" id="delete-attachment">
                                                @csrf
                                                {{ method_field('delete') }}
                                                <p class="mb-0">هل أنت متأكد من عملية الحذف؟ </p>
                                                <input type="hidden" name="id" id="delIdVal">
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button onclick="document.getElementById('delete-attachment').submit();" class="btn ripple btn-danger" type="button">حذف</button>
                                            <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">إغلاق</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endcan
                            <div class="table-responsive">
                                <table class="table text-center mg-b-0 table-striped text-md-nowrap">
                                    <thead>
                                        <tr>
                                            <td>إسم الملف</td>
                                            <td>المستخدم</td>
                                            <td>التاريخ</td>
                                            <td>العمليات</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($invoiceAttachments as $attachment)
                                        <tr>
                                            <td>{{ $attachment->file_name }}</td>
                                            <td>{{ $attachment->userInfo->name }}</td>
                                            <td>{{ $attachment->created_at }}</td>
                                            <td>
                                                <a target="_blank" href="{{ route('attachment.view', $attachment->file_name) }}" class="btn btn-outline-success btn-sm">
                                                    <i class="fas fa-eye pl-1 pt-1"></i>
                                                    عرض
                                                </a>
                                                <a href="{{ route('attachment.download', $attachment->file_name) }}" class="btn mx-1 btn-outline-info btn-sm">
                                                    <i class="fas pl-1 fa-download"></i>
                                                    تحميل
                                                </a>
                                                @can('حذف المرفق')
                                                <button
                                                data-id="{{ $attachment->id }}"
                                                data-toggle="modal"
                                                href="#modaldemo6"
                                                class="btn btn-outline-danger btn-sm delete-attachment">
                                                    <i class="fas pl-1 fa-trash"></i>
                                                    حذف
                                                </button>
                                                @endcan
                                            </td>
                                        </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4">
                                                    <div class="alert alert-danger mb-0">
                                                        لا توجد مرفقات لهذه الفاتورة
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            @can('اضافة مرفق')
                            <div class="row mt-3">
                                <div class="col-12">
                                    <form action="{{ route('attachment.store', $invoice->id) }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        {{ method_field('POST') }}
                                        <label for="dropify">إضافة مرفق</label>
                                        @error('attachment')
                                            <small class="d-block mb-3 invalid-feedback">{{ $message }}</small>
                                        @enderror
                                        <input type="file" class="dropify 
                                        @error('attachment')
                                            is-invalid
                                        @enderror" id="dropify" data-height="100" name="attachment" onchange="showBtn();">
                                        <small class="mark d-inline form-text">
                                            الصيغ المتاحة فقط هي pdf, jpg, jpeg, png, gif
                                        </small><br>
                                        <button style="display: none;" id="submit-file" class="btn btn-success ripple mt-3 px-2 py-1">حفظ</button>
                                    </form>
                                </div>
                            </div>
                            <script>

                                function showBtn () {
                                    document.getElementById('submit-file').style.display = 'block';
                                }

                                const deleteBtns = document.getElementsByClassName('delete-attachment'),
                                    deleteModal = document.getElementById('modaldemo6');
                                for(i = 0; i < deleteBtns.length; i++){
                                    deleteBtns[i].onclick = function () {
                                        let idField = deleteModal.querySelector('input#delIdVal');
                                        idField.value = this.dataset.id;
                                    }
                                }

                            </script>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>
	<!-- Container closed -->
</div>
<!-- main-content closed -->
@endsection

@section('js')
<!--Internal  Datepicker js -->
<script src="{{URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>
<!-- Internal Select2 js-->
<script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
<!--Internal Fileuploads js-->
<script src="{{URL::asset('assets/plugins/fileuploads/js/fileupload.js')}}"></script>
<script src="{{URL::asset('assets/plugins/fileuploads/js/file-upload.js')}}"></script>
<!--Internal Fancy uploader js-->
<script src="{{URL::asset('assets/plugins/fancyuploder/jquery.ui.widget.js')}}"></script>
<script src="{{URL::asset('assets/plugins/fancyuploder/jquery.fileupload.js')}}"></script>
<script src="{{URL::asset('assets/plugins/fancyuploder/jquery.iframe-transport.js')}}"></script>
<script src="{{URL::asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js')}}"></script>
<script src="{{URL::asset('assets/plugins/fancyuploder/fancy-uploader.js')}}"></script>
<!--Internal  Form-elements js-->
<script src="{{URL::asset('assets/js/advanced-form-elements.js')}}"></script>
<script src="{{URL::asset('assets/js/select2.js')}}"></script>
<!--Internal Sumoselect js-->
<script src="{{URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js')}}"></script>
<!-- Internal TelephoneInput js-->
<script src="{{URL::asset('assets/plugins/telephoneinput/telephoneinput.js')}}"></script>
<script src="{{URL::asset('assets/plugins/telephoneinput/inttelephoneinput.js')}}"></script>
@endsection