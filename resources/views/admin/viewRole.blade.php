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
<h3>Role Master</h3> <br />
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
      <th class="col-xs-1">Role Name</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    @for($i = 0; $i < count($data); $i++) <tr class="odd gradeX">
      <td>{{$i+1}}</td>
      <td>{{$data[$i]->r_name}}</td>
      <td class="col-md-2">
        <form style="display: inline;">
          <a href="javascript:;" id="{{$data[$i]->r_id}}_{{$data[$i]->r_name}}" onclick="openmodal(this.id);" class="btn btn-default btn-sm btn-icon icon-left"><i class="entypo-pencil"></i>Edit</a>
        </form> &nbsp; &nbsp;
        <form action="{{ route('admin.deleterole', [$data[$i]->r_id]) }}" method="post" style="display: inline;">
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
      <th>Event Name</th>
      <th></th>
    </tr>
  </tfoot>
</table> <br />
<button type="click" onclick="jQuery('#modal-7').modal('show', {
      backdrop: 'static'
    });" class="btn btn-info btn-lg btn-icon icon-left"><i class="entypo-plus"></i>Add Role</button>
<script>
  function checkResponce() {
    if (!confirm('Are you sure want to Delete this Record?')) {
      return false;
    }
    this.form.submit();
  }
</script>
<div class="modal fade" id="modal-7">
  <form method="post" id="addrole" action="{{route('admin.addrole')}}">
    {{csrf_field()}}
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header"> <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Add Role</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="field-2" class="control-label">Role Name</label>
                <input type="text" class="form-control" name="r_name" id="r_name" placeholder="Role Name" />
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
  <form method="post" id="updaterole" action="{{route('admin.updaterole')}}">
    {{csrf_field()}}
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header"> <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Update Role</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="field-2" class="control-label">Role Name</label>
                <input type="hidden" class="form-control" name="r_id" id="r_id_field"/>
                <input type="text" class="form-control" name="r_name" id="r_name_field" placeholder="Role Name" />
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
    let r_id = record_id[0];
    let r_name = record_id[1];    

    $('#r_id_field').val(r_id);
    $('#r_name_field').val(r_name);
    
    jQuery('#modal-6').modal('show', {
      backdrop: 'static'
    });
  }
</script>

<script>
  $(document).ready(function() {
    $("#addrole").submit(function(e) {      
      let r_name = $("#r_name").val();
      
      $(".error").remove();
      // return false;
      if (!/^[a-zA-Z]/.test(r_name) || r_name == "") {
        e.preventDefault();
        $("#r_name").after(
          '<span class="error">This field is required</span>'
        );
      } else if (r_name.length > 16) {
        e.preventDefault();
        $("#r_name").after(
          '<span class="error">Role Name should maximum 15 characters only.</span>'
        );
      }
    });
    $("#updaterole").submit(function(e) {      
      let r_name_field = $("#r_name_field").val();
      
      $(".error").remove();
      // return false;
      if (!/^[a-zA-Z]/.test(r_name_field) || r_name_field == "") {
        e.preventDefault();
        $("#r_name_field").after(
          '<span class="error">This field is required</span>'
        );
      } else if (r_name_field.length > 16) {
        e.preventDefault();
        $("#r_name_field").after(
          '<span class="error">Role Name should maximum 15 characters only.</span>'
        );
      }     
    });
  });
</script>
@endsection