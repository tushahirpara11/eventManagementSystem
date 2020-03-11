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
<h3>Group</h3> <br />
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
      <th class="col-xs-1">Event Name</th>
      <th class="col-xs-1">Sub Event Name</th>
      <th class="col-xs-1">User Name</th>
      <th class="col-xs-1">Role Name</th>
      <th class="col-xs-1">Actions</th>
    </tr>
  </thead>
  <tbody>
    @for($i = 0; $i < count($data); $i++) <tr class="odd gradeX">
      <td>{{$i+1}}</td>
      @for($j = 0; $j < count($event); $j++) @if($data[$i]->e_id == $event[$j]->e_id)
        <!-- {{$eventName = $event[$j]->e_name}} -->
      <td>{{$event[$j]->e_name}}</td>
      @endif
      @endfor
      @for($j = 0; $j < count($sub_event); $j++) @if($data[$i]->s_e_id == $sub_event[$j]->s_e_id)
        <!-- {{$subEventName = $sub_event[$j]->s_e_name}} -->
      <td>{{$sub_event[$j]->s_e_name}}</td>
      @endif      
      @endfor      
      @for($j = 0; $j < count($user); $j++) @if($data[$i]->u_id == $user[$j]->u_id)
        <!-- {{$userName = $user[$j]->f_name." ".$user[$j]->l_name}} -->
      <td>{{$user[$j]->f_name}} {{$user[$j]->l_name}}</td>
      @endif
      @endfor
      @for($j = 0; $j < count($role); $j++) @if($data[$i]->r_id == $role[$j]->r_id)
        <!-- {{$roleName = $role[$j]->r_name}} -->
      <td>{{$role[$j]->r_name}}</td>
      @endif
      @endfor
      <td class="col-md-2">
        <form style="display: inline;">
          <a href="javascript:;" id="{{$data[$i]->g_id}}_{{$data[$i]->e_id}}_{{$eventName}}_{{$data[$i]->s_e_id}}_{{$subEventName}}_{{$data[$i]->u_id}}_{{$userName}}_{{$data[$i]->r_id}}_{{$roleName}}" onclick="openmodal(this.id);" class="btn btn-default btn-sm btn-icon icon-left"><i class="entypo-pencil"></i>Edit</a>
        </form> &nbsp; &nbsp;
        <form action="{{ route('admin.deletegroup', [$data[$i]->g_id]) }}" method="post" style="display: inline;">
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
      <th>Sub Event Name</th>
      <th>User Name</th>
      <th>Role Name</th>
      <th></th>
    </tr>
  </tfoot>
</table> <br />
<button type="click" onclick="jQuery('#modal-7').modal('show', {
      backdrop: 'static'
    });" class="btn btn-info btn-lg btn-icon icon-left"><i class="entypo-plus"></i>Add Group</button>
<script>
  function checkResponce() {
    if (!confirm('Are you sure want to Delete this Record?')) {
      return false;
    }
    this.form.submit();
  }
</script>
<!-- Modal -->
<div class="modal fade" id="modal-7">
  <form method="post" id="addgroup" action="{{route('admin.addgroup')}}">
    {{csrf_field()}}
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header"> <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Add Group</h4>
        </div>
        <div class="modal-body" style="overflow-y:visible;">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="field-1" class="control-label">Event</label>
                <select name="e_id" id="e_id" class="form-control" data-placeholder="Select one stream...">
                  @for($i = 0; $i < count($event); $i++) <option value="{{$event[$i]->e_id}}">{{$event[$i]->e_name}}</option>
                    @endfor
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="field-1" class="control-label">Sub Event</label>
                <select name="s_e_id" id="s_e_id" style="position: static;" class="form-control" data-placeholder="Select one stream...">
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="field-1" class="control-label">User</label>
                <select name="u_id" id="u_id" style="position: static;" class="form-control" data-placeholder="Select one stream...">
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="field-1" class="control-label">Role</label>
                <select name="r_id" id="r_id" style="position: static;" class="form-control" data-placeholder="Select one stream...">
                  @for($i = 0; $i < count($role); $i++) <option value="{{$role[$i]->r_id}}">{{$role[$i]->r_name}}</option>
                    @endfor
                </select>
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
  <form method="post" id="updategroup" action="{{route('admin.updategroup')}}">
    {{csrf_field()}}
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header"> <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Update Group</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="field-1" class="control-label">Event</label>
                <input type="hidden" name="g_id" id="g_id"/>
                <select name="e_id" id="e_id_field" style="position: static;" class="form-control" data-placeholder="Select one stream...">
                  <option id="e_id_update" value=""></option>
                  @for($i = 0; $i < count($event); $i++) <option value="{{$event[$i]->e_id}}">{{$event[$i]->e_name}}</option>
                    @endfor
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="field-1" class="control-label">Sub Event</label>
                <select name="s_e_id" id="s_e_id_field" style="position: static;" class="form-control" data-placeholder="Select one stream...">
                  <option id="s_e_id_update" value=""></option>                 
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="field-1" class="control-label">User</label>
                <select name="u_id" id="u_id_field" style="position: static;" class="form-control" data-placeholder="Select one stream...">
                  <option id="u_id_update" value=""></option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="field-1" class="control-label">Role</label>
                <select name="r_id" id="r_id_field" style="position: static;" class="form-control" data-placeholder="Select one stream...">
                  <option id="r_id_update" value=""></option>    
                  @for($i = 0; $i < count($role); $i++) <option value="{{$role[$i]->r_id}}">{{$role[$i]->r_name}}</option>
                    @endfor              
                </select>
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
    let g_id = record_id[0];
    let e_id = record_id[1];
    let e_id_val = record_id[2];
    let s_e_id = record_id[3];
    let s_e_id_val = record_id[4];
    let u_id = record_id[5];
    let u_id_val = record_id[6];
    let r_id = record_id[7];
    let r_id_val = record_id[8];
    
    $('#g_id').val(g_id);    
    $('#e_id_update').val(e_id).text(e_id_val);
    $('#s_e_id_update').val(s_e_id).text(s_e_id_val);
    $('#u_id_update').val(u_id).text(u_id_val);
    $('#r_id_update').val(r_id).text(r_id_val);
    
    jQuery('#modal-6').modal('show', {
      backdrop: 'static'
    });
  }
