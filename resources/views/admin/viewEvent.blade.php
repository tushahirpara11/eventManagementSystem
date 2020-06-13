@extends('layout.app')
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
<h3>Event Master</h3> <br />
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
			<th class="col-xs-1">Branch Name</th>
			<th class="col-xs-1">Venue Name</th>
			<th>Event Name</th>
			<th>Event Discription</th>
			<th>Start Date</th>
			<th>End Date</th>
			<th class="col-xs-1">Status</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
		@for($i = 0; $i < count($data); $i++) <tr class="odd gradeX">
			<td>{{$i+1}}</td>
			<td>{{$data[$i]->b_name}}</td>
			<td>{{$data[$i]->v_name}}</td>
			<td>{{$data[$i]->e_name}}</td>
			<td>{{$data[$i]->e_discription}}</td>
			<td>{{$data[$i]->e_start_date}}</td>
			<td>{{$data[$i]->e_end_date}}</td>
			<td>@if($data[$i]->e_status == 1)
				<form action="{{ route('admin.updatestatus', [$data[$i]->e_id,0]) }}" method="post" style="display: inline;">
					{{csrf_field()}}
					<button type="submit" class="btn btn-danger btn-sm btn-icon icon-left"><i class="entypo-cancel"></i>Deactive</button>
				</form>
				@elseif($data[$i]->e_status == 0)
				<form action="{{ route('admin.updatestatus', [$data[$i]->e_id,1]) }}" method="post" style="display: inline;">
					{{csrf_field()}}
					<button type="submit" class="btn btn-success btn-sm btn-icon icon-left"><i class="entypo-check"></i>Active</button>
				</form>
				@endif
			</td>
			<td class="col-md-2">
				<form style="display: inline;">
					<a href="javascript:;" id="{{$data[$i]->e_id}}_{{$data[$i]->b_id}}_{{$data[$i]->b_name}}_{{$data[$i]->v_id}}_{{$data[$i]->v_name}}_{{$data[$i]->e_name}}_{{$data[$i]->e_discription}}_{{$data[$i]->e_start_date}}_{{$data[$i]->e_end_date}}" onclick="openmodal(this.id);" class="btn btn-default btn-sm btn-icon icon-left"><i class="entypo-pencil"></i>Edit</a>
				</form> &nbsp; &nbsp;
				<form action="{{ route('admin.deleteevent', [$data[$i]->e_id]) }}" method="post" style="display: inline;">
					{{csrf_field()}}
					{{ method_field('DELETE') }}
					<button type="submit" onclick="return checkResponce();" class="btn btn-danger btn-sm btn-icon icon-left"><i class="entypo-trash"></i>Delete</button>
				</form>
			</td>
			</tr>
			@endfor
	</tbody>
	<tfoot>
		<tr>
			<th></th>
			<th>Branch Name</th>
			<th>Venue Name</th>
			<th>Event Name</th>
			<th>Event Discription</th>
			<th>Start Date</th>
			<th>End Date</th>
			<th>Status</th>
			<th></th>
		</tr>
	</tfoot>
</table> <br />
<button type="click" onclick="jQuery('#modal-7').modal('show', {
      backdrop: 'static'
    });" class="btn btn-info btn-lg btn-icon icon-left"><i class="entypo-plus"></i>Add Event</button>
<script>
	function checkResponce() {
		if (!confirm('Are you sure want to Delete this Record?')) {
			return false;
		}
		this.form.submit();
	}
