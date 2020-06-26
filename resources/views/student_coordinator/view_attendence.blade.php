@extends('student_coordinator/index')
@section('title','View Attendance')
@section('head','View Attendance')
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
<div class="container">
	<table class="table  table-hover table-striped">
		<thead class="table-info">
			<tr>
				<th>No.</th>
				<th>Sub Event</th>
				<th>Att. Taker</th>
				<th>Present</th>
				<th>Date</th>
			</tr>
		</thead>
		<tbody>
			@for($i = 0; $i < count($data); $i++) <tr>
				<td>{{$i+1}}</td>
				<td>{{$data[$i]->s_e_name}}</td>
				<td>{{$data[$i]->f_name}} {{$data[$i]->l_name}}</td>
				<td>{{$data[$i]->present}}</td>
				<td>{{$data[$i]->date}}</td>
				</tr>
				@endfor
		</tbody>
	</table>
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