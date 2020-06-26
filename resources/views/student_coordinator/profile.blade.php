@extends('student_coordinator/index')
@section('title','Student Profile')
@section('head','Student Profile')
@section('content')
<style>
	.error {
		color: red;
	}
</style>
<script>
	$(document).ready(function() {
		$("#updateform").hide();

		$("#editbtn").click(function() {
			$("#updateform").show();
			$("#editform").hide();
		})

		$("#cancelbtn").click(function() {
			$("#updateform").hide();
			$("#editform").show();
		})
	})
</script>
@if (session('success'))
<div class="alert alert-success alert-block">
	<button type="button" class="close" data-dismiss="alert">×</button>
	<strong>{{ Session::get('success') }}</strong>
</div>
@endif
<title>EditProfile</title>

<body>

	<div id="editform">
		<div class="col-lg-12">
			<div class="col-lg-6" style="margin: auto;">
				<div class="card">
					<br>
					<div class="card-block">
						<table class="table table-hover table-striped">
							<tr>
								<th>First Name</th>
								<td>{{$profile[0]->f_name}}</td>
							</tr>
							<tr>
								<th>Last Name</th>
								<td>{{$profile[0]->l_name}}</td>
							</tr>
							<tr>
								<th>Phone Number</th>
								<td>{{$profile[0]->phone}}</td>
							</tr>
							<tr>
								<th>Email Id</th>
								<td>{{$profile[0]->email}}</td>
							</tr>
							<tr>
								<th>Enrollment Number</th>
								<td>{{$profile[0]->enrollmentno}}</td>
							</tr>
							<tr>
								<th>Date of Birth</th>
								<td>{{$profile[0]->dob}}</td>
							</tr>
							<tr>
								<th>Gender</th>
								<td>
									@if($profile[0]->gender == "M")
									Male
									@else
									Female
									@endif
								</td>
							</tr>
							<tr>
								<th>Branch</th>
								<td>
									@foreach($branch as $data)
									@if($profile[0]->b_id == $data->b_id)
									{{$data->b_name}}
									@endif
									@endforeach
								</td>
							</tr>
							<tr>
								<th>Stream</th>
								<td>
									@foreach($stream as $data)
									@if($profile[0]->s_id == $data->s_id)
									{{$data->s_name}}
									@endif
									@endforeach
								</td>
							</tr>
							<tr>
								<th>Division</th>
								<td>
									@foreach($division as $data)
									@if($profile[0]->d_id == $data->d_id)									
									{{$data->d_name}}
									@endif
									@endforeach
								</td>
							</tr>
						</table>
						<div class="col-md-12 clearfix">
							<input type="button" value="Edit" id="editbtn" class="btn btn-success m-2" style="width: 550px;"><br>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div id="updateform">
		<div class="col-lg-12">
			<div class="col-lg-6" style="margin: auto;">
				<div class="card">
					<br>
					<div class="card-block">
						<form method="POST" id="update" action="/student_coordinator/update">
							{{ csrf_field() }}
							<input type="hidden" name="id" value="{{$profile[0]->u_id}}">
							<table class='table  table-hover table-striped'>
								<tr>
									<th>First Name</th>
									<td><input type="text" id="f_name" name="f_name" value="{{$profile[0]->f_name}}" class="form-control"></td>
								</tr>
								<tr>
									<th>Last Name</th>
									<td><input type="text" id="l_name" name="l_name" value="{{$profile[0]->l_name}}" class="form-control"></td>
								</tr>
								<tr>
									<th>Phone Number</th>
									<td><input type="text" id="phone" name="phone" value="{{$profile[0]->phone}}" class="form-control"></td>
								</tr>
								<tr>
									<th>Email Id</th>
									<td><input type="text" id="email" name="email" value="{{$profile[0]->email}}" class="form-control"></td>
								</tr>
								<tr>
									<th>Enrollment Number</th>
									<td><input type="text" id="enrollment" name="enrollment" value="{{$profile[0]->enrollmentno}}" class="form-control"></td>
								</tr>
								<tr>
									<th>Date of Birth</th>
									<td><input type="text" id="dob" name="dob" value="{{$profile[0]->dob}}" class="form-control"></td>
								</tr>
								<tr>
									<th>Select Gender</th>
									<td><select name="gender" id="gender" class="form-control">
											<option selected>
												@if($profile[0]->gender == "M")
												Male
												@else
												Female
												@endif
											</option>
											<option value="Male">Male</option>
											<option value="Female">Female</option>
										</select>
									</td>
								</tr>
								<tr>
									<th>Select Branch</th>
									<td><select name="branch" id="branch" class="form-control">
											<option value="Select Branch">Select Branch</option>
											@foreach ($branch as $data)
											<option value="{{$data->b_id}}">{{$data->b_name}}</option>
											@endforeach
										</select>
									</td>
								</tr>
								<tr>
									<th>Select Stream</th>
									<td>
										<select name="stream" id="stream" class="form-control">

										</select>
									</td>
								</tr>
								<tr>
									<th>Select Division</th>
									<td>
										<select name="division" id="division" class="form-control">

										</select>
									</td>
								</tr>
							</table>
							<div class="col-md-12 clearfix">
								<input type="submit" value="Update" id="updatebtn" class="btn btn-success m-2" style="width: 250px;" />
								<input type="button" value="Cancel" id="cancelbtn" class="btn btn-danger m-2" style="width: 250px;" />
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<script>
	$(document).ready(function() {
		$("#update").submit(function(e) {
			let f_name = $("#f_name").val();
			let l_name = $("#l_name").val();
			let email = $("#email").val();
			let phone = $("#phone").val();
			let enrollment = $("#enrollment").val();
			let gender = $("#gender").val();
			let dob = $("#dob").val();
			let branch = $("#branch").val();
			let stream = $("#stream").val();
			let division = $("#division").val();

			$(".error").remove();
			// return false;
			if (f_name == "") {
				e.preventDefault();
				$("#f_name").after(
					'<span class="error">This field is required</span>'
				);
			} else if (!/^[a-zA-Z]/.test(f_name) || f_name == "") {
				e.preventDefault();
				$("#f_name").after(
					'<span class="error">Please Enter Alphabets Only</span>'
				);
			} else if (f_name.length > 15) {
				e.preventDefault();
				$("#f_name").after(
					'<span class="error">first name should maximum 15 characters only.</span>'
				);
			}
			if (l_name == "") {
				e.preventDefault();
				$("#l_name").after(
					'<span class="error">This field is required</span>'
				);
			} else if (!/^[a-zA-Z]/.test(l_name) || l_name == "") {
				e.preventDefault();
				$("#l_name").after(
					'<span class="error">Please Enter Alphabets Only</span>'
				);
			} else if (l_name.length > 15) {
				e.preventDefault();
				$("#l_name").after(
					'<span class="error">last name should maximum 15 characters only.</span>'
				);
			}
			if (email == "") {
				e.preventDefault();
				$("#email").after(
					'<span class="error">This field is required</span>'
				);
			}
			if (phone == "") {
				e.preventDefault();
				$("#phone").after(
					'<span class="error">This field is required</span>'
				);
			} else if (phone.length < 10) {
				e.preventDefault();
				$("#phone").after(
					'<span class="error">Mobile Number Should be 10 numbes only</span>'
				);
			} else if (phone.length > 10) {
				e.preventDefault();
				$("#phone").after(
					'<span class="error">Mobile Number Should be 10 numbes only</span>'
				);
			}
			if (enrollment == "") {
				e.preventDefault();
				$("#enrollment").after(
					'<span class="error">This field is required</span>'
				);
			} else if (enrollment.length < 12) {
				e.preventDefault();
				$("#enrollment").after(
					'<span class="error">Enrollment Number Should be 12 digits</span>'
				);
			} else if (enrollment.length > 12) {
				e.preventDefault();
				$("#enrollment").after(
					'<span class="error">Enrollment Number Should be 12 digits</span>'
				);
			}
			if (gender == "Select Gender") {
				e.preventDefault();
				$("#gender").after(
					'<span class="error">Please Select Gender</span>'
				);
			}
			if (dob == "") {
				e.preventDefault();
				$("#dob").after(
					'<span class="error">Please Select Date of Birth</span>'
				);
			}
			if (branch == "Select Branch") {
				e.preventDefault();
				$("#branch").after(
					'<span class="error">Please Select branch</span>'
				);
			}
			if (stream === null) {
				e.preventDefault();
				$("#stream").after(
					'<span class="error">Please Select Stream</span>'
				);
			}
			if (division === null) {
				e.preventDefault();
				$("#division").after(
					'<span class="error">Please Select Division</span>'
				);
			}

		});
	});
</script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script>
	$("select[name='branch']").change(function() {
		$("#stream").html('');
		var branch = $(this).val();
		var token = $("input[name='_token']").val();
		$.ajax({
			url: "<?php echo route('ajaxbranch') ?>",
			method: 'POST',
			data: {
				b_id: branch,
				_token: token
			},
			success: function(option) {
				for (i = 0; i < option.option.length; i++) {
					$("#stream").append(`<option value="${option.option[i].s_id}">${option.option[i].s_name} </option>`);
				}
			}
		});
	});
	$("select[name='stream']").click(function() {
		$("#division").html('');
		var stream = $(this).val();
		var token = $("input[name='_token']").val();
		$.ajax({
			url: "<?php echo route('ajaxstream') ?>",
			method: 'POST',
			data: {
				s_id: stream,
				_token: token
			},
			success: function(option) {
				for (i = 0; i < option.option.length; i++) {
					$("#division").append(`<option value="${option.option[i].d_id}">${option.option[i].d_name} </option>`);
				}
			}
		});
	});
</script>
@stop