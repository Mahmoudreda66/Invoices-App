@extends('layouts.master')

@section('title')
اضافة الصلاحيات
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
            <h4 class="content-title mb-0 my-auto">المستخدمين</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0"> /صلاحيات المستخدمين</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection

@section('content')
<!-- row -->
<div class="row row-sm">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title mg-b-0">قائمة الصلاحيات</h4>
                    <i class="mdi mdi-dots-horizontal text-gray"></i>
                </div>
                <p class="tx-12 tx-gray-500 mb-3">عرض جميع بيانات الصلاحيات الموجودة</p>
                @can('اضافة صلاحية')
                <a class="btn btn-primary btn-sm" href="{{ route('roles.create') }}">اضافة صلاحية</a>
                @endcan
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table text-center text-md-nowrap table-hover" id="example1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>الاسم</th>
                                <th>العمليات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $key => $role)
                            <tr>
                                <td>{{ $role->id }}</td>
                                <td>{{ $role->name }}</td>
                                <td>
                                    @can('عرض صلاحية')
                                    <a class="btn btn-success btn-sm" href="{{ route('roles.show', $role->id) }}">عرض</a>
                                    @endcan

                                    @can('تعديل صلاحية')
                                    <a class="btn btn-info btn-sm" href="{{ route('roles.edit', $role->id) }}">تعديل</a>
                                    @endcan

                                    @if ($role->name !== 'Admin')
                                    @can('حذف صلاحية')
                                    {!! Form::open(['method' => 'DELETE', 'route' => ['roles.destroy',
                                    $role->id], 'style' => 'display:inline']) !!}
                                    {!! Form::submit('حذف', ['class' => 'btn btn-danger btn-sm']) !!}
                                    {!! Form::close() !!}
                                    @endcan
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--/div-->
</div>
<!-- row closed -->
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->
@endsection
@section('js')
<!--Internal  Notify js -->
<script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>
@endsection