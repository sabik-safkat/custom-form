@extends('user.layouts.main')

@section('custom_css')
	<style type="text/css">
		.wizard > .steps > ul > li {
		    width: 20%;
		}
		.amount{
			border: 1px solid black !important;
			padding: 5px;
		}
		.no-border{
			border: none;
		}
		.box{
			border: 1px solid black !important;
		}
		.padding{
			padding: 10px;
		}
		.heading:after{
			display: block;
			height: 3px;
			background-color: #80b9f2;
			content: "";
			width: 100%;
			margin: 0 auto;
			margin-top: 10px;
			margin-bottom: 30px;
		}
		.bg-dark{
			background-color: #c6c6c6;
		}
		.div-radius{
			border: 3px solid #eaebed;
			border-radius: 5px;
		}
		.div-radius1{
			/* border: 3px solid #eaebed; */
			border-radius: 5px;
		}
		.horizontal:after{
			display: block;
			height: 2px;
			background-color: #999;
			content: "";
			width: 100%;
			margin: 0 auto;
			margin-top: 10px;
			margin-bottom: 45px;
		}
		.bg-danger{
			/* opacity: 0.9 !important; */
			background-color: #ffe3da !important;
		}

	.project_status {
    position: absolute;
    top: 15px;
    left: 3px;
    width: auto;
    padding: 5px;
    padding-left: 15px;
    padding-right: 15px;
    text-align: center;
		background-color: #ff6540;
	}
	.project-item{
		position: relative;
	}
	.icon-info{
		border: 2px solid #ff3300;
		padding-right: 10px;
		padding-left: 10px;
		padding-top: 1px;
		padding-bottom: 1px;
		border-radius: 50%;
		color: #ff3300;
		background-color: #ffffff;


	}



	</style>
@stop


@section('ecommerce')

@stop

@section('content')

@include('user.layouts.tab')


