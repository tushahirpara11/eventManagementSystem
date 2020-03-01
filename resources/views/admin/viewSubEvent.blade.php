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
<h3>Sub Event Master</h3> <br />
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
      <th>Sub Event Discription</th>
      <th>Sub Event Duration</th>
      <th class="col-xs-1">Status</th>
      <th>Actions</th>
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
        <td>{{$data[$i]->s_e_name}}</td>
        <td>{{$data[$i]->s_e_discription}}</td>
        <td>{{$data[$i]->s_e_duration}}</td>
        <td>@if($data[$i]->status == 1)
          <form action="{{ route('admin.updatesubeventstatus', [$data[$i]->s_e_id,0]) }}" method="post" style="display: inline;">
            {{csrf_field()}}
            <button type="submit" class="btn btn-danger btn-sm btn-icon icon-left"><i class="entypo-cancel"></i>Deactive</button>
          </form>
          @elseif($data[$i]->status == 0)
          <form action="{{ route('admin.updatesubeventstatus', [$data[$i]->s_e_id,1]) }}" method="post" style="display: inline;">
            {{csrf_field()}}
            <button type="submit" class="btn btn-success btn-sm btn-icon icon-left"><i class="entypo-check"></i>Active</button>
          </form>
          @endif
        </td>
        <td class="col-md-2">
          <form style="display: inline;">
            <a href="javascript:;" id="{{$data[$i]->s_e_id}}_{{$data[$i]->e_id}}_{{$eventName}}_{{$data[$i]->s_e_name}}_{{$data[$i]->s_e_discription}}_{{$data[$i]->s_e_duration}}" onclick="openmodal(this.id);" class="btn btn-default btn-sm btn-icon icon-left"><i class="entypo-pencil"></i>Edit</a>
          </form> &nbsp; &nbsp;
          <form action="{{ route('admin.deletesubevent', [$data[$i]->s_e_id]) }}" method="post" style="display: inline;">
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
      <th>Sub Event Discription</th>
      <th>Sub Event Duration</th>
      <th>Status</th>
      <th></th>
    </tr>
  </tfoot>
</table> <br />
<button type="click" onclick="jQuery('#modal-7').modal('show', {
      backdrop: 'static'
    });" class="btn btn-info btn-lg btn-icon icon-left"><i class="entypo-plus"></i>Add Sub Event</button>
<script>
  function checkResponce() {
    if (!confirm('Are you sure want to Delete this Record?')) {
      return false;
    }
    this.form.submit();
  }
</script>
<div class="modal fade" id="modal-7">
  <form method="post" id="addsubevent" action="{{route('admin.addsubevent')}}">
    {{csrf_field()}}
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header"> <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Add Sub Event</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="field-1" class="control-label">Event Name</label>
                <select name="e_id" id="e_id" style="position: static;" class="form-control" data-placeholder="Select one Event...">
                  @for($i = 0; $i < count($event); $i++) <option value="{{$event[$i]->e_id}}">{{$event[$i]->e_name}}</option>
                    @endfor
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="field-2" class="control-label">Sub Event Name</label>
                <input type="hidden" class="form-control" value="1" name="status" id="e_status" />
                <input type="text" class="form-control" name="s_e_name" id="s_e_name" placeholder="Sub Event Name" />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="field-2" class="control-label">Sub Event Discription</label>
                <textarea class="form-control" name="s_e_discription" id="s_e_discription" value="" placeholder="Sub Event Discription" cols="30" rows="10"></textarea>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="field-2" class="control-label">Duration</label>
                <input type="time" class="form-control" min="1:00" max="24:00" name="s_e_duration" id="s_e_duration" />
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
  <form method="post" id="updatesubevent" action="{{route('admin.updatesubevent')}}">
    {{csrf_field()}}
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header"> <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Update Sub Event</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="field-1" class="control-label">Event Name</label>
                <input type="hidden" name="s_e_id" id="s_e_id_field" />
                <select name="e_id" id="e_id" style="position: static;" class="form-control" data-placeholder="Select one stream...">
                  <option id="e_id_field" value=""></option>
                  @for($i = 0; $i < count($event); $i++) <option value="{{$event[$i]->e_id}}">{{$event[$i]->e_name}}</option>
                    @endfor
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="field-2" class="control-label">Sub Event Name</label>
                <input type="text" class="form-control" name="s_e_name" id="s_e_name_field" placeholder="Sub Event Name" />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="field-2" class="control-label">Sub Event Discription</label>
                <textarea class="form-control" name="s_e_discription" id="s_e_discription_field" value="" placeholder="Sub Event Discription" cols="30" rows="10"></textarea>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="field-2" class="control-label">Duration</label>
                <input type="time" class="form-control" min="1:00" max="24:00" name="s_e_duration" id="s_e_duration_field" />
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
    let s_e_id = record_id[0];
    let e_id = record_id[1];
    let e_id_val = record_id[2];
    let s_e_name = record_id[3];
    let s_e_discription = record_id[4];
    let s_e_duration = record_id[5];

    $('#s_e_id_field').val(s_e_id);
    $('#e_id_field').val(e_id).text(e_id_val);
    $('#s_e_name_field').val(s_e_name);
    $('#s_e_discription_field').val(s_e_discription);
    $('#s_e_duration_field').val(s_e_duration);

    jQuery('#modal-6').modal('show', {
      backdrop: 'static'
    });
  }
