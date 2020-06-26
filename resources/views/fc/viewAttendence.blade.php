@extends('fclayout.app')
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
<h3>View Attendence</h3> <br />
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
			<th class="col-xs-1">Sub Event</th>
			<th class="col-xs-1">Att. Taker</th>
			<th class="col-xs-1">Present</th>
			<th class="col-xs-1">Date</th>
			<th class="col-xs-1">Actions</th>
		</tr>
	</thead>
	<tbody>
		@if(count($data) != 0)
		@for($i = 0; $i < count($data); $i++) <tr class="odd gradeX">
			<td>{{$i+1}}</td>
			<td>{{$data[$i]->s_e_name}}</td>
			<td>{{$data[$i]->f_name}} {{$data[$i]->l_name}}</td>
			<td>{{$data[$i]->present}}</td>
			<td>{{$data[$i]->date}}</td>
			<td class="col-md-2">
				<form style="display: inline;">
					<a href="{{route('fc.ediAttendence',[$data[$i]->s_e_id,$data[$i]->date])}}" class="btn btn-default btn-sm btn-icon icon-left"><i class="entypo-pencil"></i>Edit</a>
				</form> &nbsp; &nbsp;
				<form action="{{route('fc.deleteattendence',[$data[$i]->a_id])}}" method="post" style="display: inline;">
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
			<th>Sub Event</th>
			<th>Att. Taker</th>
			<th>Present</th>
			<th>Date</th>
			<th></th>
		</tr>
	</tfoot>
</table><br />
@if($attendence[0]->count == 0 && $attendence != 'undefined')
<button type="click" onclick="jQuery('#modal-6').modal('show', {
      backdrop: 'static'
    });" class="btn btn-info btn-lg btn-icon icon-left"><i class="entypo-plus"></i>Add Attendence</button>
@endif
<script>
	function checkResponce() {
		if (!confirm('Are you sure want to Delete this Record?')) {
			return false;
		}
		this.form.submit();
	}
</script>
<div class="modal fade" style="width: 50%!important;margin: auto;margin-top: 2%" id="modal-6">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Add Attendence</h4>
		</div>
		<form method="post" action="{{route('fc.addAttendence')}}">
			{{csrf_field()}}
			<div class="modal-body">
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th>No.</th>
								<th>Enrollment No.</th>
								<th>Name</th>
								<th>Present</th>
							</tr>
						</thead>
						<tbody>
						@if(count($student))
							<input type="hidden" value="{{$student[0]->s_e_id}}" name="s_e_id" />
							<input type="hidden" value="{{Session::get('fc')}}" name="fc" />
							@for($i = 0; $i < count($student); $i++) <tr>
								<td>{{$i+1}}</td>
								<td>{{$student[$i]->enrollmentno}}</td>
								<td>{{$student[$i]->f_name}} {{$student[$i]->l_name}}</td>
								<td>
									<input type="checkbox" value="{{$student[$i]->u_id}}" onclick="getchecked(this);" />
								</td>
								</tr>
								@endfor
								<input type="hidden" value="" name="present" />
								@endif
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default_field" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-info">Save</button>
			</div>
		</form>
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
@endsection