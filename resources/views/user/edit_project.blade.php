@extends('user.layouts.main')

@section('custom_css')
	<style type="text/css">
		.wizard > .steps > ul > li {
		    width: 24.3%;
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
		.hide{
			display: none;
		}
		.actions{
			text-align: center !important;
		}
		.page_title_product_register{
			padding-top: 10px;
			padding-bottom: 10px;
			font-size: 25px;
		}
		/*steps start*/
		.wizard>.steps .number{
			display: none !important;
		}
		.wizard>.steps .steptext{
			font-size: 18px;
			text-transform: uppercase;
		}
		.wizard>.steps .stepcount{
			font-size: 22px;
			font-weight: bold;
		}
		.wizard>.steps .stepinfo{
			font-size: 18px;
			display: block;
		}
		.wizard>.steps a, .wizard>.steps a:hover, .wizard>.steps a:active{
			padding: 15px;
		    padding-top: 5px;
		    padding-bottom: 5px;
		    border-radius: 0px;
		    position: relative;
		}
		.wizard>.steps .current a, .wizard>.steps .current a:hover, .wizard>.steps .current a:active{
			background-color: #039aff;
			padding-left: 42px;
			margin-left: -8px;
		}
		.wizard>.steps .current a:after{
			content: '';
		    background: #039aff;
		    height: 50px;
		    width: 50px;
		    position: absolute;
		    top: 10px;
		    right: -24px;
		    transform: rotate(45deg);
		    z-index: 9;
		}
		.wizard>.steps .disabled a, .wizard>.steps .disabled a:hover, .wizard>.steps .disabled a:active, .wizard>.steps .done a, .wizard>.steps .done a:hover, .wizard>.steps .done a:active{
			margin-left: -8px;
			padding-left: 42px;
			border: 2px solid #039aff;
			background-color: #ffffff;
			padding-top: 3px;
    		padding-bottom: 3px;
    		position: relative;
    		border-right: none;
    		/* border-left: none; */
		}
		.wizard>.steps .done a, .wizard>.steps .done a:hover, .wizard>.steps .done a:active{
			margin-left: -8px;
			border-left: 2px solid #039aff;
			color: #aaaaaa;
		}
		.wizard>.steps .disabled a:after, .wizard>.steps .done a:after{
			content: '';
		    border-top: 2px solid #039aff;
		    border-right: 2px solid #039aff;
		    height: 50px;
		    width: 50px;
		    position: absolute;
		    top: 8.9px;
		    right: -24px;
		    transform: rotate(45deg);
		    z-index: 9;
		    background-color: #ffffff;
		}
		.wizard>.steps ul li:first-child a{
			margin-left: 0px !important;
		}
		.wizard>.steps ul{
			margin-left: 0% !important;
			margin-top: 0px !important;
		}
		/*steps end*/
		.right_arrow_area{
			position: relative;
		}
		.right_arrow_area:after{
			content: '~';
		    display: block;
		    position: absolute;
		    top: 3px;
		    right: -6px;
		    font-size: 20px;
		    font-weight: 400;
		}
		.wizard>.actions a, .wizard>.actions a:hover, .wizard>.actions a:active{
			background: #039aff;
		}
		@media (max-width: 575.98px) {
			.wizard > .steps > ul > li{
		        width: 93% !important;
		    }
		    .wizard>.steps a, .wizard>.steps a:hover, .wizard>.steps a:active{
		        border-left: 2px solid #039aff !important;
		        margin-left: 0px !important;
		    }
		}

	</style>
@stop


@section('ecommerce')

@stop

@section('content')
@include('user.layouts.tab')

<div class="container" id="new-project">
	<div class="mt20">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<h1 class="text-center page_title_product_register">プロジェクトを申請する</h1>
				<form id="example-form" action="" class="mt20" method="post" enctype="multipart/form-data">
					{{ csrf_field() }}
					<input type="hidden" name="status" value="{{ $project->status }}">
					<div class="mt20">
						<h3 class="step_title_area">
							<span class="steptext">Step</span><span class="stepcount">1</span>
							<span class="stepinfo">基本情報入力</span>
						</h3>
						<section class="mt-3">
							<div class="form-group">
								<label for="">プロジェクト名</label>
								<input type="text" class="form-control col-12 length35_1 required" placeholder="" name="title" value="{{ $project->title }}" required>
								<span id="length35_1" class="text-danger"></span>
							</div>
							<div class="form-group">
								<label for="category">カテゴリ(分類)</label>
								<select class="form-control required col-12" name="category">
									<option value="">選択する</option>
									<?php foreach($category as $c){?>
										<option value="{{$c->id}}" {{$project->category_id == $c->id?'selected':''}}>{{$c->name}}</option>
									<?php }?>
									</select>
							</div>
							<div class="form-group">
									<label for="featured_image">画像</label> <br>
									<button class="btn btn-sm btn-default" id="upfile1">ファイルを選択</button>
									<input type="file" id="file1" class="col-12 d-none" name="featured_image">
									<span id="select_file" class="ml-3">選択されていません</span>
								</div>
							<div class="form-group">
								<label for="description">プロジェクト概要</label>
								<textarea name="description" id="description" rows="8" cols="80" class="form-control required col-12 length2k_1 ckeditor" maxlength="201">{{ $project->description }}</textarea>
								<span id="length2k_1" class="text-danger"></span>
								<span id="description_message" class="text-danger"></span>
							</div>
							<div class="form-group">
								<label for="purpose">目的</label>
								<input type="text" class="form-control required col-12 length200_1" placeholder="" name="purpose" value="{{$project->purpose}}">
								<span id="length200_1" class="text-danger"></span>
							</div>
							<div class="form-group">
								<label for="">目標金額</label>
								<input type="number" class="form-control required col-12" placeholder="" name="budget" value="{{$project->budget}}" min="0">
							</div>
								<div class="row">
									<div class="col-md-12">
											<label for="">募集期間</label>
										<div class="row" style="margin:0px;">
											<div class="col">
												<input type="hidden" id="from" class="calculateDay" name="from">
											</div>
											<div class="text-center" style="width:50px;">
												~
											</div>
											<div class="col">
												<input type="hidden" id="to" class="calculateDay" name="to">
											</div>
													
											<div class="form-group" style="width:100px;">
												<input type="text" class="form-control required " placeholder="" value="0" name="total_day" readonly id="totalDay">
											</div>
										</div>
									</div>
								</div>
						
										<div class="form-group">
											<label for="">支援金受取人名</label>
											<input type="text" class="form-control required col-12 length30_2" name="beneficiary" value="{{ $project->beneficiary }}">
											<span id="length30_2" class="text-danger"></span>
										</div>
										<div class="form-group hide">
											<label for="sub_category">その他内容</label>
											<input type="text" class="form-control  col-12 length30_3" name="sub_category" value="{{ $project->sub_category }}">
											<span id="length30_3" class="text-danger"></span>
										</div>

										<div class="form-group">
											<label for="budget_usage_breakdown">予算用途の内訳</label>
											<textarea name="budget_usage_breakdown" rows="8" cols="80" class="form-control required col-12 length2k_2">{{$project->budget_usage_breakdown}}</textarea>
											<span id="length2k_2" class="text-danger"></span>
										</div>
									</section>
									<h3 class="step_title_area">
										<span class="steptext">Step</span><span class="stepcount">2</span>
										<span class="stepinfo">リターン情報入力</span>
									</h3>
									<section>
										@if ($project->reward)
											@foreach ($project->reward as $r)
											<div class="row mt20">
											<div class="col-md-12">
												<div class="row">
												<input type="hidden" name="reward_id[]" value="{{$r->id}}">
													<label for="amount[]" class="col-md-12">金額</label>
													<div class="col-md-4"> <input type="number" class="required form-control amount amount_{{ $r->id }}" data-row="{{ $r->id }}" name="amount[]" value="{{ $r->amount }}" min="1" required>
													</div>	<sub class="p-0 mt-4 mr-3">円</sub>
												</div>
											</div>
											<div class="col-md-12 mt-3">
												<div class="row">
													<label for="is_crofun_point[]" class="col-md-12">Crofunポイント  <span class="text-danger" data-toggle="modal" data-target="#add-project">(?)</span> </label>
													<div class="col-md-4">
														<input type="number" class="form-control required point point_{{ $r->id }}" data-row="{{ $r->id }}" name="is_crofun_point[]" value="{{ $r->is_crofun_point }}" min="1" required>
														<span class="text-danger pointMsg_{{ $r->id }}"></span>
													</div>
													<sub class="p-0 mt-4 mr-3">pt</sub>
													{{-- <div class="col-md-3 p-0">pt</div> --}}
												</div>
											</div>
											<div class="col-md-12 mt-3">
												<div class="row">
													<label for="is_other[]" class="col-md-12">リターン品名</label>
													<div class="col-md-4">
														<span class="is_other_message text-danger"></span>
														<input type="text" class="form-control required is_other" name="is_other[]" value="{{ $r->is_other }}" required maxlength="21">
													</div>
												</div>
											</div>
											<div class="col-md-12 mt-3">
												<div class="row">
													<label for="other_description[]" class="col-md-12">内容</label>
													<div class="col-md-10">
														<span class="other_description_message text-danger"></span>
														<textarea name="other_description[]" rows="8" cols="80" class="form-control required other_description" required maxlength="200">{{ $r->other_description }}</textarea>
													</div>
												</div>
											</div>
											<div class="col-md-12 mt-3">
												<div class="row">
													<label for="other_file[]" class="col-md-12">写真</label>
													<div class="col-md-4"><input type="file" class="" name="other_file[]"></div>
												</div>
											</div>
										</div>

									@endforeach
										@endif

									</section>
									<h3 class="step_title_area">
										<span class="steptext">Step</span><span class="stepcount">3</span>
										<span class="stepinfo">追加情報入力</span>
									</h3>
									<section>
										@if ($project->details)
											@foreach ($project->details as $d)
												<div class="mb-5">
											<div class="form-group">
												<input type="hidden" name="details_id[]" value="{{$d->id}}">
												<label for="details_title[]">見出しタイトル</label>
												<input type="text" class="form-control required col-12" placeholder="" name="details_title[]" value="{{$d->details_title}}">
											</div>
											<div class="form-group">
												<label for="details_description[]">内容</label>
												<textarea name="details_description[]" class="form-control required col-12" rows="8" cols="80">{{$d->details_description}}</textarea>
											</div>
											<div class="form-group file_upload_section">
													<button class="btn btn-sm btn-default upfile_step3" id="">ファイルを選択</button>
													<span id="" class="ml-3 select_file_step3">選択されていません</span>
													{{-- <label for="draft_file[]" class="col-md-12">見出しタイトル</label> --}}
													<input type="file" id="" class="required col-10 d-none file_step3" placeholder="" name="draft_file[]">
												</div>


										</div>

											@endforeach
										@endif
									</section>
									<h3 class="step_title_area">
										<span class="steptext">Step</span><span class="stepcount">4</span>
										<span class="stepinfo">申請完了</span>
									</h3>
									<section>
										<h4 class="text-center mt20">
											プロジェクト申請が完了しました。
										</h4>
										{{-- <h4 class="text-center mt20">
											<a href="{{route('user-project-list')}}">→ マイページへ</a>
										</h4> --}}
										<h4 class="text-center mt20">
											<a href="{{route('user-project-list')}}" class="btn btn-md text-white" style="background-color:#C6C6C6;">< 戻る</a>

										</h4>
									</section>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>


@include('user.layouts.add-project')
@stop

@section('custom_js')

	{{-- <script src="//cdn.ckeditor.com/4.8.0/basic/ckeditor.js"></script> --}}
	{{-- <script src="{{Request::root()}}/ckeditor/ckeditor.js"></script> --}}

	<script type="text/javascript" src="{{Request::root()}}/js/jquery.validate.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/jquery-dropdown-datepicker@1.3.0/dist/jquery-dropdown-datepicker.min.js"></script>
	
	<script type="text/javascript">
		$(document).on('click', '#upfile1', function(){
			$("#file1").trigger('click');
			$('#file1').change(function() {
				var filename = $('#file1').val();
				$('#select_file').html(filename);
			});
			return false;

		});

	</script>
	<script type="text/javascript">
		$(document).on('click', '.upfile_step3', function(){
			$(this).parent('.file_upload_section').find('.file_step3').trigger('click');
			$(this).parent('.file_upload_section').find('.file_step3').change(function() {
				var filename = $(this).parent('.file_upload_section').find('.file_step3').val();
				$(this).parent('.file_upload_section').find('.select_file_step3').html(filename);
			});
			return false;
		});

		$(document).on('click', '.close', function(){
			$(this).closest('.'+$(this).attr('data-target')).remove();
		});
	</script>

	<script type="text/javascript">
		$(document).ready(function () {
			$('.amount').on('keyup', function(){
				var rowid = $(this).attr('data-row');
				// console.log($(this).val());
				amount = $(this).val();
				amountLength = amount.length;
				// console.log(amountLength);
				// console.log(rowid);
				if ($('.point_'+rowid).val().length > 0) {
					point = $('.point_'+rowid).val();
					// console.log(pointLength);
				}else {
					point = 0;

				}
				check(rowid , point , amount);
			});
			$('.point').on('keyup', function(){
				var rowid = $(this).attr('data-row');
				// console.log($(this).val());
				// console.log(rowid);
				point = $(this).val();
				amount = $('.amount_'+rowid).val();

				pointLength = point.length;
				// console.log(pointLength);
				check(rowid , point , amount);

			});
			function check(rowid , point , amount){
				// console.log(point + 'point');
				// console.log(amount);


				if ( parseInt(point) > parseInt(amount)) {
					// console.log('fgdfgdfg');
					$('.pointMsg_' + rowid).html('ponit must be equal or less than amount');
				}else{
					$('.pointMsg_' + rowid).html('');
				}
			}

		});

		</script>


	<script type="text/javascript">
		$(document).ready(function(){
			var maxDate = null, minDate = null;
			$("#from").dropdownDatepicker({
				displayFormat: 'ymd',
				defaultDate: '{{date("Y-m-d", strtotime($project->start))}}',
				wrapperClass: 'row',
				dropdownClass: 'col form-control',
				allowPast: true,
				maxDate: maxDate,
				minYear: '{{date("Y", strtotime($project->start))}}',
				monthFormat: 'short',
				// Identifies the "Day" dropdown
				dayLabel: '日',

				// Identifies the "Month" dropdown
				monthLabel: '月',

				// Identifies the "Year" dropdown
				yearLabel: '年',
				sortYear: 'asc',
				// Long month dropdown values (can be overridden for internationalisation purposes)
				monthLongValues: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],

				// Short month dropdown values (can be overridden for internationalisation purposes)
				// monthShortValues: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
				monthShortValues: ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月'],

				// Initial dropdown values (can be overridden for internationalisation purposes)
				initialDayMonthYearValues: ['Day', 'Month', 'Year'],

				// Ordinal indicators (can be overridden for internationalisation purposes)
				// daySuffixValues: ['st', 'nd', 'rd', 'th']
				daySuffixValues: ['日', '日', '日', '日'],
				onChange: function(day, month, year){
					if(day!=null && month!=null && year!=null){
						$("#to").dropdownDatepicker('destroy');
						minDate = year+'-'+month+'-'+day;
						maxDate = new Date(minDate);
						maxDate.setDate(maxDate.getDate()+69);
						maxDate = maxDate.getFullYear()+'-'+(maxDate.getMonth()+1)+'-'+maxDate.getDate();
						createToDate();
					}
				}
			});
			var createToDate = function(){
				$("#to").dropdownDatepicker({
					displayFormat: 'ymd',
					defaultDate: '{{date("Y-m-d", strtotime($project->end))}}',
					wrapperClass: 'row',
					dropdownClass: 'col form-control',
					allowPast: true,
					minDate: minDate,
					maxDate: maxDate,
					monthFormat: 'short',
					// Identifies the "Day" dropdown
					dayLabel: '日',

					// Identifies the "Month" dropdown
					monthLabel: '月',

					// Identifies the "Year" dropdown
					yearLabel: '年',
					sortYear: 'asc',
					// Long month dropdown values (can be overridden for internationalisation purposes)
					monthLongValues: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],

					// Short month dropdown values (can be overridden for internationalisation purposes)
					// monthShortValues: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
					monthShortValues: ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月'],

					// Initial dropdown values (can be overridden for internationalisation purposes)
					initialDayMonthYearValues: ['Day', 'Month', 'Year'],

					// Ordinal indicators (can be overridden for internationalisation purposes)
					// daySuffixValues: ['st', 'nd', 'rd', 'th']
					daySuffixValues: ['日', '日', '日', '日']
				});
			}

			createToDate();
		});
	</script>


	<script type="text/javascript">
		var form = $("#example-form");
		form.validate({
		    errorPlacement: function errorPlacement(error, element) { element.before(error); },
		});

		form.children("div").steps({
		    headerTag: "h3",
		    bodyTag: "section",
		    transitionEffect: "slideLeft",
		    // startIndex: 1,
		    startIndex: {{$finish?3:0}},
		    showFinishButtonAlways: false,


		    /* Labels */
		    labels: {
		        cancel: "Cancel?",
		        current: "current step:",
		        pagination: "Pagination",
		        finish: "完了!!",
		        next: "次へ >",
		        previous: "< 前へ",
		        loading: "Loading ..."
		    },

		  	onInit: function(event, currentIndex, newIndex){
		  		if(currentIndex == 3){
		        	$('.actions > ul > li:nth-child(1)').attr('style', 'display:none;');
		        	$('.actions > ul > li:nth-child(2)').attr('style', 'display:none;');
		        	$('.actions > ul > li:nth-child(3)').attr('style', 'display:none;');
		        }
		        $('.steps .current').prevAll().removeClass('done').addClass('disabled');
		  	},
		    onStepChanging: function (event, currentIndex, newIndex)
		    {
						// alert('-----' + currentIndex + '-----' + newIndex);

						var check = 0;
						if (currentIndex == 0) {

							if ($('.length35_1').val().length > 35) {
								$('#length35_1').html('35文字以内でご記入ください ');
								check = 1;
							}
							// if ($('.length2k_1').val().length > 2000) {
							// 	$('#length2k_1').html('2000文字以内でご記入ください ');
							// 	check = 1;
							// }
							if ($('.length2k_2').val().length > 2000) {
								$('#length2k_2').html('2000文字以内でご記入ください ');
								check = 1;
							}
							if ($('.length30_2').val().length > 30) {
								$('#length30_2').html('30文字以内でご記入ください  ');
								check = 1;
							}
							if ($('.length30_3').val().length > 30) {
								$('#length30_3').html('30文字以内でご記入ください  ');
								check = 1;
							}
							if ($('.length200_1').val().length > 200) {
								$('#length200_1').html('200文字以内でご記入ください  ');
								check = 1;
							}
							

							if (check == 1) {
								return false;
							}


						}
		        form.validate().settings.ignore = ":disabled,:hidden";
        		return form.valid();
        		// return true;
		    },
		    onStepChanged: function (event, currentIndex, newIndex)
		    {
		        if(currentIndex == 2){
		        	$('.actions > ul > li:last-child').attr('style', '');
		        	$('.actions > ul > li:nth-child(2)').attr('style', 'display:none;');
		        }
		    },
		    onFinishing: function (event, currentIndex)
		    {
		        form.validate().settings.ignore = ":disabled,:hidden";
        		return form.valid();
        		// return true;
		    },
		    onFinished: function (event, currentIndex)
		    {
		        form.submit();
		    }
		});

		var calculateDay = function(){
			// console.log('calculate day');
			var d1 = $('#from').val()+'T00:00:01';
			// console.log(d1);
			var date1 = new Date(d1);
			// console.log(date1.getTime());
			var d2 = $('#to').val()+'T23:59:59';
			// console.log(d2);
			var date2 = new Date(d2);
			// console.log('date2 '+d1);
			// console.log('date1 '+date2.getTime());

			// console.log($('.toshowM').val());

			timeDiff = date2.getTime() - date1.getTime();
			// console.log('timeDiff');
			// console.log(timeDiff);

			if(timeDiff < 0){
				alert('invalid date');
				return false;
			}
			var timeDiff = Math.abs(timeDiff);
			var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
			// console.log('diffDays');
			// console.log(diffDays);
			if(diffDays > 70){
				alert('maximum day is 70.You have selected '+diffDays+' days');
				this.selectedIndex = $(this).data('lastSelectedIndex');
				e.preventDefault();
				return false;
			}

			if(isNaN(diffDays)){
				diffDays = '';
			}

			$('#totalDay').val(diffDays);
		}

		setTimeout(function(){
			calculateDay();
		}, 1000);
		


		

		$('.calculateDay').on('change', calculateDay);


		var basic = [
		  ['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink', '-', 'About']
		];





		$('.add_details').on('click', function(){
			var content = $('.details').html();
			$('.details_container').before(content);
			// CKEDITOR.replace( 'ckeditor' );
			// CKEDITOR.replaceClass = 'ckeditor';

		})
		$('.add_reward').on('click', function(){
			var content = $('.reward').html();
			$('.reward_button_area').before(content);
		})



		// console.log('new project');
		// $(function(){
		// 	CKEDITOR.replace( 'editor', {
		// 	    toolbar: basic
		// 	} );
		// 	// CKEDITOR.replaceClass = 'ckeditor';
		// 	CKEDITOR.replace( 'description' ,{
		// 		// filebrowserBrowseUrl : 'ckeditor1/plugins/imageuploader/imgbrowser.php',
		// 		// filebrowserUploadUrl : '/browser1/upload/type/all',
		// 	    filebrowserImageBrowseUrl : '{{Request::root()}}/ckeditor/plugins/imageuploader/imgbrowser.php',
		// 		// filebrowserImageUploadUrl : '/browser3/upload/type/image',
		// 	    // filebrowserWindowWidth  : 800,
		// 	    // filebrowserWindowHeight : 500,
		// 		extraPlugins: 'imageuploader'
		// 		// extraPlugins: 'dropler'
		// 	});
		// })

	</script>