</script>
<div class="modal fade" id="modal-7">
	<form method="post" id="addevent" action="{{route('admin.addevent')}}">
		{{csrf_field()}}
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header"> <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Add Event</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="field-1" class="control-label">Branch</label>
								<select name="b_id" id="b_id" style="position: static;" class="form-control" data-placeholder="Select one stream...">
									@for($i = 0; $i < count($branch); $i++) <option value="{{$branch[$i]->b_id}}">{{$branch[$i]->b_name}}</option>
										@endfor
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="field-2" class="control-label">Venue</label>
								<select name="v_id" id="v_id" style="position: static;" class="form-control" data-placeholder="Select one stream...">
									@for($i = 0; $i < count($venue); $i++) <option value="{{$venue[$i]->v_id}}">{{$venue[$i]->v_name}}</option>
										@endfor
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="field-2" class="control-label">Event Name</label>
								<input type="hidden" class="form-control" value="1" name="e_status" id="e_status" />
								<input type="text" class="form-control" name="e_name" id="e_name" placeholder="Event Name" />
							</div>
						</div>
						<div class="col-md-8">
							<div class="form-group"> <label for="field-2" class="control-label">Event Discription</label>
								<textarea class="form-control" name="e_discription" id="e_discription" value="" placeholder="Event Discription" cols="30" rows="10"></textarea>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group"> <label for="field-2" class="control-label">Event Start Date</label>
								<input type="date" name="e_start_date" id="e_start_date" class="form-control datepicker" data-start-date="-2d" data-end-date="+1w">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group"> <label for="field-2" class="control-label">Event End Date</label>
								<input type="date" name="e_end_date" id="e_end_date" class="form-control datepicker" data-start-date="-2d" data-end-date="+1w">
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer"> <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-info">Save</button> </div>
			</div>
		</div>
	</form>
</div>
<div class="modal fade" id="modal-6">
	<form method="post" id="updateevent" action="{{route('admin.updateevent')}}">
		{{csrf_field()}}
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header"> <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Update Event</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="field-1" class="control-label">Branch</label>
								<input type="hidden" name="e_id" id="e_id_field" />
								<select name="b_id" id="b_id" style="position: static;" class="form-control" data-placeholder="Select one stream...">
									<option id="b_id_field" value=""></option>
									@for($i = 0; $i < count($branch); $i++) <option value="{{$branch[$i]->b_id}}">{{$branch[$i]->b_name}}</option>
										@endfor
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="field-2" class="control-label">Venue</label>
								<select name="v_id" id="v_id" style="position: static;" class="form-control" data-placeholder="Select one stream...">
									<option id="v_id_field" value=""></option>
									@for($i = 0; $i < count($venue); $i++) <option value="{{$venue[$i]->v_id}}">{{$venue[$i]->v_name}}</option>
										@endfor
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="field-2" class="control-label">Event Name</label>
								<input type="hidden" class="form-control" value="1" name="e_status" id="e_status" />
								<input type="text" class="form-control" name="e_name" id="e_name_field" placeholder="Event Name" />
							</div>
						</div>
						<div class="col-md-8">
							<div class="form-group"> <label for="field-2" class="control-label">Event Discription</label>
								<textarea class="form-control" name="e_discription" id="e_discription_field" value="" placeholder="Event Discription" cols="30" rows="10"></textarea>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group"> <label for="field-2" class="control-label">Event Start Date</label>
								<input type="date" name="e_start_date" id="e_start_date_field" class="form-control datepicker" data-start-date="-2d" data-end-date="+1w">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group"> <label for="field-2" class="control-label">Event End Date</label>
								<input type="date" name="e_end_date" id="e_end_date_field" class="form-control datepicker" data-start-date="-2d" data-end-date="+1w">
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer"> <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-info">Save</button> </div>
			</div>
		</div>
	</form>
</div>
<script>
	function openmodal(id) {
		let record_id = id.split("_");
		let e_id = record_id[0];
		let b_id = record_id[1];
		let b_id_val = record_id[2];
		let v_id = record_id[3];
		let v_id_val = record_id[4];
		let e_name = record_id[5];
		let e_discription = record_id[6];
		let e_start_date = record_id[7];
		let e_end_date = record_id[8];

		$('#e_id_field').val(e_id);
		$('#b_id_field').val(b_id).text(b_id_val);
		$('#v_id_field').val(v_id).text(v_id_val);
		$('#e_name_field').val(e_name);
		$('#e_discription_field').val(e_discription);
		$('#e_start_date_field').val(e_start_date);
		$('#e_end_date_field').val(e_end_date);

		jQuery('#modal-6').modal('show', {
			backdrop: 'static'
		});
	}
</script>

