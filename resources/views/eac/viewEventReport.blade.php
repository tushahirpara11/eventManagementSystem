@extends('eaclayout.app')
@section('content')
<h3>Event Wise Participate Report</h3> <br />
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
			<th class="col-xs-1">Sub Event Name</th>
			<th class="col-xs-1">Male</th>
			<th class="col-xs-1">Female</th>
			<th class="col-xs-1">Total</th>
			<th class="col-xs-1">Date</th>
		</tr>
	</thead>
	<tbody>
		@for($i=0; $i < count($data); $i++) <tr class="odd gradeX">
			<td class="col-xs-1">{{$i+1}}</td>
			<td class="col-xs-1">{{$data[$i]->s_e_name}}</td>
			<td class="col-xs-1">{{$data[$i]->geneder_Male}}</td>
			<td class="col-xs-1">{{$data[$i]->geneder_Female}}</td>
			<td class="col-xs-1">{{$data[$i]->geneder_Male + $data[$i]->geneder_Female}}</td>
			<td class="col-xs-1">{{$data[$i]->created_at}}</td>
			@endfor
	</tbody>
	<tfoot>
		<tr>
			<th></th>
			<th>Enrollment No.</th>
			<th>Name</th>
			<th></th>
			<th></th>
			<th></th>
		</tr>
	</tfoot>
</table>
@endsection