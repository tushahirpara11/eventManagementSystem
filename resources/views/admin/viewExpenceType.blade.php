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
<h3>Expence Type</h3> <br />
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
      <th>Expence Name</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    @for($i = 0; $i < count($data); $i++) <tr class="odd gradeX">
      <td>{{$i+1}}</td>
      <td>{{$data[$i]->name}}</td>
      <td class="col-md-2">
        <form style="display: inline;">
          <a href="javascript:;" id="{{$data[$i]->e_t_id}}_{{$data[$i]->name}}" onclick="openmodal(this.id);" class="btn btn-default btn-sm btn-icon icon-left"><i class="entypo-pencil"></i>Edit</a>
        </form> &nbsp; &nbsp;
        <form action="{{ route('admin.deleteExpence', [$data[$i]->e_t_id]) }}" method="post" style="display: inline;">
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
    });" class="btn btn-info btn-lg btn-icon icon-left"><i class="entypo-plus"></i>Add Expence Type</button>
<script>
  function checkResponce() {
    if (!confirm('Are you sure want to Delete this Record?')) {
      return false;
    }
    this.form.submit();
  }
</script>
<div class="modal fade" id="modal-7">
  <form method="post" id="addExpence" action="{{route('admin.addExpence')}}">
    {{csrf_field()}}
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header"> <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Add Expence Type</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="field-2" class="control-label">Expence Name</label>
                <input type="text" class="form-control" name="name" id="name" placeholder="Expence Name" />
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
  <form method="post" id="updateExpence" action="{{route('admin.updateExpence')}}">
    {{csrf_field()}}
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header"> <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Update Expence</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="field-2" class="control-label">Expence Name</label>
                <input type="hidden" class="form-control" name="e_t_id" id="e_t_id_field"/>
                <input type="text" class="form-control" name="name" id="name_field" placeholder="Expence Name" />
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
    let e_t_id = record_id[0];
    let name = record_id[1];    

    $('#e_t_id_field').val(e_t_id);
    $('#name_field').val(name);
    
    jQuery('#modal-6').modal('show', {
      backdrop: 'static'
    });
  }
</script>

<script>
  $(document).ready(function() {
    $("#addExpence").submit(function(e) {      
      let name = $("#name").val();
      
      $(".error").remove();
      // return false;
      if (!/^[a-zA-Z]/.test(name) || name == "") {
        e.preventDefault();
        $("#name").after(
          '<span class="error">This field is required</span>'
        );
      } else if (name.length > 16) {
        e.preventDefault();
        $("#name").after(
          '<span class="error">Expence Name should maximum 15 characters only.</span>'
        );
      }
    });
    $("#updateExpence").submit(function(e) {      
      let name_field = $("#name_field").val();
      
      $(".error").remove();
      // return false;
      if (!/^[a-zA-Z]/.test(name_field) || name_field == "") {
        e.preventDefault();
        $("#name_field").after(
          '<span class="error">This field is required</span>'
        );
      } else if (name_field.length > 16) {
        e.preventDefault();
        $("#name_field").after(
          '<span class="error">Expence Name should maximum 15 characters only.</span>'
        );
      }     
    });
  });
</script>
@endsection