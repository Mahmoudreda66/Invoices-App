@extends('layouts.master')

@section('title')
الأقسام
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

@error('name')
<div class="alert alert-danger mt-3" role="alert">
    <button aria-label="Close" class="close" data-dismiss="alert" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
    {{ $message }}
</div>
@enderror

<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">الإعدادات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ الأقسام</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection

@section('content')
<!-- row opened -->
<div class="row row-sm">
    @can('حذف قسم')
    <div class="modal effect-slide-in-right" id="modaldemo6">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">حذف القسم</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form action="sections/destroy" method="post" id="delete-section">
                        @csrf
                        {{ method_field('delete') }}
                        <p class="mb-2">هل أنت متأكد من عملية الحذف؟ </p>
                        <input type="hidden" name="id" id="delIdVal">
                        <input type="text" disabled id="delNameVal" class="form-control">
                    </form>
                </div>
                <div class="modal-footer">
                    <button onclick="document.getElementById('delete-section').submit();" class="btn ripple btn-danger" type="button">حذف</button>
                    <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">إغلاق</button>
                </div>
            </div>
        </div>
    </div>
    @endcan

    @can('تعديل قسم')
    <div class="modal effect-slide-in-right" id="modaldemo7">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">تعديل القسم</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form action="sections/update" method="post" id="edit-section">
                        {{ method_field('PATCH') }}
                        {{ csrf_field() }}
                        <input type="hidden" name="id" id="id">
                        <div class="mb-3">
                            <label for="name">إسم القسم</label>
                            <input type="text" autofocus name="name" autocomplete="off" class="form-control" id="name">
                        </div>
                        <div class="mb-3">
                            <label for="description">وصف القسم</label>
                            <textarea name="description" id="description" class="form-control"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button onclick="document.getElementById('edit-section').submit();" class="btn ripple btn-success" type="button">حفظ التغييرات</button>
                    <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">إغلاق</button>
                </div>
            </div>
        </div>
    </div>
    @endcan

    @can('اضافة قسم')
    <div class="modal effect-slide-in-right" id="modaldemo8">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">إضافة قسم</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('sections.store') }}" method="post" id="add-section">
                        @csrf
                        <div class="mb-3">
                            <label for="name">إسم القسم</label>
                            <input type="text" autofocus name="name" autocomplete="off" class="form-control" id="name">
                        </div>
                        <div class="mb-3">
                            <label for="description">وصف القسم</label>
                            <textarea name="description" id="description" class="form-control"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button onclick="document.getElementById('add-section').submit();" class="btn ripple btn-success" type="button">حفظ التغييرات</button>
                    <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">إغلاق</button>
                </div>
            </div>
        </div>
    </div>
    @endcan

    <div class="col-xl-12">
        <div class="card">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title mg-b-0">قائمة الأقسام</h4>
                    <i class="mdi mdi-dots-horizontal text-gray"></i>
                </div>
                <p class="tx-12 tx-gray-500 mb-2">عرض جميع الأقسام الموجودة</p>
                <a class="modal-effect btn btn-primary btn-sm mt-1" data-toggle="modal" href="#modaldemo8">إضافة قسم</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover text-md-nowrap" id="example1">
                        <thead>
                            <tr>
                                <th class="border-bottom-0">#</th>
                                <th class="border-bottom-0">إسم القسم</th>
                                <th class="border-bottom-0">الوصف</th>
                                <th class="border-bottom-0">خيارات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sections as $section)
                            <tr>
                                <td>{{ $section->id }}</td>
                                <td>{{ $section->name }}</td>
                                <td>{{ $section->description ?? 'لا يوجد' }}</td>
                                <td class="text-center">
                                    @can('تعديل قسم')
                                    <i data-toggle="modal" data-id="{{ $section->id }}" data-name="{{ $section->name }}" data-description="{{ $section->description }}" href="#modaldemo7" class="cursor-pointer edit-section fas fa-edit text-success ml-2"></i>
                                    @endcan
                                    @can('حذف قسم')
                                    <i data-toggle="modal" data-id="{{ $section->id }}" data-name="{{ $section->name }}" href="#modaldemo6" class="cursor-pointer delete-section fas fa-trash text-danger"></i>
                                    @endcan
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4">
                                    <div class="mb-0 text-center alert alert-info">لا يوجد أقسام بعد</div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <script>
                        var editBtns = document.getElementsByClassName('edit-section'),
                            editModal = document.getElementById('modaldemo7');
                        for (i = 0; i < editBtns.length; i++) {
                            editBtns[i].onclick = function() {
                                let idField = editModal.querySelector('input#id'),
                                    nameField = editModal.querySelector('input#name'),
                                    descriptionField = editModal.querySelector('textarea#description');

                                idField.value = this.dataset.id;
                                nameField.value = this.dataset.name;
                                descriptionField.value = this.dataset.description;
                            }
                        }

                        var deleteBtns = document.getElementsByClassName('delete-section'),
                            deleteModal = document.getElementById('modaldemo6');
                        for (i = 0; i < deleteBtns.length; i++) {
                            deleteBtns[i].onclick = function() {
                                let idField = deleteModal.querySelector('input#delIdVal'),
                                    nameField = deleteModal.querySelector('input#delNameVal');
                                idField.value = this.dataset.id;
                                nameField.value = this.dataset.name;
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
<!-- Internal Modal js-->
<script src="{{URL::asset('assets/js/modal.js')}}"></script>
@endsection