@extends('layouts.master')

@section('title')
الصفحة الرئيسية
@endsection

@section('css')
<!--  Owl-carousel css-->
<link href="{{URL::asset('assets/plugins/owl-carousel/owl.carousel.css')}}" rel="stylesheet" />
<!-- Maps css -->
<link href="{{URL::asset('assets/plugins/jqvmap/jqvmap.min.css')}}" rel="stylesheet">
@endsection

@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
	<div class="left-content">
		<div>
			<h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-2 mb-2">مرحباً بعودتك</h2>
			<p class="mg-b-0">لوحة التحكم وآخر الإحصائيات</p>
		</div>
	</div>
	<div class="main-dashboard-header-right">
		<div>
			<label class="tx-13">Customers Rate</label>
			<div class="main-star">
				<i class="typcn typcn-star active"></i> <i class="typcn typcn-star active"></i> <i class="typcn typcn-star active"></i> <i class="typcn typcn-star active"></i> <i class="typcn typcn-star"></i> <span>(14,873)</span>
			</div>
		</div>
		<div>
			<label class="tx-13">عدد الأقسام</label>
			<h5>
				{{ \App\Sections::count() }}
			</h5>
		</div>
		<div>
			<label class="tx-13">عدد المنتجات</label>
			<h5>{{ \App\Products::count() }}</h5>
		</div>
	</div>
</div>
<!-- /breadcrumb -->
@endsection
@section('content')
<!-- row -->
<div class="row row-sm">
	<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
		<div class="card overflow-hidden sales-card bg-primary-gradient">
			<div class="pl-3 pt-3 pr-3 pb-2 pt-0">
				<div class="">
					<h6 class="mb-3 tx-12 text-white">إجمالي الفواتير</h6>
				</div>
				<div class="pb-0 mt-0">
					<div class="d-flex">
						<div class="">
							<h4 class="tx-20 font-weight-bold mb-1 text-white">
								{{ number_format(\App\Invoices::sum('total'), 2) }}ج
							</h4>
							<p class="mb-0 tx-12 text-white op-7">
								{{ \App\Invoices::count() }} فاتورة
							</p>
						</div>
						<span class="float-right my-auto mr-auto">
							<i class="fas fa-arrow-circle-up text-white"></i>
							<span class="text-white op-7">100%</span>
						</span>
					</div>
				</div>
			</div>
			<span id="compositeline" class="pt-1">5,9,5,6,4,12,18,14,10,15,12,5,8,5,12,5,12,10,16,12</span>
		</div>
	</div>
	<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
		<div class="card overflow-hidden sales-card bg-danger-gradient">
			<div class="pl-3 pt-3 pr-3 pb-2 pt-0">
				<div class="">
					<h6 class="mb-3 tx-12 text-white">الفواتير الغير مدفوعة</h6>
				</div>
				<div class="pb-0 mt-0">
					<div class="d-flex">
						<div class="">
							<h4 class="tx-20 font-weight-bold mb-1 text-white">
								{{ number_format(\App\Invoices::where('status', 0)->sum('total'), 2) }}ج
							</h4>
							<p class="mb-0 tx-12 text-white op-7">
								{{ \App\Invoices::where('status', 0)->count() }} فاتورة
							</p>
						</div>
						<span class="float-right my-auto mr-auto">
							<i class="fas fa-arrow-circle-up text-white"></i>
							<span class="text-white op-7">
								{{ round((\App\Invoices::where('status', 0)->count() / \App\Invoices::count()) * 100, 2) }}%
							</span>
						</span>
					</div>
				</div>
			</div>
			<span id="compositeline2" class="pt-1">3,2,4,6,12,14,8,7,14,16,12,7,8,4,3,2,2,5,6,7</span>
		</div>
	</div>
	<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
		<div class="card overflow-hidden sales-card bg-success-gradient">
			<div class="pl-3 pt-3 pr-3 pb-2 pt-0">
				<div class="">
					<h6 class="mb-3 tx-12 text-white">الفواتير المدفوعة</h6>
				</div>
				<div class="pb-0 mt-0">
					<div class="d-flex">
						<div class="">
							<h4 class="tx-20 font-weight-bold mb-1 text-white">
								{{ number_format(\App\Invoices::where('status', 2)->sum('total'), 2) }}ج
							</h4>
							<p class="mb-0 tx-12 text-white op-7">
								{{ \App\Invoices::where('status', 2)->count() }} فاتورة
							</p>
						</div>
						<span class="float-right my-auto mr-auto">
							<i class="fas fa-arrow-circle-up text-white"></i>
							<span class="text-white op-7">
								{{ round((\App\Invoices::where('status', 2)->count() / \App\Invoices::count()) * 100, 2) }}%
							</span>
						</span>
					</div>
				</div>
			</div>
			<span id="compositeline3" class="pt-1">5,10,5,20,22,12,15,18,20,15,8,12,22,5,10,12,22,15,16,10</span>
		</div>
	</div>
	<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
		<div class="card overflow-hidden sales-card bg-warning-gradient">
			<div class="pl-3 pt-3 pr-3 pb-2 pt-0">
				<div class="">
					<h6 class="mb-3 tx-12 text-white">الفواتير المدفوعة جزئياً</h6>
				</div>
				<div class="pb-0 mt-0">
					<div class="d-flex">
						<div class="">
							<h4 class="tx-20 font-weight-bold mb-1 text-white">
								{{ number_format(\App\Invoices::where('status', 1)->sum('total'), 2) }}ج
							</h4>
							<p class="mb-0 tx-12 text-white op-7">
								{{ \App\Invoices::where('status', 1)->count() }} فاتورة
							</p>
						</div>
						<span class="float-right my-auto mr-auto">
							<i class="fas fa-arrow-circle-up text-white"></i>
							<span class="text-white op-7">
								{{ round((\App\Invoices::where('status', 1)->count() / \App\Invoices::count()) * 100, 2) }}%
							</span>
						</span>
					</div>
				</div>
			</div>
			<span id="compositeline4" class="pt-1">5,9,5,6,4,12,18,14,10,15,12,5,8,5,12,5,12,10,16,12</span>
		</div>
	</div>
