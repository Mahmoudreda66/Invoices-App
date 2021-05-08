@extends('layouts.master')

@section('title')
تعديل الفاتورة
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
			<h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تعديل الفاتورة</span>
		</div>
	</div>
</div>
<!-- breadcrumb -->
@endsection

@section('content')
<form enctype="multipart/form-data" action="{{ route('invoices.update', $invoice->id) }}" method="post" autocomplete="off" class="p-3 rounded mb-3 bg-white">
	@csrf
	{{ method_field('PATCH') }}
	<div class="row">
		<div class="col-lg-4 col-sm-6 col-12 mb-3 mb-sm-0">
			<div class="mb-3">
				<label for="invoice_number">رقم الفاتورة</label>
				<input type="text" name="invoice_number" id="invoice_number" class="form-control 
						@error('invoice_number')
							is-invalid
						@enderror" autofocus value="{{ $invoice->invoice_number }}">
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
						@enderror" value="<?php echo date('Y-m-d'); ?>" value="{{ $invoice->invoice_date }}">
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
						@enderror" value="{{ $invoice->dve_date }}">
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
						@enderror" id="section" onchange="getProducts(this.value)">
					<option value="NULL" disabled>إختر القسم</option>
					@foreach($sections as $section)
					<option value="{{ $section->id }}" @if($section->id == $invoice->section)
						selected
						@endif
						>
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
				<select name="product" class="form-control 
						@error('product')
							is-invalid
						@enderror" id="product">
					<option value="NULL" disabled>إختر المنتج</option>
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
						@enderror" value="{{ $invoice->collected_money }}">
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
						@enderror" value="{{ $invoice->commission }}">
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
						@enderror" value="{{ $invoice->discount }}">
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
					<option @if ($invoice->rate_vat == 5)
						selected
						@endif
						value="5">5%</option>
					<option @if ($invoice->rate_vat == 10)
						selected
						@endif
						value="10">10%</option>
					<option @if ($invoice->rate_vat == 15)
						selected
						@endif
						value="15">15%</option>
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
						@enderror" value="{{ $invoice->value_vat }}">
			@error('value_vat')
			<small class="invalid-feedback">{{ $message }}</small>
			@enderror
		</div>
		<div class="col-sm-6 col-12 mb-3 mb-sm-0">
			<label for="total">الإجمالي شامل القيمة المضافة</label>
			<input type="text" name="total" readonly id="total" class="form-control 
						@error('total')
							is-invalid
						@enderror" value="{{ $invoice->total }}">
			@error('total')
			<small class="invalid-feedback">{{ $message }}</small>
			@enderror
		</div>
	</div>
	<div class="row">
		<div class="col-12 mb-3">
			<label for="note">ملاحظات</label>
			<textarea rows="7" name="note" id="note" class="form-control">{{ $invoice->note }}</textarea>
		</div>
	</div>
	@can('تغير حالة الدفع')	
	<div class="row mb-3">
		<div class="col-sm-6 col-12 mb-3 mb-sm-0">
			<label for="payment_status">حالة الدفع</label>
			<select name="payment_status" class="form-control 
				@error('payment_status')
					is-invalid
				@enderror" id="payment_status">
				<option value="NULL" disabled>إختر حالة الدفع</option>
				<option value="0" @if ($invoice->status == 0)
					selected
					@endif
					>لم يتم الدفع</option>
				<option value="1" @if ($invoice->status == 1)
					selected
					@endif
					>تم الدفع جزئياً</option>
				<option value="2" @if ($invoice->status == 2)
					selected
					@endif
					>تم الدفع</option>
			</select>
			@error('payment_status')
			<small class="invalid-feedback">{{ $message }}</small>
			@enderror
		</div>
		<div class="col-sm-6 col-12 mb-3 mb-sm-0">
			<label for="payment_date">تاريخ الدفع</label>
			<input type="date" name="payment_date" id="payment_date" class="form-control 
				@error('payment_date')
					is-invalid
				@enderror" value="<?php echo date('Y-m-d'); ?>">
				@error('payment_date')
				<small class="invalid-feedback">{{ $message }}</small>
				@enderror
		</div>
	</div>
	<div class="row" style="display: none;" id="no-pa-ar">
		<div class="col-12 mb-3">
			<label for="payment_note">ملاحظات على حالة الدفع</label>
			<textarea rows="7" name="payment_note" id="payment_note" class="form-control"></textarea>
		</div>
	</div>
	@endcan
	<div class="row">
		<div class="col-12 mb-3">
			<button class="btn btn-success btn-block">حفظ الفاتورة</button>
		</div>
	</div>
</form>
@can('تغير حالة الدفع')
	<script>
		const paymentStatusSelect = document.getElementById('payment_status');
		paymentStatusSelect.onchange = function() {
			if (paymentStatusSelect.value != '{{ $invoice->status }}') {
				document.getElementById('no-pa-ar').style.display = 'block';
				console.log('{{ $invoice->status }}', paymentStatusSelect.value)
			} else {
				document.getElementById('no-pa-ar').style.display = 'none';
			}
		}
	</script>
@endcan
<script>
	function getProducts(target) {

		document.getElementById('product').innerHTML = '<option value="NULL" disabled selected>إختر المنتج</option>';

		let getProducts = new XMLHttpRequest();
		getProducts.open('GET', '/invoices/getProducts/' + target);

		getProducts.onload = function() {
			if (this.readyState === 4 && this.status === 200) { // succes
				let products = JSON.parse(this.responseText);
				products.forEach(function(item) {
					let option = document.createElement('option'),
						text = document.createTextNode(item['product_name']);
					option.appendChild(text);
					option.value = item['id'];
					if (item['id'] == '{{ $invoice->product }}') {
						option.setAttribute('selected', '');
					}else{
						console.log(item['id'], '{{ $invoice->product }}');
					}
					productsSelect.appendChild(option);
				});
			} else {
				alert('لقد حدث خطأ غير متوقع');
			}
		}

		getProducts.send();
	}

	function totals() {
		let discount = document.getElementById('discount').value,
			rateVat = document.getElementById('rate_vat').value,
			commission = document.getElementById('commission').value;

		let amount = commission - discount,
			valueVat = amount * (rateVat / 100),
			total = valueVat + amount;

		document.getElementById('value_vat').value = valueVat;
		document.getElementById('total').value = total;
	}

	let section = document.getElementById('section'),
		productsSelect = document.getElementById('product');

	getProducts(section.value);
</script>
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->
@endsection