<script>
	$(document).ready(function() {
		$("#addevent").submit(function(e) {
			let b_id = $("#b_id").val();
			let v_id = $("#v_id").val();
			let e_name = $("#e_name").val();
			let e_discription = $("#e_discription").val();
			let e_start_date = $("#e_start_date").val();
			let e_end_date = $("#e_end_date").val();

			let fullDate = new Date();
			let twoDigitMonth = fullDate.getMonth() + "";
			if (twoDigitMonth.length == 1) {
				twoDigitMonth = "0" + (parseInt(twoDigitMonth) + 1);
			}
			let twoDigitDate = fullDate.getDate() + "";
			if (twoDigitDate.length == 1) {
				twoDigitDate = "0" + twoDigitDate;
			}
			let currentDate = fullDate.getFullYear() + "-" + twoDigitMonth + "-" + twoDigitDate;

			$(".error").remove();
			// return false;
			if (b_id == "" || b_id == null) {
				e.preventDefault();
				$("#b_id").after(
					'<span class="error">This field is required</span>'
				);
			}
			if (v_id == "" || v_id == null) {
				e.preventDefault();
				$("#v_id").after(
					'<span class="error">This field is required</span>'
				);
			}
			if (!/^[a-zA-Z]/.test(e_name) || e_name == "") {
				e.preventDefault();
				$("#e_name").after(
					'<span class="error">This field is required</span>'
				);
			} else if (e_name.length >= 50) {
				e.preventDefault();
				$("#e_name").after(
					'<span class="error">Event Name should maximum 50 characters only.</span>'
				);
			}
			if (!/^[a-zA-Z]/.test(e_discription) || e_discription == "") {
				e.preventDefault();
				$("#e_discription").after(
					'<span class="error">This field is required</span>'
				);
			} else if (e_discription.length > 255) {
				e.preventDefault();
				$("#e_discription").after(
					'<span class="error">Event Name should maximum 50 characters only.</span>'
				);
			}
			if (e_start_date == "") {
				e.preventDefault();
				$("#e_start_date").after(
					'<span class="error">This field is required</span>'
				);
			} else if (!(e_start_date > currentDate)) {
				e.preventDefault();
				$("#e_start_date").after(
					'<span class="error">Starting date should be Greater than today\'s date</span>'
				);
			}
			if (e_end_date == "") {
				e.preventDefault();
				$("#e_end_date").after(
					'<span class="error">This field is required</span>'
				);
			} else if (!(e_end_date > currentDate && e_end_date >= s_date)) {
				e.preventDefault();
				$("#e_end_date").after(
					'<span class="error">Starting date should be Greater than today\'s date</span>'
				);
			}
		});
		$("#updateevent").submit(function(e) {
			let b_id_field = $('#b_id_field').val();
			let v_id_field = $('#v_id_field').val();
			let e_name_field = $('#e_name_field').val();
			let e_discription_field = $('#e_discription_field').val();
			let e_start_date_field = $('#e_start_date_field').val();
			let e_end_date_field = $('#e_end_date_field').val();

			$(".error").remove();
			// return false;
			if (b_id_field == "") {
				e.preventDefault();
				$("#b_id_field").after(
					'<span class="error">This field is required</span>'
				);
			}
			if (v_id_field == "") {
				e.preventDefault();
				$("#v_id_field").after(
					'<span class="error">This field is required</span>'
				);
			}
			if (!/^[a-zA-Z]/.test(e_name_field) || e_name_field == "") {
				e.preventDefault();
				$("#e_name_field").after(
					'<span class="error">This field is required</span>'
				);
			} else if (e_name_field.length >= 40) {
				e.preventDefault();
				$("#e_name_field").after(
					'<span class="error">Event Name should maximum 40 characters only.</span>'
				);
			}

			if (!/^[a-zA-Z]/.test(e_discription_field) || e_discription_field == "") {
				e.preventDefault();
				$("#e_discription_field").after(
					'<span class="error">This field is required</span>'
				);
			} else if (e_discription_field.length >= 450) {
				e.preventDefault();
				$("#e_discription_field").after(
					'<span class="error">Event Discription should maximum 450 characters only.</span>'
				);
			}
			if (e_start_date_field == "") {
				e.preventDefault();
				$("#e_start_date_field").after(
					'<span class="error">This field is required</span>'
				);
			}
			if (e_end_date_field == "") {
				e.preventDefault();
				$("#e_end_date_field").after(
					'<span class="error">This field is required</span>'
				);
			}
		});
	});
</script>
@endsection