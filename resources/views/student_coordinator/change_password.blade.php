@extends('student_coordinator/index')
@section('title','Change Password')
@section('head','Change Password')
@section('content')
<style>
	.error {
		color: red;
	}
</style>

@if (session('success'))
<div class="alert alert-success alert-block">
	<button type="button" class="close" data-dismiss="alert">×</button>
	<strong>{{ Session::get('success') }}</strong>
</div>
@endif
@if (session('error'))
<div class="alert alert-danger alert-block">
	<button type="button" class="close" data-dismiss="alert">×</button>
	<strong>{{ Session::get('error') }}</strong>
</div>
@endif
<div class="col-lg-12">
	<div class="col-lg-6" style="margin: auto;">
		<div class="card">
			<br>
			<div class="card-block">
				<div class="container">
					<form method="post" id="change_password" action="/student_coordinator/change_password">
						{{ csrf_field() }}
						<input type="password" name="oldpassword" id="oldpassword" class="form-control" placeholder="Enter Old Password :" /><br>

						<input type="password" name="newpassword" id="newpassword" class="form-control" placeholder="Enter New Password :" /><br>

						<input type="password" name="c_newpassword" id="c_newpassword" class="form-control" placeholder="Confirm New Password :" /><br>
						<div class="col-md-12">
							<input type="submit" value="Edit" id="editbtn" class="btn btn-success m-2" style="width: 500px;"><br>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function() {
		$("#change_password").submit(function(e) {
			let oldpass = $("#oldpassword").val();
			let newpass = $("#newpassword").val();
			let c_newpass = $("#c_newpassword").val();

			$(".error").remove();
			// return false;
			if (oldpass == "") {
				e.preventDefault();
				$("#oldpassword").after(
					'<span class="error">This field is required</span>'
				);
			}
			if (newpass == "") {
				e.preventDefault();
				$("#newpassword").after(
					'<span class="error">This field is required</span>'
				);
			} else if (newpass.length < 8) {
				e.preventDefault();
				$("#newpassword").after(
					'<span class="error">password must be 8 character long</span>'
				);
			}
			if (c_newpass == "") {
				e.preventDefault();
				$("#c_newpassword").after(
					'<span class="error">This field is required</span>'
				);
			}
			if (newpass != c_newpass) {
				e.preventDefault();
				$("#newpassword").after(
					'<span class="error">Password and Confirm Password not match</span>'
				);
			}
		});
	});
</script>
@stop