<div class="container">
	<div class="row">
	  <div class="offset-md-1 col-md-10 col-12">
			<div class="mt20">
				<div class="row">
					<div class="col-md-3">
						@include('user.layouts.profile')
					</div>
					<div class="col-md-9">

						
						@include('user.layouts.notifications')
						

						<div class="row">
							


							
							<div class="col-md-12 col-12 pt-3">
								<h4 class="heading">現在起案中のプロジェクト</h4>
							</div>
						</div>
						@if($projects)

						@foreach ($projects as $project)
							<?php
									$budget = $project->budget;
									$invested = $project->investment->where('status', true)->sum('amount');
									$done = $invested*100/$budget;
									$done = round($done);
								 ?>
							<div class="row horizontal">
								<div class="col-md-12 col-12">
									<div class="row inner">
									</div>

									<div class="row inner">
										<div class="col-md-12 col-12">
											<div class="row inner_inner">
												<div class="col-md-6">
													<div class="row">
														<div class="col-md-12 project-item">
															<img src="{{$project->featured_image ?  asset('uploads/projects/'.$project->featured_image) : asset('uploads/projects/1615154785167836.jpeg')}}" alt="" class="img-fluid">
															<?php if($project->status == 1){?>
																<div class="project_status {{strtotime($project->end) < strtotime(date('Y-m-d H:i:s')) ? 'status_3' : ($done >= 100?'status_2':'status_1')}}"><span>{{strtotime($project->end) < strtotime(date('Y-m-d H:i:s')) ? '終了' : ($done >= 100?'達成':'募集中')}}</span></div>
															<?php }else{?>																
																<div class="project_status"><span>申請中</span></div>
															<?php }?>
														</div>
													</div>
												</div>
												<div class="col-md-6">
													<div class="row ">
														<div class="col-md-7">
															<h6 class="" style="font-size:14px; color:#bfc5cc;"> <span style="color:#bfc5cc;"> 	<i class="fa fa-tag"></i> <a href="/?c={{ $project->category->id }} ">{{$project->category->name}}</a>
															</span></h6>
															</div>
														<div class="col-md-5">
															@php
																$fav = 0;
															@endphp
															@foreach ($project->favourite as $f)
																@if ($f->user_id == Auth::user()->id)
																	@php
																		$fav = 1;
																	@endphp
																@endif
															@endforeach
															@if ($fav == 0)
																<a  href="{{ route('user-favourite-add-project', $project->id) }}" class="pull-right" style="font-size:14px;"><span style="color:#ed49b6;"> <i class="fa fa-heart"></i> </span>お気に入りに追加 </a>
															@else
																<span class="pull-right" style="font-size:14px;"><span style="color:#555"> <i class="fa fa-heart-o"></i> </span>お気に入り</span>
															@endif
														</div>
													</div>
													<div class="row mt-1">
														<div class="col-md-9">
															<h5 style="font-size:16px;" class="font-weight-bold">{{$project->title}}</h5>
														</div>
													</div>

													<div class="row mt-3">
														<div class="col-md-9">
															<h5 style="font-size:21px; letter-spacing:2px;">現在 {{$invested}} 円 </h5>
															<div class="progress">
																<div class="progress-bar" role="progressbar" aria-valuenow="{{$done}}" aria-valuemin="0" aria-valuemax="100" style="width:{{$done}}%">
																{{$done}}%
																</div>
														</div>
													</div>
												</div>
												<div class="row  mt-3">
													<div class="col-md-9">
														<h5 style="font-size:19px; letter-spacing:2px;">目標 {{$budget}} 円</h5>
													</div>
												</div>
												<div class="row mt-3">
													<div class="col-md-offset-2 mr-0 div-radius ml-3" style="height:80px; width:80px !important;">
															<p class="text-center pt-2"><span class="pt-2 text-center" style="font-size:11px;">応援者</span>
															<br><span class="p-0 m-0 text-center" style="font-size:21px;">{{$project->investment->where('status', true)->count()}}人</span><p/>
													</div>
													
													@php
														$start = strtotime("now");
														$end = strtotime(date('Y-m-d 23:59:59', strtotime($project->end)));
														$days_between = ceil(abs($end - $start) / 86400);
														$hours_between = round((strtotime(date('Y-m-d 23:59:59', strtotime($project->end))) - strtotime("now"))/3600);
														$days_between = $hours_between <= 24?$hours_between:$days_between;
													@endphp

													<div class="col-md-offset-2 div-radius ml-2" style="height:80px; width:80px !important;">
															<p class="text-center pt-2"><span class="pt-2 text-center" style="font-size:11px;">残り日数</span>
															<br><span class="p-0 m-0 text-center" style="font-size:21px;">{{ $days_between }}日</span><p/>
													</div>
													<div class="col-md-6 offset-0">
														<div class="bg-dark div-radius1">
															<a href="{{ route('user-project-edit', $project->id) }}" class="p-2 editbtn text-white btn btn-md btn-block font-weight-bold" style="padding-top: 28px !important;padding-bottom: 28px !important;">編集する</a>
														</div>
													</div>
												</div>

											</div>
										</div>
									</div>
								</div>
							</div>
							<?php foreach($project->investment->where('status', true) as $in){?>
								<div class="col-md-12">
									<div class="p-3" style="font-size:18px">支援日:{{date('Y/m/d', strtotime($in->created_at))}}　　利用ポイント: {{$in->point}}ポイント <br>
										選択したリターン: {{$in->amount}} コース<br>
										起案者: {{$in->user->first_name.' '.$in->user->last_name}}
										<br> {{ $in->user->profile->phonetic }} ({{ $in->user->profile->phonetic2 }})<br>
										{{ $in->user->shipping_postal_code }} <br>
										{{ $in->user->shipping_prefecture }} <br>
										{{ $in->user->shipping_municipility }} <br> 
										{{ $in->user->shipping_address }} ,
										{{ $in->user->shipping_room_num }} <br>
										{{ $in->user->profile->phone_no }}
									</div>
										<hr>
								</div>
								
							<?php }?>	
							</div>
						@endforeach
					@endif
					<div class="row" style="margin-top: 30px;margin-bottom: 30px;">
						<div class="col-12 text-center">
							<a href="{{ route('user-project-add') }}" class="btn btn-primary">プロジェクトを起案申請する</a>
						</div>
					</div>
						{{-- repeat --}}



						{{-- repeat ends --}}

				</div>

			</div>

			</div>
	  </div>
	</div>
</div>


@stop

@section('custom_js')

@stop
