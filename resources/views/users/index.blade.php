@extends('layouts.master')

@section('title')
المستخدمين
@stop

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
            <h4 class="content-title mb-0 my-auto">المستخدمين</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ قائمة
                المستخدمين</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection

@section('content')
@can('حذف مستخدم')
<div class="modal" id="modaldemo8">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">حذف المستخدم</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <form action="/users/destroy" method="post" id="delete-form">
                {{ method_field('delete') }}
                {{ csrf_field() }}
                <div class="modal-body">
                    <p class="mb-2">هل انت متاكد من عملية الحذف ؟</p>
                    <input type="hidden" name="id" id="id">
                    <input class="form-control" id="name" type="text" disabled>
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                <button type="submit" onclick="document.getElementById('delete-form').submit();" class="btn btn-danger">تاكيد</button>
            </div>
        </div>
    </div>
</div>
@endcan

<!-- row opened -->
<div class="row row-sm">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title mg-b-0">قائمة المستخدمين</h4>
                    <i class="mdi mdi-dots-horizontal text-gray"></i>
                </div>
                <p class="tx-12 tx-gray-500 mb-3">عرض جميع بيانات المستخدمين الموجودة</p>
                @can('اضافة مستخدم')
                <a class="btn btn-primary btn-sm" href="{{ route('users.create') }}">اضافة مستخدم</a>
                @endcan
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table text-center table-hover text-md-nowrap" id="example1">
                        <thead>
                            <tr>
                                <th class="wd-10p border-bottom-0">#</th>
                                <th class="wd-15p border-bottom-0">اسم المستخدم</th>
                                <th class="wd-20p border-bottom-0">البريد الالكتروني</th>
                                <th class="wd-15p border-bottom-0">حالة المستخدم</th>
                                <th class="wd-15p border-bottom-0">نوع المستخدم</th>
                                <th class="wd-10p border-bottom-0">العمليات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if ($user->status == 1)
                                    <span class="btn btn-sm btn-success">
                                        حساب مُفعل
                                    </span>
                                    @else
                                    <span class="btn btn-sm btn-danger">
                                        حساب غير مُفعل
                                    </span>
                                    @endif
                                </td>

                                <td>
                                    @if (!empty($user->getRoleNames()))
                                    @foreach ($user->getRoleNames() as $v)
                                    <label class="btn btn-sm btn-info">{{ $v }}</label>
                                    @endforeach
                                    @endif
                                </td>

                                <td>
                                    @can('تعديل مستخدم')
                                    <a href="{{ route('users.edit', $user->id) }}" class="text-success" title="تعديل"><i class="fas fa-edit"></i></a>
                                    @endcan

                                    @can('حذف مستخدم')
                                    <span class="cursor-pointer modal-effect text-danger delete-user" data-effect="effect-scale" data-id="{{ $user->id }}" data-name="{{ $user->name }}" data-toggle="modal" href="#modaldemo8" title="حذف"><i class="fas fa-trash mr-1"></i></span>
                                    @endcan
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @can('حذف مستخدم')
                    <script>
                        var deleteBtns = document.getElementsByClassName('delete-user'),
                            deleteModal = document.getElementById('modaldemo8');
                        for(i = 0; i < deleteBtns.length; i++){
                            deleteBtns[i].onclick = function () {
                                let idField = deleteModal.querySelector('input#id'),
                                    nameField = deleteModal.querySelector('input#name');
                                idField.value = this.dataset.id;
                                nameField.value = this.dataset.name;
                            }
                        }
                    </script>
                    @endcan
                </div>
            </div>
        </div>
    </div>
    <!--/div-->
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
<script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
<!--Internal  Datatable js -->
<script src="{{ URL::asset('assets/js/table-data.js') }}"></script>
<!--Internal  Notify js -->
<script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>
<!-- Internal Modal js-->
<script src="{{ URL::asset('assets/js/modal.js') }}"></script>
@endsection