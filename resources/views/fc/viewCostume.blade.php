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
<h3>Costume</h3> <br />
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
      <th class="col-xs-1">Sub Event Name</th>
      <th class="col-xs-1">User</th>
      <th class="col-xs-1">Issuer</th>
      <th class="col-xs-1">Returner</th>
      <th class="col-xs-1">Issue Date</th>
      <th class="col-xs-1">Return Date</th>
      <th class="col-xs-1">Status</th>
      <th class="col-xs-1">Actions</th>
    </tr>
  </thead>
  <tbody>
    @for($i = 0; $i < count($data); $i++) <tr class="odd gradeX">
      <td>{{$i+1}}</td>
      <td>{{$data[$i]->s_e_name}}</td>
      @for($j = 0; $j < count($student); $j++)
      @if($student[$j]->u_id == $data[$i]->u_id)
        <td>{{$student[$j]->f_name}} {{$student[$j]->l_name}}</td>
      @endif
      @endfor
      @for($j = 0; $j < count($student); $j++)
      @if($student[$j]->u_id == $data[$i]->issuer)
        <td>{{$student[$j]->f_name}} {{$student[$j]->l_name}}</td>
      @endif
      @endfor
      @for($j = 0; $j < count($student); $j++)
      @if($data[$i]->returner != "")
      @if($student[$j]->u_id == $data[$i]->returner)
        <td>{{$student[$j]->f_name}} {{$student[$j]->l_name}}</td>
      @endif
      @else
      <td>-</td>
      @break
      @endif
      @endfor      
      <td>{{$data[$i]->issue_date}}</td>
      @if($data[$i]->return_date != '')
      <td>{{$data[$i]->return_date}}</td>
      @else
      <td>-</td>
      @endif
      <td>@if($data[$i]->status == 0)
      <span class="badge badge-primary" style="background: navy">Issued</span>
        @elseif($data[$i]->status == 1)
      <span class="badge badge-success">Return</span>
        @endif
      </td>
      <td class="col-md-2">
        <form style="display: inline;">
          <a href="javascript:;" id="{{$data[$i]->costume_id}}_{{$data[$i]->status}}_{{Session::get('fc')}}_{{$data[$i]->s_e_id}}" onclick="openmodal(this.id);" class="btn btn-default btn-sm btn-icon icon-left"><i class="entypo-pencil"></i>Edit</a>
        </form> &nbsp; &nbsp;
        <form action="{{ route('fc.deleteCostumes', [$data[$i]->costume_id]) }}" method="post" style="display: inline;">
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
      <th>Sub Event Name</th>
      <th>User</th>
      <th>Issuer</th>
      <th>Returner</th>
      <th>Issue Date</th>
      <th>Return Date</th>
      <th>Status</th>
      <th></th>
    </tr>
  </tfoot>
</table> <br />
<button type="click" onclick="jQuery('#modal-7').modal('show', {
      backdrop: 'static'
    });" class="btn btn-info btn-lg btn-icon icon-left"><i class="entypo-plus"></i>Add Costume</button>
<script>
  function checkResponce() {
    if (!confirm('Are you sure want to Delete this Record?')) {
      return false;
    }
    this.form.submit();
  }
</script>
<div class="modal fade" id="modal-7">
  <form method="post" id="addCostumes" action="{{route('fc.addCostumes')}}">
    {{csrf_field()}}
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header"> <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Add Costume</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="field-1" class="control-label">Student Name</label>
                <select name="u_id" id="u_id" style="position: static;" class="form-control" data-placeholder="Select one Event...">
                  @for($i = 0; $i < count($studentList); $i++) <option value="{{$studentList[$i]->u_id}}">{{$studentList[$i]->f_name}} {{$studentList[$i]->l_name}}</option>
                    @endfor
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <input type="hidden" class="form-control" value="{{Session::get('f_s_e_id')}}" name="s_e_id" />
                <input type="hidden" class="form-control" value="{{Session::get('fc')}}" name="issuer" />
                <input type="hidden" class="form-control" value="" name="returner" />
                <input type="hidden" class="form-control" value="{{date('Y-m-d')}}" name="issue_date" />
                <input type="hidden" class="form-control" value="" name="return_date" />
                <input type="hidden" class="form-control" value="0" name="status" />
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
  <form method="post" id="updateCostume" action="{{route('fc.updateCostumes')}}">
    {{csrf_field()}}
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header"> <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Update Costume</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="field-1" class="control-label">Status</label>
                <input type="hidden" name="costume_id" id="costume_id_field" />                
                <input type="hidden" name="s_e_id" id="s_e_id_field" />                
                <input type="hidden" name="u_id" id="u_id_field" />
                <select name="status" id="status" style="position: static;" class="form-control" data-placeholder="Select one stream...">
                  <option id="status_id_field" value=""></option>
                  <option value="0">Issued</option>
                  <option value="1">Return</option>
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
    let costume_id = record_id[0];
    let status_id = record_id[1];
    let user_id = record_id[2];
    let s_e_id = record_id[3];

    $('#costume_id_field').val(costume_id);
    if(status_id == 0) {
    $('#status_id_field').val(status_id).text('Issued');
    } else {
      $('#status_id_field').val(status_id).text('Return');
    }
    $('#u_id_field').val(user_id);
    $('#s_e_id_field').val(s_e_id);

    jQuery('#modal-6').modal('show', {
      backdrop: 'static'
    });
  }
</script>

<script>
  $(document).ready(function() {
    $("#addCostumes").submit(function(e) {
      let u_id = $("#u_id").val();

      $(".error").remove();
      // return false;
      if (u_id == null) {
        e.preventDefault();
        $("#u_id").after(
          '<span class="error">This field is required</span>'
        );
      }
    });
    $("#updatesubevent").submit(function(e) {
      let status = $("#status").val();
      
      $(".error").remove();
      // return false;
      if (status == null) {
        e.preventDefault();
        $("#status").after(
          '<span class="error">This field is required</span>'
        );
      }      
    });
  });
</script>
@endsection