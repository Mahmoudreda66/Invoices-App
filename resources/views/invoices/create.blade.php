@extends('layouts.master')

@section('title')
إضافة فاتورة
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
			<h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ إضافة فاتورة</span>
		</div>
	</div>
</div>
<!-- breadcrumb -->
@endsection

@section('content')
		<form enctype="multipart/form-data" action="{{ route('invoices.store') }}" method="post" autocomplete="off" class="p-3 rounded mb-3 bg-white">
			@csrf
			{{ method_field('POST') }}
			<div class="row">
				<div class="col-lg-4 col-sm-6 col-12 mb-3 mb-sm-0">
					<div class="mb-3">
						<label for="invoice_number">رقم الفاتورة</label>
						<input type="text" name="invoice_number" id="invoice_number" class="form-control 
						@error('invoice_number')
							is-invalid
						@enderror" autofocus>
						@error('invoice_number')
							<small class="invalid-feedback">{{ $message }}</small>
						@enderror
					</div>
				</div>
				<div class="col-lg-4 col-sm-6 col-12 mb-3 mb-sm-0">
					<div class="mb-3">
						<label for="invoice_date">تاريخ الفاتورة</label>
						<input type="date" name="invoice_date" id="invoice_date" class="form-control 
						@error('invoice_date')
							is-invalid
						@enderror" value="<?php echo date('Y-m-d');?>">
						@error('invoice_date')
							<small class="invalid-feedback">{{ $message }}</small>
						@enderror
					</div>
				</div>
				<div class="col-lg-4 col-sm-6 col-12 mb-3 mb-sm-0">
					<div class="mb-3">
						<label for="dve_date">تاريخ الإستحقاق</label>
						<input type="date" name="dve_date" id="dve_date" class="form-control 
						@error('dve_date')
							is-invalid
						@enderror">
						@error('dve_date')
							<small class="invalid-feedback">{{ $message }}</small>
						@enderror
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-4 col-sm-6 col-12 mb-3 mb-sm-0">
					<div class="mb-3">
						<label for="section">القسم</label>
						<select name="section" class="form-control 
						@error('section')
							is-invalid
						@enderror" id="section">
							<option value="NULL" disabled selected>إختر القسم</option>
							@foreach($sections as $section)
							<option value="{{ $section->id }}">
								{{ $section->name }}
							</option>
							@endforeach
						</select>
						@error('section')
							<small class="invalid-feedback">{{ $message }}</small>
						@enderror
					</div>
				</div>
				<div class="col-lg-4 col-sm-6 col-12 mb-3 mb-sm-0">
					<div class="mb-3">
						<label for="product">المنتج</label>
						<select disabled name="product" class="form-control 
						@error('product')
							is-invalid
						@enderror" id="product">
							<option value="NULL" disabled selected>إختر المنتج</option>
						</select>
						@error('product')
							<small class="invalid-feedback">{{ $message }}</small>
						@enderror
					</div>
				</div>
				<div class="col-lg-4 col-sm-6 col-12 mb-3 mb-sm-0">
					<div class="mb-3">
						<label for="collected_money">مبلغ التحصيل</label>
						<input type="number" name="collected_money" id="collected_money" class="form-control 
						@error('collected_money')
							is-invalid
						@enderror">
						@error('collected_money')
							<small class="invalid-feedback">{{ $message }}</small>
						@enderror
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-4 col-sm-6 col-12 mb-3 mb-sm-0">
					<div class="mb-3">
						<label for="commission">العمولة</label>
						<input type="number" name="commission" id="commission" class="form-control 
						@error('commission')
							is-invalid
						@enderror">
						@error('commission')
							<small class="invalid-feedback">{{ $message }}</small>
						@enderror
					</div>
				</div>
				<div class="col-lg-4 col-sm-6 col-12 mb-3 mb-sm-0">
					<div class="mb-3">
						<label for="discount">الخصم</label>
						<input type="number" value="0" name="discount" id="discount" class="form-control 
						@error('discount')
							is-invalid
						@enderror">
						@error('discount')
							<small class="invalid-feedback">{{ $message }}</small>
						@enderror
					</div>
				</div>
				<div class="col-lg-4 col-sm-6 col-12 mb-3 mb-sm-0">
					<div class="mb-3">
						<label for="rate_vat">نسبة ضريبة القيمة المضافة</label>
						<select name="rate_vat" id="rate_vat" class="form-control 
						@error('rate_vat')
							is-invalid
						@enderror" onchange="totals()">
							<option value="NULL" disabled selected>إختر النسبة</option>
							<option value="5">5%</option>
							<option value="10">10%</option>
							<option value="15">15%</option>
						</select>
						@error('rate_vat')
							<small class="invalid-feedback">{{ $message }}</small>
						@enderror
					</div>
				</div>
			</div>
			<div class="row mb-3">
				<div class="col-sm-6 col-12 mb-3 mb-sm-0">
					<label for="value_vat">قيمة ضريبة القيمة المضافة</label>
					<input type="text" name="value_vat" readonly id="value_vat" class="form-control 
						@error('value_vat')
							is-invalid
						@enderror">
					@error('value_vat')
						<small class="invalid-feedback">{{ $message }}</small>
					@enderror
				</div>
				<div class="col-sm-6 col-12 mb-3 mb-sm-0">
					<label for="total">الإجمالي شامل القيمة المضافة</label>
					<input type="text" name="total" readonly id="total" class="form-control 
						@error('total')
							is-invalid
						@enderror">
					@error('total')
						<small class="invalid-feedback">{{ $message }}</small>
					@enderror
				</div>
			</div>
			<div class="row">
				<div class="col-12 mb-3">
					<label for="note">ملاحظات</label>
					<textarea rows="7" name="note" id="note" class="form-control"></textarea>
				</div>
			</div>
			<div class="row">
				<div class="col-12 mb-3">
					<label for="dropify">المرفقات</label>
					@error('attachment')
						<small class="d-block mb-3 invalid-feedback">{{ $message }}</small>
					@enderror
					<input type="file" class="dropify 
					@error('attachment')
						is-invalid
					@enderror" id="dropify" data-height="200" name="attachment">
					<small class="mark d-inline form-text">الصيغ المتاحة فقط هي pdf, jpg, jpeg, png, gif</small>
				</div>
			</div>
			<div class="row">
				<div class="col-12 mb-3">
					<button class="btn btn-success btn-block">حفظ الفاتورة</button>
				</div>
			</div>
		</form>
		<script>
			const section = document.getElementById('section'),
				  productsSelect = document.getElementById('product');

			section.onchange = function () {

				productsSelect.setAttribute('disabled', '');
				productsSelect.innerHTML = '<option value="NULL" disabled selected>إختر المنتج</option>';

				let sectionValue = this.value,
					getProducts = new XMLHttpRequest();
					getProducts.open('GET', '/invoices/getProducts/' + sectionValue);

				getProducts.onload = function () {
					if(this.readyState === 4 && this.status === 200){ // succes
						productsSelect.removeAttribute('disabled', '');
						let products = JSON.parse(this.responseText);
						products.forEach(function (item) {
							let option = document.createElement('option'),
								text   = document.createTextNode(item['product_name']);
							option.appendChild(text);
							option.value = item['id'];
							productsSelect.appendChild(option);
						});
					}else{
						alert('لقد حدث خطأ غير متوقع');
					}
				}

				getProducts.send();

			}

			function totals () {
				let discount = document.getElementById('discount').value,
					rateVat = document.getElementById('rate_vat').value,
					commission = document.getElementById('commission').value;

				let amount = commission - discount,
					valueVat = amount * (rateVat / 100),
					total = valueVat + amount;

				document.getElementById('value_vat').value = valueVat;
				document.getElementById('total').value = total;
			}
		</script>
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