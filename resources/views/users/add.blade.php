@extends('layouts.master')

@section('title')
إضافة مستخدم
@stop

@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">المستخدمين</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ اضافة
                مستخدم</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection

@section('content')
<!-- row -->
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <form class="parsley-style-1" autocomplete="off" action="{{route('users.store')}}" method="post">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-6 col-12 mb-3 mb-md-0">
                            <div class="form-group">
                                <label for="name">اسم المستخدم:</label>
                                <input class="form-control 
                                    @error('name')
                                        is-invalid
                                    @enderror" autofocus id="name" name="name" type="text">
                                @error('name')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <label for="email">البريد الالكتروني:</label>
                            <input class="form-control 
                                @error('email')
                                    is-invalid
                                @enderror" id="email" name="email" type="email">
                            @error('email')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-12 mb-3 mb-md-0">
                            <div class="form-group">
                                <label for="password">كلمة المرور:</label>
                                <input class="form-control 
                                    @error('password')
                                        is-invalid
                                    @enderror" id="password" name="password" type="password">
                                @error('password')
                                <small class="invalid-feedback">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <label for="confirm-password"> تاكيد كلمة المرور:</label>
                            <input class="form-control 
                                @error('confirm-password')
                                    is-invalid
                                @enderror" id="confirm-password" name="confirm-password" type="password">
                            @error('confirm-password')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-12 mb-3 mb-md-0">
                            <div class="form-group">
                                <label for="status">حالة المستخدم</label>
                                <select name="status" id="status" class="form-control 
                                    @error('status')
                                        is-invalid
                                    @enderror">
                                    <option value="1">حساب مُفعل</option>
                                    <option value="0">حساب غير مُفعل</option>
                                </select>
                                @error('status')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="roles"> نوع المستخدم</label>
                                {!! Form::select('roles_name[]', $roles, [], array('class' => 'form-control', 'multiple', 'id' => 'roles')) !!}
                                @error('roles_name')
                                    <small class="invalid-feedback d-block">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-success btn-block" type="submit">تاكيد</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- row closed -->
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->
@endsection