@extends('layout.app')
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
<h3>Branch Master</h3> <br />
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
    <th class="col-md-3" style="background-color: white;">
      <button type="click" onclick="jQuery('#modal-7').modal('show', {
      backdrop: 'static'
    });" class="btn btn-info btn-lg btn-icon icon-left"><i class="entypo-plus"></i>Add Branch</button>
    </th>
    <tr>
      <th>#No.</th>
      <th>Branch Code</th>
      <th>Branch Name</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    @for($i = 0; $i < count($data); $i++) <tr class="odd gradeX">
      <td>{{$i+1}}</td>
      <td id="b_code">{{$data[$i]->b_code}}</td>
      <td id="b_name">{{$data[$i]->b_name}}</td>
      <td class="col-md-3">
        <form style="display: inline;">
          <a href="javascript:;" id="{{$data[$i]->b_code}}_{{$data[$i]->b_name}}" onclick="openmodal(this.id);" class="btn btn-default btn-sm btn-icon icon-left"><i class="entypo-pencil"></i>Edit</a>
        </form> &nbsp; &nbsp;
        <form action="{{ route('admin.deletebranch', [$data[$i]->b_id]) }}" method="post" style="display: inline;">
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
      <th></th>
      <th>Branch Code</th>
      <th>Branch Name</th>
    </tr>
  </tfoot>
</table> <br />
<script>
  function checkResponce() {
    if (!confirm('Are you sure want to Delete this Record?')) {
      return false;
    }
    this.form.submit();
  }
</script>
<div class="modal fade" id="modal-7">
  <form method="post" action="{{route('admin.addbranch')}}">
    {{csrf_field()}}
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header"> <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Add Branch</h4>
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
  <form method="post" action="{{route('admin.updatebranch')}}">
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
@endsection