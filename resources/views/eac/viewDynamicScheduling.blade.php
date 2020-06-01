@extends('eaclayout.app')
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
<h3>Event Scheduling</h3> <br />
<script type="text/javascript">
	jQuery(document).ready(function($) {
		var $table4 = jQuery("#table-4");
		var table4 = $table4.DataTable({
			"aLengthMenu": [
				[10, 25, 50, -1],
				[10, 25, 50, "All"]
			],
			dom: 'Bfrtip',
			buttons: [
				'excelHtml5',
				'csvHtml5',
				'pdfHtml5'
			]
		});
		// Initalize Select Dropdown after DataTables is created
		$table4.closest('.dataTables_wrapper').find('select').select2({
			minimumResultsForSearch: -1
		});
		// Setup - add a text input to each footer cell
		$('#table-4 tfoot th').each(function() {
			var title = $('#table-4 thead th').eq($(this).index()).text();
			$(this).html('<input type="text" class="form-control" placeholder="Search ' + title + '" />');
		});
		// Apply the search
		table4.columns().every(function() {
			var that = this;
			$('input', this.footer()).on('keyup change', function() {
				if (that.search() !== this.value) {
					that
						.search(this.value)
						.draw();
				}
			});
		});
	});
</script>
<table class="table table-bordered datatable" id="table-4">
	<thead>
		<tr>
			<th class="col-xs-1">#No.</th>
			<th class="col-xs-1">Event</th>
			<th class="col-xs-1">Schedule</th>
			<th class="col-xs-1">Time</th>
			<th class="col-xs-1">Action</th>
		</tr>
	</thead>
	<tbody>
		@if(count($data) != 0)
		@for($i = 0; $i < count($data); $i++) <tr class="odd gradeX">
			<td>{{$i + 1}}</td>
			<td>{{$data[$i]->e_name}}</td>
			<td>{{$data[$i]->sched_details}}</td>
			<td>{{$data[$i]->time}}</td>
			<td class="col-md-2">
				<form action="{{route('eac.editSchedule')}}" method="post" style="display: inline;">
				{{csrf_field()}}		
				<input type="hidden" value="{{$data[$i]->sched_id}}" name="sched_id">
					<button class="btn btn-default btn-sm btn-icon icon-left"><i class="entypo-pencil"></i>Edit</button>
				</form> &nbsp; &nbsp;
				<form action="{{route('eac.deleteSchedule',[$data[$i]->sched_id])}}" method="post" style="display: inline;">
					{{csrf_field()}}
					{{ method_field('DELETE') }}
					<button type="submit" onclick="return checkResponce();" class="btn btn-danger btn-sm btn-icon icon-left"><i class="entypo-trash"></i>Delete</button>
				</form>
			</td>
			</tr>
			@endfor
			@endif
	</tbody>
	<tfoot>
		<tr>
			<th></th>
			<th class="col-xs-1">Event</th>
			<th class="col-xs-1">Schedule</th>
			<th class="col-xs-1">Time</th>
			<th></th>
		</tr>
	</tfoot>
</table><br />
<a href="{{route('eac.getschedule')}}" class="btn btn-info btn-lg btn-icon icon-left"><i class="entypo-plus"></i>Add Scheduling</a>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script>
	const yourArray = [];

	function getchecked(id) {
		if ($(id)[0].checked === true) {
			yourArray.push(parseInt($(id).val()));
			$.ajax({
				url: "<?php echo route('eac.countOverlap'); ?>",
				type: "POST",
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				data: {
					s_e_id: yourArray
				},
				success: function(data) {
					$('#t_body').html('');
					$('#sched_details').val(yourArray);
					if (data.data.length == 1) {
						for (let i = 0; i < data.data.length; i++) {
							$('#t_body').html(`<tr class="odd gradeX">
						<td>${i+1}</td>
						<td>${data.data[i].s_e_name}</td>
						<td>${data.data[i].s_e_duration.slice(0, -3)}</td>
						<td>${data.data[i].overlap}</td>
						</tr>`);
						}
					} else {
						let a = "";
						$('#sched_details').val(yourArray);
						for (let i = 0; i < data.data.length; i++) {
							a += `<tr class="odd gradeX">
						<td>${i+1}</td>
						<td>${data.data[i][0].s_e_name}</td>
						<td>${data.data[i][0].s_e_duration.slice(0, -3)}</td>
						<td>${data.data[i][0].overlap}</td>
						</tr>`;
						}
						$('#t_body').html(a);
					}
				}
			});
		} else {
			yourArray.splice(yourArray.indexOf(parseInt($(id).val())), 1);
			$.ajax({
				url: "<?php echo route('eac.countOverlap'); ?>",
				type: "POST",
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				data: {
					s_e_id: yourArray
				},
				success: function(data) {
					$('#t_body').html('');
					if (data.data.length == 1) {
						$('#sched_details').val(yourArray);
						for (let i = 0; i < data.data.length; i++) {
							$('#t_body').html(`<tr class="odd gradeX">
						<td>${i+1}</td>
						<td>${data.data[i].s_e_name}</td>
						<td>${data.data[i].s_e_duration.slice(0, -3)}</td>
						<td>${data.data[i].overlap}</td>
						</tr>`);
						}
					} else {
						let a = "";
						$('#sched_details').val(yourArray);
						for (let i = 0; i < data.data.length; i++) {
							a += `<tr class="odd gradeX">
						<td>${i+1}</td>
						<td>${data.data[i][0].s_e_name}</td>
						<td>${data.data[i][0].s_e_duration.slice(0, -3)}</td>
						<td>${data.data[i][0].overlap}</td>
						</tr>`;
						}
						$('#t_body').html(a);
					}
				}
			});
		}
	}
	$("#addSchedule").submit(function(e) {
		const event = $("#eventCount").val();
		if (event != yourArray.length) {
			window.confirm("Please Schedule all the Events");;
			e.preventDefault();
		}
	});
</script>
@endsection