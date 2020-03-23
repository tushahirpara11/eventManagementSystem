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
<h3>Choreographer</h3> <br />
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
      <th class="col-xs-1">Choreo. Name</th>
      <th class="col-xs-1">Phone</th>
      <th class="col-xs-1">Email</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    @for($i = 0; $i < count($data); $i++) <tr class="odd gradeX">
      <td>{{$i+1}}</td>      
        <td>{{$data[$i]->s_e_name}}</td>        
        <td>{{$data[$i]->c_name}}</td>
        <td>{{$data[$i]->c_phone}}</td>
        <td>{{$data[$i]->c_email}}</td>
        <td class="col-md-2">
          <form style="display: inline;">
            <a href="javascript:;" id="{{$data[$i]->c_id}}_{{$data[$i]->s_e_id}}_{{$data[$i]->s_e_name}}_{{$data[$i]->c_name}}_{{$data[$i]->c_phone}}_{{$data[$i]->c_email}}" onclick="openmodal(this.id);" class="btn btn-default btn-sm btn-icon icon-left"><i class="entypo-pencil"></i>Edit</a>
          </form> &nbsp; &nbsp;
          <form action="{{ route('eac.deletechoreographer', [$data[$i]->c_id]) }}" method="post" style="display: inline;">
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
      <th>Choreo. Name</th>
      <th>Phone</th>
      <th>Email</th>
      <th></th>
    </tr>
  </tfoot>
</table> <br />
<button type="click" onclick="jQuery('#modal-7').modal('show', {
      backdrop: 'static'
    });" class="btn btn-info btn-lg btn-icon icon-left"><i class="entypo-plus"></i>Add Choreographer</button>
<script>
  function checkResponce() {
    if (!confirm('Are you sure want to Delete this Record?')) {
      return false;
    }
    this.form.submit();
  }
</script>
<div class="modal fade" id="modal-7">
  <form method="post" id="addchoreographer" action="{{route('eac.addchoreographer')}}">
    {{csrf_field()}}
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header"> <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Add Choreographer</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="field-1" class="control-label">Sub Event Name</label>
                <select name="s_e_id" id="s_e_id" style="position: static;" class="form-control" data-placeholder="Select one Event...">
                  @for($i = 0; $i < count($subevent); $i++) <option value="{{$subevent[$i]->e_id}}">{{$subevent[$i]->s_e_name}}</option>
                    @endfor
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="field-2" class="control-label">Choreo. Name</label>
                <input type="text" class="form-control" name="c_name" id="c_name" placeholder="Choreographer Name" />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="field-2" class="control-label">Phone</label>
                <input type="tel" class="form-control" name="c_phone" id="c_phone" placeholder="Choreographer Phone" />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="field-2" class="control-label">Email</label>
                <input type="email" class="form-control" name="c_email" id="c_email" placeholder="Choreographer Email" />
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
  <form method="post" id="updatechoreographer" action="{{route('eac.updatechoreographer')}}">
    {{csrf_field()}}
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header"> <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Update Choreographer</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="field-1" class="control-label">Sub Event Name</label>
                <select name="s_e_id" id="s_e_id" style="position: static;" class="form-control" data-placeholder="Select one Event...">
                  <option id="s_e_id_field" value=""></option>
                  @for($i = 0; $i < count($subevent); $i++) <option value="{{$subevent[$i]->e_id}}">{{$subevent[$i]->s_e_name}}</option>
                    @endfor
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="field-2" class="control-label">Choreo. Name</label>
                <input type="hidden" class="form-control" name="c_id" id="c_id_field" />
                <input type="text" class="form-control" name="c_name" id="c_name_field" placeholder="Choreographer Name" />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="field-2" class="control-label">Phone</label>
                <input type="tel" class="form-control" name="c_phone" id="c_phone_field" placeholder="Choreographer Phone" />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="field-2" class="control-label">Email</label>
                <input type="tel" class="form-control" name="c_email" id="c_email_field" placeholder="Choreographer Email" />
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
    let c_id = record_id[0];
    let s_e_id = record_id[1];
    let s_e_id_value = record_id[2];
    let c_name = record_id[3];
    let c_phone = record_id[4];
    let c_email = record_id[5];

    $('#c_id_field').val(c_id);
    $('#s_e_id_field').val(s_e_id).text(s_e_id_value);
    $('#c_name_field').val(c_name);
    $('#c_phone_field').val(c_phone);
    $('#c_email_field').val(c_email);

    jQuery('#modal-6').modal('show', {
      backdrop: 'static'
    });
  }
</script>

<script>
  $(document).ready(function() {
    $("#addchoreographer").submit(function(e) {
      let s_e_id = $("#s_e_id").val();
      let c_name = $("#c_name").val();
      let c_phone = $("#c_phone").val();
      let c_email = $("#c_email").val();

      $(".error").remove();
      // return false;
      if (s_e_id == "") {
        e.preventDefault();
        $("#s_e_id").after(
          '<span class="error">This field is required</span>'
        );
      }

      if (!/^[a-zA-Z]/.test(c_name) || c_name == "") {
        e.preventDefault();
        $("#c_name").after(
          '<span class="error">This field is required</span>'
        );
      } else if (c_name.length >= 50) {
        e.preventDefault();
        $("#c_name").after(
          '<span class="error">Sub Event Name should maximum 50 characters only.</span>'
        );
      }

      if (!/^[0-9]{10}/.test(c_phone) || c_phone == "") {
        e.preventDefault();
        $("#c_phone").after(
          '<span class="error">This field is required</span>'
        );
      } else if (c_phone.length > 10) {
        e.preventDefault();
        $("#c_phone").after(
          '<span class="error">Contact should maximum 10 characters only.</span>'
        );
      }

      if (!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(c_email) || c_email == "") {
        e.preventDefault();
        $("#c_email").after(
          '<span class="error">Enter valid Email</span>'
        );
      }
    });
    $("#updatechoreographer").submit(function(e) {
      let s_e_id = $("#s_e_id_field").val();
      let c_name = $("#c_name_field").val();
      let c_phone = $("#c_phone_field").val();
      let c_email = $("#c_email_field").val();

      $(".error").remove();
      // return false;
      if (s_e_id == "") {
        e.preventDefault();
        $("#s_e_id_field").after(
          '<span class="error">This field is required</span>'
        );
      }

      if (!/^[a-zA-Z]/.test(c_name) || c_name == "") {
        e.preventDefault();
        $("#c_name_field").after(
          '<span class="error">This field is required</span>'
        );
      } else if (c_name.length >= 50) {
        e.preventDefault();
        $("#c_name_field").after(
          '<span class="error">Sub Event Name should maximum 50 characters only.</span>'
        );
      }

      if (!/^[0-9]{10}/.test(c_phone) || c_phone == "") {
        e.preventDefault();
        $("#c_phone_field").after(
          '<span class="error">This field is required</span>'
        );
      } else if (c_phone.length > 10) {
        e.preventDefault();
        $("#c_phone_field").after(
          '<span class="error">Contact should maximum 10 characters only.</span>'
        );
      }

      if (!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(c_email) || c_email == "") {
        e.preventDefault();
        $("#c_email_field").after(
          '<span class="error">Enter valid Email</span>'
        );
      }
    });
  });
</script>
@endsection