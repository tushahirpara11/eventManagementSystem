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
<h3>Practice Schedule</h3> <br />
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
      <th>#No.</th>
      <th>Sub Event Name</th>
      <th>Participants</th>
      <th>User</th>
      <th>Description</th>
      <th>Date</th>
      <th>Time</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    @for($i = 0; $i < count($data); $i++) <tr class="odd gradeX">
      <td>{{$i+1}}</td>
      <td>{{$data[$i]->s_e_name}}</td>
      <td>{{$data[$i]->participants}}</td>
      <td>{{$data[$i]->f_name}} {{$data[$i]->l_name}}</td>
      <td>{{$data[$i]->description}}</td>
      <td>{{$data[$i]->date}}</td>
      <td>{{$data[$i]->time}}</td>
      <td>
        <a id="{{$data[$i]->p_id}}_{{$data[$i]->u_id}}_{{$data[$i]->description}}_{{$data[$i]->date}}_{{$data[$i]->time}}" onclick="openmodal(this.id)" class="btn btn-default btn-sm btn-icon icon-left"><i class="entypo-pencil"></i>Edit</a>
      </td>
      </tr>
      @endfor
  </tbody>
  <tfoot>
    <tr>
      <th></th>
      <th>Sub Event Name</th>
      <th>Participants</th>
      <th>User</th>
      <th>Description</th>
      <th>Date</th>
      <th>Time</th>
      <th></th>
    </tr>
  </tfoot>
</table> <br />
<button type="click" onclick="jQuery('#modal-6').modal('show', {
      backdrop: 'static'
    });" class="btn btn-info btn-lg btn-icon icon-left"><i class="entypo-plus"></i>Add Practice Schedule</button>

<script>
  function checkResponce() {
    if (!confirm('Are you sure want to Delete this Record?')) {
      return false;
    }
    this.form.submit();
  }
</script>

<div class="modal fade" id="modal-6">
  <form method="post" id="addPractice" action="{{route('fc.addPracticeSchedule')}}">
    {{csrf_field()}}
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header"> <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Add Practice Schedule</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="field-2" class="control-label">Discription</label>
                <textarea class="form-control" name="description" id="description" placeholder="Enter Discription"></textarea>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="field-2" class="control-label">Date</label>
                <input type="date" class="form-control" name="date" id="date" />
                <input type="hidden" class="form-control" name="u_id" value="{{Session::get('fc')}}" />
                <input type="hidden" class="form-control" name="s_e_id" value="{{Session::get('f_s_e_id')}}" />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="field-2" class="control-label">Time</label>
                <input type="time" class="form-control" name="time" id="time" />
                <input type="hidden" class="form-control" name="u_id" value="{{Session::get('fc')}}" />
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer"> <button type="button" class="btn btn-default_field" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-info">Save</button> </div>
      </div>
    </div>
  </form>
</div>

<div class="modal fade" id="modal-7">
  <form method="post" id="addPractice" action="{{route('fc.updatePracticeSchedule')}}">
    {{csrf_field()}}
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header"> <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Update Practice Schedule</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="field-2" class="control-label">Discription</label>
                <textarea class="form-control" name="description" id="description_field" placeholder="Enter Discription"></textarea>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="field-2" class="control-label">Date</label>
                <input type="date" class="form-control" name="date" id="date_field" />
                <input type="hidden" class="form-control" id="p_id" name="p_id" value="" />
                <input type="hidden" class="form-control" id="u_id_field" name="u_id" value="{{Session::get('fc')}}" />
                <input type="hidden" class="form-control" name="s_e_id" value="{{Session::get('f_s_e_id')}}" />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="field-2" class="control-label">Time</label>
                <input type="time" class="form-control" name="time" id="time_field" />
                <input type="hidden" class="form-control" name="u_id" value="{{Session::get('fc')}}" />
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer"> <button type="button" class="btn btn-default_field" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-info">Save</button> </div>
      </div>
    </div>
  </form>
</div>
<script>
  function openmodal(id) {
    let record_id = id.split("_");
    let p_id = record_id[0];
    let u_id = record_id[1];
    let description = record_id[2];
    let date = record_id[3];
    let time = record_id[4];    

    $("#p_id").val(p_id);
    $("#u_id_field").val(u_id);
    $("#description_field").val(description);
    $("#date_field").val(date);
    $("#time_field").val(time);

    jQuery('#modal-7').modal('show', {
      backdrop: 'static'
    });
  }
</script>
<script>
  $(document).ready(function() {
    $("#addPractice").submit(function(e) {
      let description = $("#description").val();
      let date = $("#date").val();
      let time = $("#time").val();

      $(".error").remove();
      if (date == "") {
        e.preventDefault();
        $("#date").after(
          '<span class="error">This field is required</span>'
        );
      }
      if (time == "") {
        e.preventDefault();
        $("#time").after(
          '<span class="error">This field is required</span>'
        );
      }
      if (description == "") {
        e.preventDefault();
        $("#description").after(
          '<span class="error">This field is required</span>'
        );
      } else if (!/^[a-zA-Z0-9]/.test(description)) {
        e.preventDefault();
        $("#description").after(
          '<span class="error">Name allow [A-Za-z0-9] characters only.</span>'
        );
      } else if (description.length > 255) {
        e.preventDefault();
        $("#description").after(
          '<span class="error">Description maximum 255 characters only.</span>'
        );
      }
    });
  });
</script>
@endsection