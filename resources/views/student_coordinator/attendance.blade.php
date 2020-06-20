@extends('student_coordinator/index')
@section('title','Take Attendance')
@section('head','Take Attendance')
@section('content')
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
					<form method="post" id="change_password" action="/student_coordinator/add_attendance">
						{{ csrf_field() }}
						<table class="table">
							<thead>
								<tr>
									<th>No.</th>
									<th>Enrollment No.</th>
									<th>Name</th>
									<th>Is Present</th>
								</tr>
							</thead>
							<tbody>
								<input type="hidden" value="{{Session::get('s_e_id')}}" name="s_e_id" />
								<input type="hidden" value="{{Session::get('coordinator')}}" name="u_id" />
								@for($i = 0; $i < count($students); $i++) <tr>
									<td>{{$i+1}}</td>
									<td>{{$students[$i]->enrollmentno}}</td>
									<td>{{$students[$i]->f_name}} {{$students[$i]->l_name}}</td>
									<td>
										<input type="checkbox" value="{{$students[$i]->u_id}}" onclick="getchecked(this);" />
									</td>
									</tr>
									@endfor
									<input type="hidden" value="" name="present" />
							</tbody>
						</table>
						<div class="col-md-12 clearfix">							
								<button type="submit" class="btn btn-success m-2" style="width: 200px;">Add</button>							
								<button type="reset" class="btn btn-danger m-2" style="width: 200px;">Clear</button>							
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script>
	const yourArray = [];

	function getchecked(id) {
		if ($(id)[0].checked === true) {
			yourArray.push(parseInt($(id).val()));
			$('input[name=present]').val(yourArray);
		} else {
			yourArray.splice(yourArray.indexOf(parseInt($(id).val())), 1);
			$('input[name=present]').val(yourArray);
		}
	}
</script>
@stop