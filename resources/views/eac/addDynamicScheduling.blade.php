@extends('eaclayout.app')
@section('content')
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
<form method="post" id="addSchedule" action="{{route('eac.schedule')}}">
	{{csrf_field()}}
	<input type="hidden" value="{{Session::get('e_id')}}" name="e_id">
	<input type="hidden" value="" id="sched_details" name="sched_details">
	<table class="table table-bordered datatable" id="table-4">
		<thead>
			<tr>
				<th class="col-xs-1">#No.</th>
				<th class="col-xs-1">Event Name</th>
				<th class="col-xs-1">Duration</th>
				<th class="col-xs-1">Overlape</th>
			</tr>
		</thead>
		<tbody id="t_body">			
		</tbody>
		<tfoot>
			<tr>
				<th></th>
				<th class="col-xs-1">Event Name</th>
				<th class="col-xs-1">Duration</th>
				<th class="col-xs-1">Overlape</th>
			</tr>
		</tfoot>
	</table>
	<br />
	<div style="margin-left: 35%">
		<button type="submit" class="btn btn-primary">Add Scheduling</button>
	</div>
</form>
<br />
<form method="post" action="#">
	@if(count($data) != 0)
	<table class="table table-bordered datatable" id="table-4">
		<thead>
			<tr>
				<th class="col-xs-1">#No.</th>
				<th class="col-xs-1">Sub Event Name</th>
				<th class="col-xs-1">Action</th>
			</tr>
		</thead>
		<tbody>
			<input type="hidden" id="eventCount" value="{{count($data)}}" />
			@for($i = 0; $i < count($data); $i++) <tr class="odd gradeX">
				<td>{{$i+1}}</td>
				<td>{{$data[$i]->s_e_name}}</td>
				<td>
					<input type="checkbox" value="{{$data[$i]->s_e_id}}" onclick="getchecked(this);" />
				</td>
				</tr>
				@endfor
		</tbody>
		<tfoot>
			<tr>
				<th></th>
				<th class="col-xs-1">Sub Event Name</th>
				<th class="col-xs-1">Action</th>
			</tr>
		</tfoot>
	</table>
	@endif
</form>
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