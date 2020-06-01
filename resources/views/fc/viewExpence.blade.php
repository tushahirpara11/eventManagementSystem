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
      <th>#No.</th>
      <th>Event Name</th>
      <th>Sub Event Name</th>
      <th>Expence Type</th>
      <th>User</th>
      <th>Description</th>
      <th>Amount</th>
      <th>Status</th>
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
      @if($data[$i]->status == 0)
      <td><span class="badge badge-info">Pending</span></td>
      @elseif($data[$i]->status == 1)
      <td><span class="badge badge-success">Approved</span></td>
      @elseif($data[$i]->status == 2)
      <td><span class="badge badge-danger">Reject</span></td>
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
    </tr>
  </tfoot>
</table> <br />
<button type="click" onclick="jQuery('#modal-6').modal('show', {
      backdrop: 'static'
    });" class="btn btn-info btn-lg btn-icon icon-left"><i class="entypo-plus"></i>Add Expence</button>

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
<script>
  function openmodal(id) {
    let record_id = id.split("_");
    let u_id = record_id[0];
    let f_name_field = record_id[1];
    let l_name_field = record_id[2];
    let email_field = record_id[3];
    let phone_field = record_id[4];
    let dob_field = record_id[5];
    let b_id_val = record_id[6];
    let b_value = record_id[7];
    let s_id_val = record_id[8];
    let s_value = record_id[9];
    let d_id_val = record_id[10];
    let d_value = record_id[11];
    let gender = record_id[12];
    let u_type = record_id[13];

    $("#u_id").val(u_id);
    $("#f_name_field").val(f_name_field);
    $("#l_name_field").val(l_name_field);
    $("#email_field").val(email_field);
    $("#phone_field").val(phone_field);
    $("#dob_field").val(dob_field);
    $("#b_id_val").val(b_id_val).text(b_value);
    $("#s_id_val").val(s_id_val).text(s_value);
    $("#d_id_val").val(d_id_val).text(d_value);
    if (gender == 'male') {
      $('#male_field').prop('checked', true);
    } else {
      $('#female_field').prop('checked', true);
    }
    if (u_type == 0) {
      $("#u_type_val").val(0).text('Student');
    } else {
      $("#u_type_val").val(3).text('Coordinator');
    }

    jQuery('#modal-6').modal('show', {
      backdrop: 'static'
    });
  }
</script>
<script>
  $(document).ready(function() {
    $("#addExpence").submit(function(e) {
      let name = $("#name").val();
      let s_e_id = $("#s_e_id").val();
      let e_t_id = $("#e_t_id").val();
      let amount = $("#amount").val();
      let description = $("#description").val();

      $(".error").remove();

      if (s_e_id == null) {
        e.preventDefault();
        $("#s_e_id").after(
          '<span class="error">This field is required</span>'
        );
      }
      if (e_t_id == null) {
        e.preventDefault();
        $("#e_t_id").after(
          '<span class="error">This field is required</span>'
        );
      }

      if (description == "") {
        e.preventDefault();
        $("#description").after(
          '<span class="error">This field is required</span>'
        );
      } else if (!/^[a-zA-Z0-9]/.test(description)) {
        e.preventDefault();
        $("#description").after(
          '<span class="error">Name allow [A-Za-z0-9] characters only.</span>'
        );
      } else if (description.length > 255) {
        e.preventDefault();
        $("#description").after(
          '<span class="error">Description maximum 255 characters only.</span>'
        );
      }
      if (amount == "") {
        e.preventDefault();
        $("#amount").after(
          '<span class="error">This field is required</span>'
        );
      } else if (!/^[0-9]{0,5}$/.test(amount)) {
        e.preventDefault();
        $("#amount").after(
          '<span class="error">Amount accept only 5 digits[0-9] only.</span>'
        );
      } else if (amount <= 0) {
        e.preventDefault();
        $("#amount").after(
          '<span class="error">Amount Greater Than 0.</span>'
        );
      }
    });
  });
</script>
@endsection