</script>

<script>
  $(document).ready(function() {
    $("#addsubevent").submit(function(e) {
      let e_id = $("#e_id").val();
      let s_e_name = $("#s_e_name").val();
      let s_e_discription = $("#s_e_discription").val();
      let s_e_duration = $("#s_e_duration").val();

      $(".error").remove();
      // return false;
      if (e_id == "") {
        e.preventDefault();
        $("#e_id").after(
          '<span class="error">This field is required</span>'
        );
      }
      if (!/^[a-zA-Z]/.test(s_e_name) || s_e_name == "") {
        e.preventDefault();
        $("#s_e_name").after(
          '<span class="error">This field is required</span>'
        );
      } else if (s_e_name.length >= 50) {
        e.preventDefault();
        $("#s_e_name").after(
          '<span class="error">Sub Event Name should maximum 50 characters only.</span>'
        );
      }
      if (!/^[a-zA-Z]/.test(s_e_discription) || s_e_discription == "") {
        e.preventDefault();
        $("#s_e_discription").after(
          '<span class="error">This field is required</span>'
        );
      } else if (s_e_discription.length > 255) {
        e.preventDefault();
        $("#s_e_discription").after(
          '<span class="error">Sub Event Discription should maximum 255 characters only.</span>'
        );
      }
      if (s_e_duration == "") {
        e.preventDefault();
        $("#s_e_duration").after(
          '<span class="error">This field is required</span>'
        );
      }
    });
    $("#updatesubevent").submit(function(e) {
      let e_id_field = $("#e_id_field").val();
      let s_e_name_field = $("#s_e_name_field").val();
      let s_e_discription_field = $("#s_e_discription_field").val();
      let s_e_duration_field = $("#s_e_duration_field").val();

      $(".error").remove();
      // return false;
      if (e_id_field == "") {
        e.preventDefault();
        $("#e_id_field").after(
          '<span class="error">This field is required</span>'
        );
      }
      if (!/^[a-zA-Z]/.test(s_e_name_field) || s_e_name_field == "") {
        e.preventDefault();
        $("#s_e_name_field").after(
          '<span class="error">This field is required</span>'
        );
      } else if (s_e_name_field.length >= 50) {
        e.preventDefault();
        $("#s_e_name_field").after(
          '<span class="error">Sub Event Name should maximum 50 characters only.</span>'
        );
      }
      if (!/^[a-zA-Z]/.test(s_e_discription_field) || s_e_discription_field == "") {
        e.preventDefault();
        $("#s_e_discription_field").after(
          '<span class="error">This field is required</span>'
        );
      } else if (s_e_discription_field.length > 255) {
        e.preventDefault();
        $("#s_e_discription_field").after(
          '<span class="error">Sub Event Discription should maximum 255 characters only.</span>'
        );
      }
      if (s_e_duration_field == "") {
        e.preventDefault();
        $("#s_e_duration_field").after(
          '<span class="error">This field is required</span>'
        );
      }
    });
  });
</script>
@endsection