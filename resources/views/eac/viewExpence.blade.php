@extends('eaclayout.app')
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
<h3>Expence</h3> <br />
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
      <th class="col-xs-1">Expence Type</th>
      <th class="col-xs-1">User</th>
      <th class="col-xs-1">Description</th>
      <th class="col-xs-1">Amount</th>
      <th>Status</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    @for($i = 0; $i < count($data); $i++) <tr class="odd gradeX">
      <td>{{$i+1}}</td>
      <td>{{$data[$i]->e_name}}</td>
      <td>{{$data[$i]->s_e_name}}</td>
      <td>{{$data[$i]->name}}</td>
      <td>{{$data[$i]->f_name}} {{$data[$i]->l_name}}</td>
      <td>{{$data[$i]->description}}</td>
      <td>{{$data[$i]->amount}}</td>
      <td style="display: block">
        @if($data[$i]->status == 0)
        <form action="{{ route('eac.updateExpence', [1,$data[$i]->expence_id]) }}" method="post" style="display: inline;">
          {{csrf_field()}}
          <button type="submit" class="btn btn-success btn-sm btn-icon icon-left"><i class="entypo-check"></i>Approve</button>
        </form>
        <form action="{{ route('eac.updateExpence', [2,$data[$i]->expence_id]) }}" method="post" style="display: inline;">
          {{csrf_field()}}
          <button type="submit" class="btn btn-danger btn-sm btn-icon icon-left"><i class="entypo-cancel"></i>Reject</button>
        </form>
        @elseif($data[$i]->status == 1)
        <span class="badge badge-success">Approved</span>
        @elseif($data[$i]->status == 2)
        <span class="badge badge-danger">Reject</span>
        @endif
      </td>
      @if($data[$i]->status == 0)
      <td></td>
      @else
      <td>
        <a id="{{$data[$i]->expence_id}}_{{$data[$i]->status}}" onclick="openmodal(this.id);" class="btn btn-default btn-sm btn-icon icon-left"><i class="entypo-pencil"></i>Edit</a>
        &nbsp;
        <form action="{{ route('eac.deleteExpence', [$data[$i]->expence_id]) }}" method="post" style="display: inline;">
          {{csrf_field()}}
          {{ method_field('DELETE') }}
          <button type="submit" onclick="return checkResponce();" class="btn btn-danger btn-sm btn-icon icon-left"><i class="entypo-cancel"></i>Delete</button>
        </form>
      </td>
      @endif
      </tr>
      @endfor
  </tbody>
  <tfoot>
    <tr>
      <th></th>
      <th>Event Name</th>
      <th>Sub Event Name</th>
      <th>Expence Type</th>
      <th>User</th>
      <th>Description</th>
      <th>Amount</th>
      <th>Status</th>
      <th>Action</th>
    </tr>
  </tfoot>
</table>
<script>
  function checkResponce() {
    if (!confirm('Are you sure want to Delete this Record?')) {
      return false;
    }
    this.form.submit();
  }
</script>

<div class="modal fade" id="modal-6">
  <form method="post" id="addExpence" action="{{route('fc.addExpence')}}">
    {{csrf_field()}}
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header"> <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Add Expence</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="field-1" class="control-label">Sub Event Name</label>
                <select name="s_e_id" id="s_e_id" style="position: static;" class="form-control" data-placeholder="Select one Sub Event...">
                  @for($i = 0; $i < count($subEvent); $i++) <option value="{{$subEvent[$i]->s_e_id}}">{{$subEvent[$i]->s_e_name}}</option>
                    @endfor
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="field-1" class="control-label">Expence Type</label>
                <select name="e_t_id" id="e_t_id" style="position: static;" class="form-control" data-placeholder="Select one Expence Type...">
                  @for($i = 0; $i < count($expenceType); $i++) <option value="{{$expenceType[$i]->e_t_id}}">{{$expenceType[$i]->name}}</option>
                    @endfor
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="field-2" class="control-label">Amount</label>
                <input type="text" class="form-control" name="amount" id="amount" placeholder="Amount" />
                <input type="hidden" class="form-control" name="u_id" value="{{Session::get('fc')}}" />
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label for="field-2" class="control-label">Discription</label>
                <textarea class="form-control" name="description" id="description" placeholder="Enter Discription"></textarea>
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
  <form method="post" id="updateExpence" action="{{route('eac.updateStatus')}}">
    {{csrf_field()}}
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header"> <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Update Status</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="field-1" class="control-label">Status</label>
                <input type="hidden" value="" id="expence_id" name="expence_id" />
                <select name="status" id="status" style="position: static;" class="form-control" data-placeholder="Select one Status...">
                  <option id="status_id" value=""></option>
                  <option value="1">Accept</option>
                  <option value="2">Reject</option>
                </select>
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
    let expence_id = record_id[0];
    let status = record_id[1];

    if (status == 1) {
      $("#status_id").val(status).text("Accept");
      $("#expence_id").val(expence_id);
    } else if (status == 2) {
      $("#status_id").val(status).text("Reject");
      $("#expence_id").val(expence_id);
    }
    jQuery('#modal-7').modal('show', {
      backdrop: 'static'
    });
  }
</script>
@endsection