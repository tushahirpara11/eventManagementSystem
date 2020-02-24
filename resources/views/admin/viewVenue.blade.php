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
<h3>Venue Master</h3> <br />
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
    });" class="btn btn-info btn-lg btn-icon icon-left"><i class="entypo-plus"></i>Add Venue</button>
    </th>
    <tr>
      <th>#No.</th>
      <th>Venue ID</th>
      <th>Venue Name</th>
      <th>Address</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    @for($i = 0; $i < count($data); $i++) <tr class="odd gradeX">
      <td>{{$i+1}}</td>
      <td id="venue_id">{{$data[$i]->v_id}}</td>
      <td id="venue_name">{{$data[$i]->v_name}}</td>
      <td id="address">{{$data[$i]->v_address}}</td>
      <td class="col-md-3">
        <form style="display: inline;">
          <a href="javascript:;" id="{{$data[$i]->v_id}}_{{$data[$i]->v_name}}_{{$data[$i]->v_address}}" onclick="openmodal(this.id);" class="btn btn-default btn-sm btn-icon icon-left"><i class="entypo-pencil"></i>Edit</a>
        </form> &nbsp; &nbsp;
        <form action="{{ route('admin.deletevenue', [$data[$i]->v_id]) }}" method="post" style="display: inline;">
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
      <th>Venue ID</th>
      <th>Venue Name</th>
      <th>Venue Address</th>
      <th></th>
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
  <form method="post" id="addvenue" action="{{route('admin.addvenue')}}">
    {{csrf_field()}}
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header"> <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Add Venue</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="field-1" class="control-label">Venue Name</label>
                <input type="text" class="form-control" name="v_name" id="v_name" placeholder="Venue Name" />
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-md-12">
              <div class="form-group">
                <label for="field-2" class="control-label">Venue Address</label>
                <textarea class="form-control" name="v_address" id="v_address" placeholder="Venue Address" cols="30" rows="10"></textarea>
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
  <form method="post" id="updatevenue" action="{{route('admin.updatevenue')}}">
    {{csrf_field()}}
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header"> <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Update Venue</h4>
        </div>
        <div class="modal-body">
          <input type="hidden" class="form-control" name="v_id" value="" id="v_id_field" placeholder="Stream ID">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="field-1" class="control-label">Venue Name</label>
                <input type="text" class="form-control" name="v_name" id="v_name_field" placeholder="Venue Name" />
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-md-12">
              <div class="form-group">
                <label for="field-2" class="control-label">Venue Address</label>                
                <textarea class="form-control" name="v_address" id="v_address_field" value="" placeholder="Venue Name" cols="30" rows="10"></textarea>
              </div>
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
    let v_id = record_id[0];
    let v_name = record_id[1];    
    let venue_addresss = record_id[2];

    $('#v_id_field').val(v_id);
    $('#v_name_field').val(v_name);
    $('#v_address_field').val(venue_addresss);
    jQuery('#modal-6').modal('show', {
      backdrop: 'static'
    });
  }
</script>

<script>
  $(document).ready(function() {
    $("#addvenue").submit(function(e) {
      let venue_name = $("#v_name").val();
      let venue_address = $("#v_address").val();

      $(".error").remove();
      // return false;      
      if (!/^[a-zA-Z]/.test(venue_name) || venue_name == "") {
        e.preventDefault();
        $("#v_name").after(
          '<span class="error">This field is required</span>'
        );
      } else if (venue_name.length >= 30) {
        e.preventDefault();
        $("#v_name").after(
          '<span class="error">Venue Name should maximum 30 characters only.</span>'
        );
      }
      if (!/^[a-zA-Z0-9]/.test(venue_address) || venue_name == "") {
        e.preventDefault();
        $("#v_address").after(
          '<span class="error">This field is required</span>'
        );
      } else if (venue_name.length >= 500) {
        e.preventDefault();
        $("#v_address").after(
          '<span class="error">Venue Address should maximum 500 characters only.</span>'
        );
      }
    });
    $("#updatevenue").submit(function(e) {
      let venue_name = $("#venue_name_field").val();
      let venue_address = $("#venue_address_field").val();

      $(".error").remove();
      // return false;     
      if (!/^[a-zA-Z]/.test(venue_name) || venue_name == "") {
        e.preventDefault();
        $("#v_name_field").after(
          '<span class="error">This field is required</span>'
        );
      } else if (stream_name.length >= 30) {
        e.preventDefault();
        $("#v_name_field").after(
          '<span class="error">Branch Name should maximum 30 characters only.</span>'
        );
      }
      if (!/^[a-zA-Z0-9]/.test(venue_address) || venue_address == "") {
        e.preventDefault();
        $("#v_address_field").after(
          '<span class="error">This field is required</span>'
        );
      } else if (venue_name.length >= 500) {
        e.preventDefault();
        $("#v_address_field").after(
          '<span class="error">Venue Address should maximum 500 characters only.</span>'
        );
      }
    });
  });
</script>
@endsection