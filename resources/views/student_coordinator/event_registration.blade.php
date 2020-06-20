@extends('student_coordinator/index')
@section('title','Event Registration')
@section('head','Event Registration')
@section('content')
<div class="col-lg-12">
	<div class="col-lg-6" style="margin: auto;">
		<div class="card">
			<br>
			<div class="card-block">
				<div class="container">
					<form method="post" action="/student_coordinator/event_registration">
						{{ csrf_field() }}
						<label for="usr">Select Event :</label>
						<select name="s_e_id" class="form-control">
							@foreach($sub_event as $data)
							<option value="{{ $data->s_e_id }}">{{ $data->s_e_name }}</option>
							@endforeach
						</select><br>
						<input type="hidden" name="user_id" value="{{ session('id') }}" />
						<label for="group">Event Faculty:</label>
						<select disabled style="pointer-events:disabled;" name="u_name" id="u_name" class="form-control">
						</select>
						<input type="hidden" id="g_id" name="g_id" value="" />
						<br />
						<label for="usr">Want To be An volunteer :</label> &nbsp;
						<input type="checkbox" id="volunteer" name="volunteer" value="" />
						<br />
						<input type="hidden" id="role_id" name="role_id" value="4" />
						<div class="col-md-12 clearfix">
							<button type="submit" name="submit" class="btn btn-success m-2" style="width: 200px;">Submit</button>							
							<button type="reset" class="btn btn-danger m-2" style="width: 200px;">Clear</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$("select[name='s_e_id']").click(function() {
		$("#u_name").html('');
		var s_e_id = $(this).val();
		var token = $("input[name='_token']").val();
		$.ajax({
			url: "<?php echo route('ajaxGroup') ?>",
			method: 'POST',
			data: {
				s_e_id: s_e_id,
				_token: token
			},
			success: function(option) {
				for (var i = 0; i < option.option.length; i++) {
					for (var j = 0; j < option.user.length; j++) {
						$("#u_name").append(`<option value="${option.option[i].g_id}">${option.user[j].f_name} ${option.user[j].l_name} </option>`);
						$("#g_id").val(option.option[i].g_id);
					}
				}
			}
		});
	});
</script>
<script>
	$('#volunteer').click(function() {
		if ($(this).prop("checked") == true) {
			$('#role_id').val('3');
		} else {
			$('#role_id').val('4');
		}
	})
</script>
@stop