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
		.error{
			color: red;
		}
		.close{
			cursor: pointer;
			color:red;
		}
		.details_div, .reward-div{
			margin-top: 20px;
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
					<div class="mt20">
						<h3 class="step_title_area">
							<span class="steptext">Step</span><span class="stepcount">1</span>
							<span class="stepinfo">基本情報入力</span>
						</h3>
						<section class="mt-3">
							<div class="form-group">
								<label for="">プロジェクト名
									<span id="length35_1" class="text-danger"></span>
								</label>
								<input type="text" class="form-control required col-12 length35_1" placeholder="" name="title">
							</div>
							<div class="form-group">
								<label for="category">カテゴリ(分類)</label>
								<select class="form-control required col-12" name="category">
									<option value="">選択する</option>
									<?php foreach($category as $c){?>
										<option value="{{$c->id}}">{{$c->name}}</option>
										<?php }?>
									</select>
							</div>
							<div class="form-group">
								<label for="featured_image">画像
									<span id="featured_image" class="text-danger"></span>
								</label> <br>
								<!-- <button class="btn btn-sm btn-default" id="upfile1">ファイルを選択</button> -->
								<input type="file" id="file1" class="col-12 btn featured_image required" name="featured_image">
								<!-- <span id="select_file" class="ml-3">選択されていません</span> -->
							</div>
							<div class="form-group">
								<label for="description">プロジェクト概要
									<span id="description_message" class="text-danger"></span>
								</label>
								<textarea name="description" id="description" rows="8" cols="80" class="form-control required col-12" maxlength="201"></textarea>
							</div>

							<div class="form-group">
								<label for="purpose">目的
									<span id="length200_1" class="text-danger"></span>
								</label>
								<input type="text" class="form-control required col-12 length200_1" placeholder="" name="purpose">
							</div>
							<div class="form-group">
								<label for="">目標金額</label>
								<input type="number" class="form-control required col-12" placeholder="" name="budget" min="0">
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
								<label for="">支援金受取人名
									<span id="length30_2" class="text-danger"></span>
								</label>
								<input type="text" class="form-control required col-12 length30_2" name="beneficiary">
							</div>
							<div class="form-group hide">
								<label for="sub_category">その他内容
									<span id="length30_3" class="text-danger"></span>
								</label>
								<input type="text" class="form-control  col-12 length30_3" name="sub_category">
							</div>

							<div class="form-group">
								<label for="budget_usage_breakdown">予算用途の内訳
									<span id="length2k_2" class="text-danger"></span>
								</label>
								<textarea id="budget_usage_breakdown" name="budget_usage_breakdown" rows="8" cols="80" class="form-control required col-12 length2k_2" maxlength="200"></textarea>
							</div>
						</section>
									<h3 class="step_title_area">
										<span class="steptext">Step</span><span class="stepcount">2</span>
										<span class="stepinfo">リターン情報入力</span>
									</h3>

									<!-- section 2 -->
									<section id="section2">
										<div class="row mt20">
											<div class="col-md-12 amount_div">
												<div class="row">
													<label for="amount" class="col-md-12">金額</label>
													<div class="col-md-4">
														<input type="number" class="form-control amount required" name="amount[]" min="1" required>
													</div>
													<sub class="p-0 mt-4 mr-3">円</sub>
												</div>
											</div>

											<div class="col-md-12 mt-3 is_crofun_point_div">
												<div class="row">
													<label for="is_crofun_point" class="col-md-12">Crofunポイント  <span class="text-danger" data-toggle="modal" data-target="#add-project">(?)</span> </label>
													<div class="col-md-4">
														<input type="number" class="form-control is_crofun_point required" name="is_crofun_point[]" min="1" required>
														<span class="is_crofun_point_msg hide text-danger">金額以上のCrofunポイントを設定できません。</span>
													</div>
													<sub class="p-0 mt-4 mr-3">pt</sub>
													{{-- <div class="col-md-3 p-0">pt</div> --}}
												</div>
											</div>

											<div class="col-md-12 mt-3">
												<div class="row">
													<label for="is_other" class="col-md-12">リターン品名</label>
													<div class="col-md-4">
														<span id="" class="text-danger is_other_message"></span>
														<input type="text" class="form-control required is_other" name="is_other[]" required maxlength="21">
													</div>
												</div>
											</div>
											<div class="col-md-12 mt-3">
												<div class="row">
													<label for="other_description" class="col-md-12">内容</label>
													<div class="col-md-10">
															<span id="" class="text-danger other_description_message"></span>
														<textarea name="other_description[]" rows="8" cols="80" class="form-control required other_description" required maxlength="201"></textarea>
													</div>
												</div>
											</div>
											 <div class="col-md-12 mt-3">
												<div class="row">
													<label for="other_file" class="col-md-12">写真</label>
													<div class="col-md-4"><input type="file" class="required" name="other_file[]"></div>
												</div>
											</div> 
										</div>
										<div class="row  mt-3 mb-3 reward_button_area">
											<div class="col-md-2 offset-4">
												<a href="javascript:;" class="btn btn-outline-info add_reward">+ さらに追加する</a>
											</div>
										</div>
										<div class="reward_container">
										</div>
									</section>

									<h3 class="step_title_area">
										<span class="steptext">Step</span><span class="stepcount">3</span>
										<span class="stepinfo">追加情報入力</span>
									</h3>

									<section>
										<div class="form-group">
											<label for="details_title[]">見出しタイトル</label>
											<input type="text" class="form-control  col-12" placeholder="" name="details_title[]">
										</div>

										<div class="form-group">
											<label for="details_description[]">内容</label>
											<textarea name="details_description[]" class="form-control col-12" rows="8" cols="80"></textarea>
										</div>

										<div class="form-group file_upload_section">
											<!-- <button class="btn btn-sm btn-default upfile_step3" id="">ファイルを選択</button> -->
											<!-- <span id="" class="ml-3 select_file_step3">選択されていません</span> -->
											<label for="draft_file[]" class="">写真</label>
											<br>
											<input type="file" id="" class=" col-10 file_step3" placeholder="" name="draft_file[]">
										</div>

										<div class="details_container"></div>
										<div class="row  mt-3 mb-3">
											<div class="col-md-2 offset-4">
												<a href="#!" class="btn btn-outline-info add_details">+ さらに追加する</a>
											</div>
										</div>
									</section>

									<h3 class="step_title_area">
										<span class="steptext">Step</span><span class="stepcount">4</span>
										<span class="stepinfo">申請完了</span>
									</h3>

									<section>
										<h4 class="text-center mt20 text-info">
											プロジェクト申請が完了しました。
										</h4>

										<h6 class="mt-5 text-center">プロジェクトの申請ありがとうございました。</h6>
										<h6 class="text-center">	これより審査に入れさせていただきます。</h6>
										<h6 class="text-center">	プロジェクトの公開までしばらくお待ちください。</h6>
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


	 <div class="hide reward">
		 <div class="row mt20 reward_div">
			 <hr>
		 	<div class="col-md-12 amount_div">
		 		<div class="row">
					 <label for="amount" class="col-md-12">金額 <span class="close float-right" data-target="reward_div">X</span></label>
					 
		 			<div class="col-md-4">
						 <input type="number" class="form-control amount required" name="amount[]" min="1" required>
					 </div>	<sub class="p-0 mt-4 mr-3">円</sub>
				 </div>
			 </div>

			 <div class="col-md-12 mt-3 is_crofun_point_div">
				 <div class="row">
					 <label for="is_crofun_point" class="col-md-12">Crofunポイント</label>
					 <div class="col-md-4">
						 <input type="number" class="form-control is_crofun_point required" name="is_crofun_point[]" min="1" required>
						 <span class="is_crofun_point_msg hide text-danger">金額以上のCrofunポイントを設定できません。</span>
					 </div>	<sub class="p-0 mt-4 mr-3">pt</sub>
				 </div>
			 </div>

			 <div class="col-md-12 mt-3">
				 <div class="row">
					 
					 <label for="is_other" class="col-md-12">リターン品名</label>
					 <div class="col-md-4">
						<span id="" class="text-danger is_other_message"></span> 
						<input type="text" class="form-control required is_other" name="is_other[]" required maxlength="21">
					</div>
				 </div>
			 </div>

			 <div class="col-md-12 mt-3">
				 <div class="row">
					 <label for="other_description" class="col-md-12">内容</label>
					 <div class="col-md-10">
						<span id="" class="text-danger other_description_message"></span> 
						 <textarea name="other_description[] required" rows="8" cols="80" class="form-control other_description" required maxlength="201"></textarea>
					 </div>
				 </div>
			 </div>

			  <div class="col-md-12 mt-3">
				 <div class="row">
					 <label for="other_file" class="col-md-12">写真</label>
					 <div class="col-md-4"><input type="file" class="required" name="other_file[]"></div>
				 </div>
			 </div> 
		 </div>
	 </div>

	 <div class="hide details">
		 <div class="mt20 details_div">
			 <hr>
			 <div class="">
				 <div class="form-group">
					 <label for="" style="width:100%;">見出しタイトル <span class="close float-right" data-target="details_div">X</span></label>
					 <input type="text" class="form-control" placeholder="" name="details_title[]">
				 </div>
				 <div class="form-group">
					 <label for="">内容</label>
					 <textarea name="details_description[]" class="form-control required col-12" rows="8" cols="80"></textarea>
				 </div>

				 <div class="form-group file_upload_section">
						<!-- <button class="btn btn-sm btn-default upfile_step3">ファイルを選択</button> -->
						<!-- <span id="" class="ml-3 select_file_step3">選択されていません</span> -->
						<!-- <label for="draft_file[]" class="col-md-12">見出しタイトル</label> -->
					<input type="file" id="" class="required col-10 file_step3" placeholder="" name="draft_file[]">
				</div>
			 </div>
		 </div>
	 </div>





@include('user.layouts.add-project')
@stop

@section('custom_js')

	<!-- <script src="//cdn.ckeditor.com/4.8.0/basic/ckeditor.js"></script> -->
	<script src="{{Request::root()}}/ckeditor/ckeditor.js"></script>

	{{-- <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.7/jquery.validate.min.js"></script> --}}
	<script type="text/javascript" src="{{Request::root()}}/js/jquery.validate.min.js"></script>
	{{-- <script type="text/javascript" src="js/bootstrap-filestyle.min.js"> </script> --}}

	<script src="https://cdn.jsdelivr.net/npm/jquery-dropdown-datepicker@1.3.0/dist/jquery-dropdown-datepicker.min.js"></script>



	 <script>
		$(document).ready(function(){
			var maxDate = null, minDate = null;
			$("#from").dropdownDatepicker({
				displayFormat: 'ymd',
				wrapperClass: 'row',
				dropdownClass: 'col form-control',
				allowPast: false,
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
				daySuffixValues: ['日', '日', '日', '日'],
				onChange: function(day, month, year){
					if(day!=null && month!=null && year!=null){
						$("#to").dropdownDatepicker('destroy');
						minDate = year+'-'+month+'-'+day;
						minDate = new Date(minDate);
						minDate.setDate(minDate.getDate());
						minDate = minDate.getFullYear()+'-'+(minDate.getMonth()+1)+'-'+minDate.getDate();
						maxDate = new Date(minDate);
						maxDate.setDate(maxDate.getDate()+58);
						maxDate = maxDate.getFullYear()+'-'+(maxDate.getMonth()+1)+'-'+maxDate.getDate();
						console.log(minDate, maxDate);
						createToDate();
					}
				}
			});
			var createToDate = function(){
				$("#to").dropdownDatepicker({
					displayFormat: 'ymd',
					wrapperClass: 'row',
					dropdownClass: 'col form-control',
					allowPast: false,
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
		var form = $("#example-form");
		form.validate({
			errorPlacement: function errorPlacement(error, element) { element.before(error); },
			messages: {
				budget: '半角で入力してください'
			}
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
		  		var totalDay  = $('#totalDay').val().length;
		  		if(totalDay == 0){
		  			$('#totalDay').val(0);
		  		}
		  		if(currentIndex == 3){
		        	$('.actions > ul > li:nth-child(1)').attr('style', 'display:none;');
		        	$('.actions > ul > li:nth-child(2)').attr('style', 'display:none;');
		        	$('.actions > ul > li:nth-child(3)').attr('style', 'display:none;');
		        }
		        $('.steps .current').prevAll().removeClass('done').addClass('disabled');
		  	},
		    onStepChanging: function (event, currentIndex, newIndex){
				var check = 0;
				if (currentIndex == 0 && newIndex == 1) {
					// alert('yes');
					if ($('.length35_1').val().length > 35) {
						$('#length35_1').html('35文字以内でご記入ください  ');
						check = 1;
					}else {
						$('#length35_1').html('');
						// check = 0;
					}
					// // alert($('.length2k_1').val());
					// if ($('.length2k_1').val().length > 2000) {
					// 	// alert('error');
					// 	$('#length2k_1').html('2000文字以内でご記入ください  ');
					// 	check = 1;
					// }else {
					// 	$('#length2k_1').html('');
					// 	// check = 0;
					// }

					console.log($('.length2k_2').val());
					if ($('.length2k_2').val().length > 2000) {
						$('#length2k_2').html('2000文字以内でご記入ください  ');
						check = 1;
					}else {
						$('#length2k_2').html('');
						// check = 0;
					}

					if ($('.length30_2').val().length > 30) {
						$('#length30_2').html('30文字以内でご記入ください  ');
						check = 1;
					}else {
						$('#length30_2').html('');
						// check = 0;
					}

					if ($('.length30_3').val().length > 30) {
						$('#length30_3').html('30文字以内でご記入ください  ');
						check = 1;
					}else {
						$('#length30_3').html('');
						// check = 0;
					}

					if ($('.length200_1').val().length > 200) {
						$('#length200_1').html('200文字以内でご記入ください  ');
						check = 1;
					}else {
						$('#length200_1').html('');
						// check = 0;
					}
					
					if (check == 1) {
						console.log('validation error');
						return false;
					}
				}

				// alert(currentIndex);
				if (currentIndex == 1 && newIndex == 2) {
					var amount = [];
					var point = [];
					$('.body .amount').each(function(i, item){
						// console.log(i, $(this).val());
						amount.push($(this).val())
					});
					$('.body .is_crofun_point').each(function(i, item){
						// console.log(i, $(this).val());
						point.push($(this).val());
						// point.push($(this).val())
					});
					if(amount.length != point.length){
						return false;
					}
					for(var i=0;i<amount.length;i++){
						if(amount[i] == '' || point[i] == '' || (parseFloat(amount[i]) < parseFloat(point[i]))){
							return false;
						}
					}
					// console.log(amount);
					// console.log(point);
					// return false;
					// var point = $('.body input[name="is_crofun_point[]"]').val();
					// console.log(amount, point);
					// return false;
				}

		        if(newIndex > currentIndex){
					form.validate().settings.ignore = ":disabled,:hidden";
        			return form.valid();        			
				}
				return true;
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
			var d1 = $('#from').val()+'T00:00:01';
			console.log(d1);
			var date1 = new Date(d1);
			// console.log(date1.getTime());
			var d2 = $('#to').val()+'T23:59:59';
			console.log(d2);
			var date2 = new Date(d2);
			// console.log('date2 '+d1);
			// console.log('date1 '+date2.getTime());

			// console.log($('.toshowM').val());

			timeDiff = date2.getTime() - date1.getTime();
			console.log('timeDiff');
			console.log(timeDiff);

			if(timeDiff < 0){
				alert('invalid date');
				return false;
			}
			var timeDiff = Math.abs(timeDiff);
			var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
			console.log('diffDays');
			console.log(diffDays);
			if(diffDays > 59){
				// alert('maximum day is 59.You have selected '+diffDays+' days');
				alert('最大59日まで選択可能です');
				this.selectedIndex = $(this).data('lastSelectedIndex');
				e.preventDefault();
				return false;
			}

			if(isNaN(diffDays)){
				diffDays = '';
			}

			$('#totalDay').val(diffDays);
		}

		calculateDay();
		$('.calculateDay').on('change', calculateDay);

		var basic = [
		  ['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink', '-', 'About']
		];

		$('.add_details').on('click', function(){
			var content = $('.details').html();
			$('.details_container').before(content);
		});

		$('.add_reward').on('click', function(){
			var content = $('.reward').html();
			$('.reward_button_area').before(content);
		});

		// console.log('new project');
		//$(function(){
			// CKEDITOR.replace( 'editor', {
			//     toolbar: basic
			// });
			// CKEDITOR.replaceClass = 'ckeditor';
			//CKEDITOR.replace( 'description' ,{
				// filebrowserBrowseUrl : 'ckeditor1/plugins/imageuploader/imgbrowser.php',
				// filebrowserUploadUrl : '/browser1/upload/type/all',
			    //filebrowserImageBrowseUrl : '{{Request::root()}}/ckeditor/plugins/imageuploader/imgbrowser.php',
				// filebrowserImageUploadUrl : '/browser3/upload/type/image',
			    // filebrowserWindowWidth  : 800,
			    // filebrowserWindowHeight : 500,
				//extraPlugins: 'imageuploader'
				// extraPlugins: 'dropler'
			//});
		//});
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
