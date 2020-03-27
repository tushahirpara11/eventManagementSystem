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
<h3>Guest Master</h3> <br />
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
      <th class="col-xs-1">Name</th>
      <th class="col-xs-1">Phone</th>
      <th class="col-xs-1">Email</th>
      <th class="col-xs-1">Actions</th>
    </tr>
  </thead>
  <tbody>
    @for($i = 0; $i < count($data); $i++) <tr class="odd gradeX">
      <td>{{$i+1}}</td>
      <td>{{$data[$i]->name}}</td>
      <td>{{$data[$i]->phome}}</td>
      <td>{{$data[$i]->email}}</td>
      <td class="col-md-2">
        <form style="display: inline;">
          <a href="javascript:;" id="{{$data[$i]->guest_id}}_{{$data[$i]->name}}_{{$data[$i]->phome}}_{{$data[$i]->email}}" onclick="openmodal(this.id);" class="btn btn-default btn-sm btn-icon icon-left"><i class="entypo-pencil"></i>Edit</a>
        </form> &nbsp; &nbsp;
        <form action="{{ route('eac.deleteguest', [$data[$i]->guest_id]) }}" method="post" style="display: inline;">
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
      <th>Name</th>
      <th>Phone</th>
      <th>Email</th>
      <th></th>
    </tr>
  </tfoot>
</table> <br />
<button type="click" onclick="jQuery('#modal-7').modal('show', {
      backdrop: 'static'
    });" class="btn btn-info btn-lg btn-icon icon-left"><i class="entypo-plus"></i>Add Guest</button>
<script>
  function checkResponce() {
    if (!confirm('Are you sure want to Delete this Record?')) {
      return false;
    }
    this.form.submit();
  }
</script>
<div class="modal fade" id="modal-7">
  <form method="post" id="addguest" action="{{route('eac.addguest')}}">
    {{csrf_field()}}
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header"> <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Add Guest</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-8">
              <div class="form-group">
                <label for="field-2" class="control-label">Guest Name</label>
                <input type="text" class="form-control" name="name" id="g_name" placeholder="Guest Name" />
              </div>
            </div>
            <div class="col-md-8">
              <div class="form-group">
                <label for="field-2" class="control-label">Phone</label>
                <input type="tel" class="form-control" name="phome" id="g_phone" placeholder="Guest Phone" />
              </div>
            </div>
            <div class="col-md-8">
              <div class="form-group">
                <label for="field-2" class="control-label">Email</label>
                <input type="email" class="form-control" name="email" id="g_email" placeholder="Guest Email" />
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
  <form method="post" id="updateguest" action="{{route('eac.updateguest')}}">
    {{csrf_field()}}
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header"> <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Update Guest</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-8">
              <div class="form-group">
                <label for="field-2" class="control-label">Guest Name</label>
                <input type="hidden" class="form-control" name="guest_id" id="g_id_field" />
                <input type="text" class="form-control" name="name" id="g_name_field" placeholder="Guest Name" />
              </div>
            </div>
            <div class="col-md-8">
              <div class="form-group">
                <label for="field-2" class="control-label">Phone</label>
                <input type="tel" class="form-control" name="phome" id="g_phone_field" placeholder="Guest Phone" />
              </div>
            </div>
            <div class="col-md-8">
              <div class="form-group">
                <label for="field-2" class="control-label">Email</label>
                <input type="tel" class="form-control" name="email" id="g_email_field" placeholder="Guest Email" />
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
    let g_id = record_id[0];
    let g_name = record_id[1];
    let g_phone = record_id[2];
    let g_email = record_id[3];

    $('#g_id_field').val(g_id);
    $('#g_name_field').val(g_name);
    $('#g_phone_field').val(g_phone);
    $('#g_email_field').val(g_email);

    jQuery('#modal-6').modal('show', {
      backdrop: 'static'
    });
  }
</script>

<script>
  $(document).ready(function() {
    $("#addguest").submit(function(e) {      
      let g_name = $("#g_name").val();
      let g_phone = $("#g_phone").val();
      let g_email = $("#g_email").val();

      $(".error").remove();
      // return false;      

      if (!/^[a-zA-Z]/.test(g_name) || g_name == "") {
        e.preventDefault();
        $("#g_name").after(
          '<span class="error">This field is required</span>'
        );
      } else if (g_name.length > 30) {
        e.preventDefault();
        $("#g_name").after(
          '<span class="error">Guest should maximum 30 characters only.</span>'
        );
      }

      if (!/^[0-9]{10}/.test(g_phone) || g_phone == "") {
        e.preventDefault();
        $("#g_phone").after(
          '<span class="error">This field is required</span>'
        );
      } else if (g_phone.length > 10) {
        e.preventDefault();
        $("#g_phone").after(
          '<span class="error">Contact should maximum 10 characters only.</span>'
        );
      }

      if (!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(g_email) || g_email == "") {
        e.preventDefault();
        $("#g_email").after(
          '<span class="error">Enter valid Email</span>'
        );
      }
    });
    $("#updateguest").submit(function(e) {
      let g_name = $("#g_name_field").val();
      let g_phone = $("#g_phone_field").val();
      let g_email = $("#g_email_field").val();

      $(".error").remove();
      // return false;      

      if (!/^[a-zA-Z]/.test(g_name) || g_name == "") {
        e.preventDefault();
        $("#g_name_field").after(
          '<span class="error">This field is required</span>'
        );
      } else if (g_name.length > 30) {
        e.preventDefault();
        $("#g_name_field").after(
          '<span class="error">Guest should maximum 30 characters only.</span>'
        );
      }

      if (!/^[0-9]{10}/.test(g_phone) || g_phone == "") {
        e.preventDefault();
        $("#g_phone_field").after(
          '<span class="error">This field is required</span>'
        );
      } else if (g_phone.length > 10) {
        e.preventDefault();
        $("#g_phone_field").after(
          '<span class="error">Contact should maximum 10 characters only.</span>'
        );
      }

      if (!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(g_email) || g_email == "") {
        e.preventDefault();
        $("#g_email_field").after(
          '<span class="error">Enter valid Email</span>'
        );
      }
    });
  });
</script>
@endsection