<script type="text/javascript">



$(document).ready(function () {
			$('#description').keyup(function(e){
				if ($(this).val().length > 200) {
					$('#description_message').html('200文字以内でご記入ください  ');
					e.preventDefault();
					return false;
				}else{
					$('#description_message').html('');
				}
			})

			$('.body').on('keyup', '.is_other' ,function(e){
				console.log('ok1');
				if ($(this).val().length > 20) {
					$(this).prev('.is_other_message').html('20文字以内でご記入ください   ');
					e.preventDefault();
					return false;
				}else{
					$(this).prev('.is_other_message').html('');
				}
			})

			$('.body').on('keyup', '.other_description', function(e){
				console.log('ok1');
				if ($(this).val().length > 200) {
					$(this).prev('.other_description_message').html('200文字以内でご記入ください   ');
					e.preventDefault();
					return false;
				}else{
					$(this).prev('.other_description_message').html('');
				}
			})
	


	$('.body').on('keyup', '.amount', function(e){
		//alert('working');
		var amount = $(this).val();
		
		if(amount == '' || !english.test(amount)){
			e.preventDefault();
			$(this).val('');
			return false;
		}
		var is_crofun_point = $(this).parent('div').parent('div').parent('div').siblings('.is_crofun_point_div').find('.is_crofun_point').val();
		//console.log('amount');
		//console.log(amount);
		//console.log('is_crofun_point');
		//console.log(is_crofun_point);

		if ( parseFloat(is_crofun_point) > parseFloat(amount)) {
			$(this).parent('div').parent('div').parent('div').siblings('.is_crofun_point_div').find('.is_crofun_point_msg').removeClass('hide');
		}else{
			$(this).parent('div').parent('div').parent('div').siblings('.is_crofun_point_div').find('.is_crofun_point_msg').addClass('hide');
		}
	});

	$('.body').on('keyup', '.is_crofun_point', function(e){
		var is_crofun_point = $(this).val();
		if(is_crofun_point == '' || !english.test(is_crofun_point)){
			e.preventDefault();
			$(this).val('');
			return false;
		}
		var amount = $(this).parent('div').parent('div').parent('div').siblings('.amount_div').find('.amount').val();
		//console.log('amount');
		//console.log(amount);
		//console.log('is_crofun_point');
		//console.log(is_crofun_point);

		if ( parseFloat(is_crofun_point) > parseFloat(amount)) {
			$(this).siblings('.is_crofun_point_msg').removeClass('hide');
		}else{
			$(this).siblings('.is_crofun_point_msg').addClass('hide');
		}
	});
});
</script>

@stop
