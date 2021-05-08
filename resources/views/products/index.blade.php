@extends('layouts.master')

@section('title')
المنتجات
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

@if($errors->any())
@foreach($errors->all() as $error)
<div class="alert alert-danger mt-3" role="alert">
	<button aria-label="Close" class="close" data-dismiss="alert" type="button">
		<span aria-hidden="true">&times;</span>
	</button>
	{{ $error }}
</div>
@endforeach
@endif

<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
	<div class="my-auto">
		<div class="d-flex">
			<h4 class="content-title mb-0 my-auto">الإعدادات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ المنتجات</span>
		</div>
	</div>
</div>
<!-- breadcrumb -->
@endsection

@section('content')
<!-- row -->
<div class="row">
	<div class="col-xl-12">
		@can('حذف منتج')
		<div class="modal effect-slide-in-right" id="modaldemo6">
			<div class="modal-dialog" role="document">
				<div class="modal-content modal-content-demo">
					<div class="modal-header">
						<h6 class="modal-title">حذف المنتج</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body">
						<form action="products/destroy" method="post" id="delete-product">
							@csrf
							{{ method_field('delete') }}
							<p class="mb-2">هل أنت متأكد من عملية الحذف؟ </p>
							<input type="hidden" name="id" id="delIdVal">
							<input type="text" disabled id="delNameVal" class="form-control">
						</form>
					</div>
					<div class="modal-footer">
						<button onclick="document.getElementById('delete-product').submit();" class="btn ripple btn-danger" type="button">حذف</button>
						<button class="btn ripple btn-secondary" data-dismiss="modal" type="button">إغلاق</button>
					</div>
				</div>
			</div>
		</div>
		@endcan

		@can('تعديل منتج')
		<div class="modal effect-slide-in-right" id="modaldemo7">
			<div class="modal-dialog" role="document">
				<div class="modal-content modal-content-demo">
					<div class="modal-header">
						<h6 class="modal-title">تعديل المنتج</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body">
						<form action="products/update" method="post" id="edit-product">
							{{ method_field('PATCH') }}
							{{ csrf_field() }}
							<input type="hidden" name="id" id="id">
							<div class="mb-3">
								<label for="product_name">إسم المنتج</label>
								<input type="text" autofocus name="product_name" autocomplete="off" class="form-control" id="product_name">
							</div>
							<div class="mb-3">
								<label for="section_id">القسم</label>
								<select name="section_id" id="section_id" class="form-control">
									<option value="NULL" disabled>إختر القسم</option>
									@forelse($sections as $section)
									<option value="{{ $section->id }}">
										{{ $section->name }}
									</option>
									@empty

									@endforelse
								</select>
							</div>
							<div class="mb-3">
								<label for="description">وصف المنتج</label>
								<textarea name="description" id="description" class="form-control"></textarea>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button onclick="document.getElementById('edit-product').submit();" class="btn ripple btn-success" type="button">حفظ التغييرات</button>
						<button class="btn ripple btn-secondary" data-dismiss="modal" type="button">إغلاق</button>
					</div>
				</div>
			</div>
		</div>
		@endcan

		@can('اضافة منتج')
		<div class="modal effect-slide-in-right" id="modaldemo8">
			<div class="modal-dialog" role="document">
				<div class="modal-content modal-content-demo">
					<div class="modal-header">
						<h6 class="modal-title">إضافة منتج</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body">
						<form action="{{ route('products.store') }}" method="post" id="add-product">
							@csrf
							<div class="mb-3">
								<label for="product_name">إسم المنتج</label>
								<input type="text" autofocus name="product_name" autocomplete="off" class="form-control" id="product_name">
							</div>
							<div class="mb-3">
								<label for="section_id">القسم</label>
								<select name="section_id" id="section_id" class="form-control">
									<option value="NULL" disabled selected>إختر القسم</option>
									@forelse($sections as $section)
									<option value="{{ $section->id }}">
										{{ $section->name }}
									</option>
									@empty

									@endforelse
								</select>
							</div>
							<div class="mb-3">
								<label for="description">وصف المنتج</label>
								<textarea name="description" id="description" class="form-control"></textarea>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button onclick="document.getElementById('add-product').submit();" class="btn ripple btn-success" type="button">حفظ التغييرات</button>
						<button class="btn ripple btn-secondary" data-dismiss="modal" type="button">إغلاق</button>
					</div>
				</div>
			</div>
		</div>
		@endcan

		<div class="card">
			<div class="card-header pb-0">
				<div class="d-flex justify-content-between">
					<h4 class="card-title mg-b-0">قائمة المنتجات</h4>
					<i class="mdi mdi-dots-horizontal text-gray"></i>
				</div>
				<p class="tx-12 tx-gray-500 mb-2">عرض جميع المنتجات الموجودة</p>
				<a class="modal-effect btn btn-primary btn-sm mt-1" data-toggle="modal" href="#modaldemo8">إضافة منتج</a>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-hover text-md-nowrap" id="example1">
						<thead>
							<tr>
								<th class="border-bottom-0">#</th>
								<th class="border-bottom-0">إسم المنتج</th>
								<th class="border-bottom-0">الوصف</th>
								<th class="border-bottom-0">المنتج</th>
								<th class="border-bottom-0">خيارات</th>
							</tr>
						</thead>
						<tbody>
							@forelse($products as $product)
							<tr>
								<td>{{ $product->id }}</td>
								<td>{{ $product->product_name }}</td>
								<td>{{ $product->description }}</td>
								<td>{{ $product->section->name }}</td>
								<td class="text-center">
									<i data-toggle="modal" data-section="{{ $product->section->id }}" data-name="{{ $product->product_name }}" data-description="{{ $product->description }}" href="#modaldemo7" class="cursor-pointer edit-product fas fa-edit text-success ml-2"></i>
									<i data-toggle="modal" data-id="{{ $product->id }}" data-name="{{ $product->product_name }}" href="#modaldemo6" class="cursor-pointer delete-product fas fa-trash text-danger"></i>
								</td>
							</tr>
							@empty
							<tr>
								<td colspan="5">
									<div class="alert alert-info mb-0 text-center">لا يوجد منتجات بعد</div>
								</td>
							</tr>
							@endforelse
						</tbody>
					</table>
					<script>
						var editBtns = document.getElementsByClassName('edit-product'),
							editModal = document.getElementById('modaldemo7');
						for (i = 0; i < editBtns.length; i++) {
							editBtns[i].onclick = function() {
								let idField = editModal.querySelector('input#id'),
									nameField = editModal.querySelector('input#product_name'),
									descriptionField = editModal.querySelector('textarea#description'),
									sectionField = editModal.querySelectorAll('select#section_id option');

								for(let i = 0; i < sectionField.length; i++){
									if(sectionField[i].value == this.dataset.section){
										sectionField[i].setAttribute('selected', '');
									}
								}

								idField.value = this.dataset.id;
								nameField.value = this.dataset.name;
								descriptionField.value = this.dataset.description;
							}
						}

						var deleteBtns = document.getElementsByClassName('delete-product'),
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
<!-- row closed -->
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