</script>
<script>
  $(document).ready(function() {
    $("#addgroup").submit(function(e) {
      let e_id = $("#e_id").val();
      let s_e_id = $("#s_e_id").val();
      let u_id = $("#u_id").val();
      let r_id = $("#r_id").val();

      $(".error").remove();
      if (e_id == "") {
        e.preventDefault();
        $("#e_id").after(
          '<span class="error">This field is required</span>'
        );
      }
      if (s_e_id == null) {
        e.preventDefault();
        $("#s_e_id").after(
          '<span class="error">This field is required</span>'
        );
      }
      if (u_id == null) {
        e.preventDefault();
        $("#u_id").after(
          '<span class="error">This field is required</span>'
        );
      }
      if (r_id == null) {
        e.preventDefault();
        $("#e_id").after(
          '<span class="error">This field is required</span>'
        );
      }
    });
    $("#updategroup").submit(function(e) {
      let e_id = $("#e_id_field").val();
      let s_e_id = $("#s_e_id_field").val();
      let u_id = $("#u_id_field").val();
      let r_id = $("#r_id_field").val();

      $(".error").remove();
      if (e_id == "") {
        e.preventDefault();
        $("#e_id_field").after(
          '<span class="error">This field is required</span>'
        );
      }
      if (s_e_id == null) {
        e.preventDefault();
        $("#s_e_id_field").after(
          '<span class="error">This field is required</span>'
        );
      }
      if (u_id == null) {
        e.preventDefault();
        $("#u_id_field").after(
          '<span class="error">This field is required</span>'
        );
      }
      if (r_id == null) {
        e.preventDefault();
        $("#e_id_field").after(
          '<span class="error">This field is required</span>'
        );
      }
    });
  });
</script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script>
  $("select[name='e_id']").click(function() {
    $("#s_e_id").html('');
    $("#u_id").html('');
    var e_id = $(this).val();
    var token = $("input[name='_token']").val();
    $.ajax({
      url: "<?php echo route('ajaxSubEvent') ?>",
      method: 'POST',
      data: {
        e_id: e_id,
        _token: token
      },
      success: function(option) {
        for (i = 0; i < option.option.length; i++) {
          $("#u_id").append(`<option value="${option.option[i].u_id}">${option.option[i].f_name} ${option.option[i].l_name} </option>`);
        }
        for (i = 0; i < option.sub_event.length; i++) {
          $("#s_e_id").append(`<option value="${option.sub_event[i].s_e_id}">${option.sub_event[i].s_e_name} </option>`);
        }
      }
    });
  });
  $("select[id='e_id_field']").click(function () {
    $("#s_e_id_field").html('');
    $("#u_id_field").html('');
    var e_id = $(this).val();
    var token = $("input[name='_token']").val();
    $.ajax({
      url: "<?php echo route('ajaxSubEvent') ?>",
      method: 'POST',
      data: {
        e_id: e_id,
        _token: token
      },
      success: function(option) {
        for (i = 0; i < option.option.length; i++) {
          $("#u_id_field").append(`<option value="${option.option[i].u_id}">${option.option[i].f_name} ${option.option[i].l_name} </option>`);
        }
        for (i = 0; i < option.sub_event.length; i++) {
          $("#s_e_id_field").append(`<option value="${option.sub_event[i].s_e_id}">${option.sub_event[i].s_e_name} </option>`);
        }
      }    
    });
  });
</script>
@endsection