</div>
<!-- row closed -->

<!-- row opened -->
<div class="row row-sm">
	<div class="col-md-12 col-lg-12 col-xl-7">
		<div class="card">
			<div class="card-header bg-transparent pd-b-0 pd-t-20 bd-b-0">
				<div class="d-flex justify-content-between">
					<h4 class="card-title mb-0">مخطط نسب الفواتير</h4>
					<i class="mdi mdi-dots-horizontal text-gray"></i>
				</div>
				<p class="tx-12 text-muted mb-0">يتم عرض مخطط الفواتير بالنسب المئوية</p>
			</div>
			<div class="card-body">
				<div>
					{!! $chartjs->render() !!}
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-12 col-xl-5">
		<div class="card">
			<div class="card-header bg-transparent pd-b-0 pd-t-20 bd-b-0">
				<div class="d-flex justify-content-between">
				<label class="main-content-label">مخطط أعداد الفواتير</label>
					<i class="mdi mdi-dots-horizontal text-gray"></i>
				</div>
				<span class="d-block mg-b-20 text-muted tx-12">يتم عرض مخطط الفواتير بالأعداد</span>
			</div>
			<div class="card-body">
				<div>
					{!! $chartjs2->render() !!}
				</div>
			</div>
		</div>
	</div>
</div>
<!-- row closed -->
</div>
</div>
<!-- Container closed -->
@endsection
@section('js')
<!--Internal  Chart.bundle js -->
<script src="{{URL::asset('assets/plugins/chart.js/Chart.bundle.min.js')}}"></script>
<!-- Moment js -->
<script src="{{URL::asset('assets/plugins/raphael/raphael.min.js')}}"></script>
<!--Internal  Flot js-->
<script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.js')}}"></script>
<script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.pie.js')}}"></script>
<script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.resize.js')}}"></script>
<script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.categories.js')}}"></script>
<script src="{{URL::asset('assets/js/dashboard.sampledata.js')}}"></script>
<script src="{{URL::asset('assets/js/chart.flot.sampledata.js')}}"></script>
<!--Internal Apexchart js-->
<script src="{{URL::asset('assets/js/apexcharts.js')}}"></script>
<!-- Internal Map -->
<script src="{{URL::asset('assets/plugins/jqvmap/jquery.vmap.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
<script src="{{URL::asset('assets/js/modal-popup.js')}}"></script>
<!--Internal  index js -->
<script src="{{URL::asset('assets/js/index.js')}}"></script>
<script src="{{URL::asset('assets/js/jquery.vmap.sampledata.js')}}"></script>
@endsection