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
<h3>Stream Master</h3> <br />
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
    });" class="btn btn-info btn-lg btn-icon icon-left"><i class="entypo-plus"></i>Add Stream</button>
    </th>
    <tr>
      <th>#No.</th>
      <th>Stream ID</th>
      <th>Branch ID</th>
      <th>Stream Name</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    @for($i = 0; $i < count($data); $i++) <tr class="odd gradeX">
      <td>{{$i+1}}</td>
      <td id="s_id">{{$data[$i]->s_id}}</td>
      <td id="b_code">{{$data[$i]->b_id}}</td>
      <td id="stream_name">{{$data[$i]->s_name}}</td>
      <td class="col-md-3">
        @for($j = 0; $j < count($branch); $j++)
          @if($data[$i]->b_id == $branch[$j]->b_id)
          <!-- {{ $temp = $branch[$j]->b_name }} -->
          @endif
        @endfor
        <form style="display: inline;">
          <a href="javascript:;" id="{{$data[$i]->s_id}}_{{$data[$i]->b_id}}_{{$temp}}_{{$data[$i]->s_name}}" onclick="openmodal(this.id);" class="btn btn-default btn-sm btn-icon icon-left"><i class="entypo-pencil"></i>Edit</a>
        </form> &nbsp; &nbsp;
        <form action="{{ route('admin.deletestream', [$data[$i]->s_id]) }}" method="post" style="display: inline;">
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
      <th>Stream ID</th>
      <th>Branch ID</th>
      <th>Stream Name</th>
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
  <form method="post" id="addstream" action="{{route('admin.addstream')}}">
    {{csrf_field()}}
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header"> <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Add Stream</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="field-2" class="control-label">Stream Name</label>
                <select name="b_id" id="b_id" class="form-control" data-placeholder="Select one stream...">
                  @for($i = 0; $i < count($branch); $i++)
                    <option value="{{$branch[$i]->b_id}}">{{$branch[$i]->b_name}}</option>                  
                  @endfor
                </select>
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="field-2" class="control-label">Branch Name</label>
                <input type="text" class="form-control" name="s_name" id="s_name" placeholder="Branch Name">
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
  <form method="post" id="updateStream" action="{{route('admin.updatestream')}}">
    {{csrf_field()}}
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header"> <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Update Branch</h4>
        </div>
        <div class="modal-body">
        <input type="hidden" class="form-control" name="s_id" value="" id="s_id_field" placeholder="Stream ID">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="field-2" class="control-label">Branch Name</label>
                <select name="b_id" style="position: static;" class="form-control" data-placeholder="Select one stream...">
                  <option id="b_id_field" value=""></option>
                  @for($i = 0; $i < count($branch); $i++)                  
                    <option value="{{$branch[$i]->b_id}}">{{$branch[$i]->b_name}}</option>
                  @endfor
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group"> <label for="field-2" class="control-label">Stream Name</label>
                <input type="text" class="form-control" name="s_name" id="stream_name_field" placeholder="Branch Name">
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
    let s_id = record_id[0];
    let b_id = record_id[1];
    let b_value = record_id[2];
    let stream_name = record_id[3];

    $('#s_id_field').val(s_id);
    $('#b_id_field').val(b_id).text(b_value);
    $('#stream_name_field').val(stream_name);    

    jQuery('#modal-6').modal('show', {
      backdrop: 'static'
    });
  }
</script>

<script>
  $(document).ready(function() {
    $("#addstream").submit(function(e) {      
      let stream_name = $("#s_name").val();
      let b_id = $("#b_id").val();

      $(".error").remove();
      // return false;      
			if(b_id == "" || b_id == null) {
				e.preventDefault();
        $("#b_id").after(
          '<span class="error">This field is required</span>'
        );
			}
      if (!/^[a-zA-Z]/.test(stream_name) || stream_name == "") {
        e.preventDefault();
        $("#s_name").after(
          '<span class="error">This field is required</span>'
        );
      } else if (stream_name.length >= 20) {
        e.preventDefault();
        $("#s_name").after(
          '<span class="error">Stream Name should maximum 20 characters only.</span>'
        );
      }
    });
    $("#updateStream").submit(function(e) {      
      let stream_name = $("#stream_name_field").val();

      $(".error").remove();
      // return false;     
      if (!/^[a-zA-Z]/.test(stream_name) || stream_name == "") {
        e.preventDefault();
        $("#stream_name_field").after(
          '<span class="error">This field is required</span>'
        );
      } else if (stream_name.length >= 20) {
        e.preventDefault();
        $("#stream_name_field").after(
          '<span class="error">Branch Name should maximum 20 characters only.</span>'
        );
      }
    });
  });
</script>
@endsection