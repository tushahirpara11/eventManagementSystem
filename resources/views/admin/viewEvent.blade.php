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
      <th>#No.</th>
      <th>Event ID</th>
      <th>Branch ID</th>
      <th>Venue ID</th>
      <th>Event Name</th>
      <th>Event Discription</th>
      <th>Start Date</th>
      <th>End Date</th>
      <th>Status</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    @for($i = 0; $i < count($data); $i++) <tr class="odd gradeX">
      <td>{{$i+1}}</td>
      <td id="b_code">{{$data[$i]->e_id}}</td>
      <td id="b_name">{{$data[$i]->b_id}}</td>
      <td id="b_name">{{$data[$i]->v_id}}</td>
      <td id="b_name">{{$data[$i]->e_name}}</td>
      <td id="b_name">{{$data[$i]->e_discription}}</td>
      <td id="b_name">{{$data[$i]->e_start_date}}</td>
      <td id="b_name">{{$data[$i]->e_end_date}}</td>
      <td id="b_name">{{$data[$i]->e_status}}</td>
      <td class="col-md-3">
        <form style="display: inline;">
          <a href="javascript:;" id="{{$data[$i]->b_code}}_{{$data[$i]->b_name}}" onclick="openmodal(this.id);" class="btn btn-default btn-sm btn-icon icon-left"><i class="entypo-pencil"></i>Edit</a>
        </form> &nbsp; &nbsp;
        <form action="{{ route('admin.deleteevent', [$data[$i]->b_id]) }}" method="post" style="display: inline;">
          {{csrf_field()}}
          {{ method_field('DELETE') }}
          <button type="submit" onclick="return checkResponce();" class="btn btn-danger btn-sm btn-icon icon-left"><i class="entypo-cancel"></i>Delete</button>
        </form>
      </td>
      </tr>
      @endfor
  </tbody>
  <tfoot>
    <tr>
      <th></th>
      <th>Event ID</th>
      <th>Branch ID</th>
      <th>Venue ID</th>
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
              <div class="form-group"> <label for="field-1" class="control-label">Branch Code</label> <input type="text" class="form-control" name="b_code" id="branch_code" placeholder="Branch Code"> </div>
            </div>
            <div class="col-md-6">
              <div class="form-group"> <label for="field-2" class="control-label">Branch Name</label> <input type="text" class="form-control" name="b_name" id="branch_name" placeholder="Branch Name"> </div>
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
          <h4 class="modal-title">Update Branch</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group"> <label for="field-1" class="control-label">Branch Code</label> <input type="text" class="form-control" name="b_code" id="branch_code_field" placeholder="Branch Code"> </div>
            </div>
            <div class="col-md-6">
              <div class="form-group"> <label for="field-2" class="control-label">Branch Name</label> <input type="text" class="form-control" name="b_name" id="branch_name_field" placeholder="Branch Name"> </div>
            </div>
          </div>
        </div>
        <div class="modal-footer"> <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-info">Save changes</button> </div>
      </div>
    </div>
  </form>
</div>
<script>
  function openmodal(id) {
    let record_id = id.split("_");
    let code = record_id[0];
    let branch = record_id[1];

    $('#branch_code_field').val(code);
    $('#branch_name_field').val(branch);

    jQuery('#modal-6').modal('show', {
      backdrop: 'static'
    });
  }
</script>

<script>
  $(document).ready(function() {
    $("#addbranch").submit(function(e) {
      let branch_code = $("#branch_code").val();
      let branch_name = $("#branch_name").val();

      $(".error").remove();
      // return false;
      if (branch_code == "") {
        e.preventDefault();
        $("#branch_code").after(
          '<span class="error">This field is required</span>'
        );
      } else if (!/^[0-9]{3}$/.test(branch_code) || branch_code == "") {
        e.preventDefault();
        $("#branch_code").after(
          '<span class="error">This should have 3 degits Only.</span>'
        );
      } else if (branch_code.length > 3) {
        e.preventDefault();
        $("#branch_code").after(
          '<span class="error">Branch Code should maximum 3 characters only.</span>'
        );
      }
      if (!/^[a-zA-Z]/.test(branch_name) || branch_name == "") {
        e.preventDefault();
        $("#branch_name").after(
          '<span class="error">This field is required</span>'
        );
      } else if (branch_name.length >= 40) {
        e.preventDefault();
        $("#branch_name").after(
          '<span class="error">Branch Name should maximum 40 characters only.</span>'
        );
      }
    });
    $("#updateBranch").submit(function(e) {
      let branch_code = $("#branch_code_field").val();
      let branch_name = $("#branch_name_field").val();

      $(".error").remove();
      // return false;
      if (branch_code == "") {
        e.preventDefault();
        $("#branch_code_field").after(
          '<span class="error">This field is required</span>'
        );
      } else if (!/^[0-9]{3}$/.test(branch_code) || branch_code == "") {
        e.preventDefault();
        $("#branch_code_field").after(
          '<span class="error">This should have 3 degits Only.</span>'
        );
      } else if (branch_code.length > 3) {
        e.preventDefault();
        $("#branch_code_field").after(
          '<span class="error">Branch Code should maximum 3 characters only.</span>'
        );
      }
      if (!/^[a-zA-Z]/.test(branch_name) || branch_name == "") {
        e.preventDefault();
        $("#branch_name_field").after(
          '<span class="error">This field is required</span>'
        );
      } else if (branch_name.length >= 40) {
        e.preventDefault();
        $("#branch_name_field").after(
          '<span class="error">Branch Name should maximum 40 characters only.</span>'
        );
      }
    });
  });
</script>
@endsection