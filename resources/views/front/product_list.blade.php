@extends('front.layouts.main')

@section('custom_css')
	<style>
		.input_search input[type="text"]{
			border-right: none;
			border-color: #c6c6c6;
			border-radius: 0px;
		}
		.input_search .input-group-append{
			border-top: 1px solid #c6c6c6;
			border-right: 1px solid #c6c6c6;
			border-bottom: 1px solid #c6c6c6;
			background-color: #ffffff;
		}
		.input_search .input-group-append i{
			color: #c6c6c6;
			font-size: 24px;
			margin-top: 4px;
			margin-right: 6px;
		}
	</style>
	<style type="text/css">
		.recommend_area{
			display: inline-block;
		    position: absolute;
		    right: 10px;
		    color: #fff;
		    background-color: #1e7e34;
		    /* border-color: #1c7430; */
		    /* box-shadow: 0 0 0 0.2rem rgba(40,167,69,.5); */
		    padding: 2px 15px;
		}
	</style>
@stop

@section('content')

{{-- @include('front.layouts.project-list-breadcrums-search') --}}

<hr>

<div class="container">
<div class="mt20">
	<div class="row justify-content-center">
		<div class="col-md-2">
				@include('front.layouts.product_menu')
		</div>
		<div class="col-md-8">
			<!-- Tab panes -->
			<div class="tab-content">
				<div class="tab-pane active" id="popular">
					<div class="row mb-4">
						<div class="col-md-5 offset-md-0">
							<span>{{$title}}   {{$products->total()}} 件</span>
						</div>
						<div class="col-md-2 offset-md-5">
							@include('front.layouts.product_sort')

						</div>
					</div>
					<div class="row projects">
					<?php
					$col = 3;
					foreach($products as $p){?>
						<div class="col-md-4">
							@include('front.layouts.product')
						</div>
					<?php }?>
					</div>

					<div class="row text-center">
							{!! $products->appends(request()->except('page'))->links() !!}
					</div>

				</div>

			</div>
		</div>

		{{-- <div class="col-md-2 mt50">
			@include('front.layouts.right_menu')
		</div> --}}
	</div>

</div>

</div>


@stop

@section('custom_js')
@yield('sort_js')
@stop
