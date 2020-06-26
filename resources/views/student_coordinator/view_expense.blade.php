@extends('student_coordinator/index')
@section('title','View Expense')
@section('head','View Expense')
@section('content')

<div class="container">
	<table class="table  table-hover table-striped">
		<thead class="table-info">
			<tr>
				<th>No.</th>
				<th>Event Name</th>
				<th>Sub Event Name</th>
				<th>User</th>
				<th>Expense Type</th>
				<th>Amount</th>
				<th>Description</th>
				<th>Status</th>
			</tr>
		</thead>
		<tbody>
			@for($i = 0; $i < count($data); $i++) <tr>
				<td>{{$i+1}}</td>
				<td>{{$data[$i]->e_name}}</td>
				<td>{{$data[$i]->s_e_name}}</td>
				<td>{{$data[$i]->f_name}} {{$data[$i]->l_name}}</td>
				<td>{{$data[$i]->name}}</td>
				<td>{{$data[$i]->amount}}</td>
				<td>{{$data[$i]->description}}</td>				
				@if($data[$i]->status == 0)
				<td><span class="badge badge-primary">Pending</span></td>
				@elseif($data[$i]->status == 1)
				<td><span class="badge badge-success">Approved</span></td>
				@elseif($data[$i]->status == 2)
				<td><span class="badge badge-danger">Reject</span></td>
				@endif
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