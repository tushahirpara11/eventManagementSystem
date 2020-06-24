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
<h3>Attendence</h3> <br />
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
      <th class="col-xs-1">Sub Event</th>
      <th class="col-xs-1">Att. Taker</th>
      <th class="col-xs-1">Present</th>
      <th class="col-xs-1">Date</th>
      <th class="col-xs-1">Actions</th>
    </tr>
  </thead>
  <tbody>
    @for($i = 0; $i < count($data); $i++) <tr class="odd gradeX">
      <td>{{$i+1}}</td>
      <td>{{$data[$i]->s_e_name}}</td>
      <td>{{$data[$i]->f_name}} {{$data[$i]->l_name}}</td>
      <td>{{$data[$i]->present}}</td>
      <td>{{$data[$i]->date}}</td>
      <td class="col-md-2">
        <form style="display: inline;">
          <a href="{{route('eac.ediAttendence',[$data[$i]->s_e_id,$data[$i]->date])}}" id="" class="btn btn-default btn-sm btn-icon icon-left"><i class="entypo-pencil"></i>Edit</a>
        </form> &nbsp; &nbsp;
        <form action="{{route('eac.deleteattendence',[$data[$i]->a_id])}}" method="post" style="display: inline;">
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
      <th>Sub Event</th>
      <th>Att. Taker</th>
      <th>Present</th>
      <th>Date</th>
      <th></th>
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
  <form method="post" id="updateUser" action="{{route('eac.updateuser')}}">
    {{csrf_field()}}
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header"> <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Update User</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="field-2" class="control-label">First Name</label>
                <input type="hidden" class="form-control" name="u_id" id="u_id" />
                <input type="text" class="form-control" name="f_name" id="f_name_field" placeholder="First Name" />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="field-2" class="control-label">Last Name</label>
                <input type="text" class="form-control" name="l_name" id="l_name_field" placeholder="Last Name" />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="field-2" class="control-label">Email</label>
                <input type="email" class="form-control" name="email" id="email_field" placeholder="Email" />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="field-2" class="control-label">Phone</label>
                <input type="tel" class="form-control" name="phone" id="phone_field" placeholder="Phone" />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="field-2" class="control-label">Birth Date</label>
                <input type="date" class="form-control" name="dob" id="dob_field" />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="field-1" class="control-label">Branch Name</label>
                <select name="b_id" id="b_id_field" style="position: static;" class="form-control" data-placeholder="Select one Branch...">
                  <option id="b_id_val" value=""></option>

                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <input type="hidden" name="gender_hidden" value="" id="gender_hidden" />
                <label for="field-1" class="control-label">Gender</label><br />
                &nbsp;
                <input type="radio" name="gender" value="male" id="male_field">Male
                &nbsp;
                <input type="radio" name="gender" value="female" id="female_field">Female
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
    let gender = record_id[8];

    $("#u_id").val(u_id);
    $("#f_name_field").val(f_name_field);
    $("#l_name_field").val(l_name_field);
    $("#email_field").val(email_field);
    $("#phone_field").val(phone_field);
    $("#dob_field").val(dob_field);
    $("#b_id_val").val(b_id_val).text(b_value);
    if (gender == 'male') {
      $('#male_field').prop('checked', true);
    } else {
      $('#female_field').prop('checked', true);
    }

    jQuery('#modal-6').modal('show', {
      backdrop: 'static'
    });
  }
</script>

<script>
  $(document).ready(function() {
    $("#updateUser").submit(function(e) {
      let f_name = $("#f_name_field").val();
      let l_name = $("#l_name_field").val();
      let email = $("#email_field").val();
      let phone = $("#phone_field").val();
      let dob = $("#dob_field").val();
      let b_id = $("#b_id_field").val();
      let password = $("#password_field").val();
      let cpassword = $("#cpassword_field").val();

      $(".error").remove();
      // return false;
      if (b_id == "") {
        e.preventDefault();
        $("#b_id_field").after(
          '<span class="error">This field is required</span>'
        );
      }

      if (!/^[a-zA-Z]/.test(f_name) || f_name == "") {
        e.preventDefault();
        $("#f_name_field").after(
          '<span class="error">This field is required</span>'
        );
      } else if (f_name.length >= 15) {
        e.preventDefault();
        $("#f_name_field").after(
          '<span class="error">First Name should maximum 15 characters only.</span>'
        );
      }

      if (!/^[a-zA-Z]/.test(l_name) || l_name == "") {
        e.preventDefault();
        $("#l_name_field").after(
          '<span class="error">This field is required</span>'
        );
      } else if (l_name.length >= 15) {
        e.preventDefault();
        $("#l_name ").after(
          '<span class="error">Last Name should maximum 15 characters only.</span>'
        );
      }

      if (!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email) || email == "") {
        e.preventDefault();
        $("#email_field").after(
          '<span class="error">Enter valid Email</span>'
        );
      }

      if (!/^[6-9]+[0-9]{9}/.test(phone) || phone == "") {
        e.preventDefault();
        $("#phone_field").after(
          '<span class="error">This field is required</span>'
        );
      } else if (phone.length != 10) {
        e.preventDefault();
        $("#phone_field").after(
          '<span class="error">Contact must be 10 digits only.</span>'
        );
      }
      if (dob == "") {
        e.preventDefault();
        $("#dob_field").after(
          '<span class="error">This field is required</span>'
        );
      }
      if (password == "") {
        e.preventDefault();
        $("#password_field").after(
          '<span class="error">This field is required</span>'
        );
      } else if (password.length != 8) {
        e.preventDefault();
        $("#password_field").after(
          '<span class="error">Password must be maximum 8 character only.</span>'
        );
      }
      if (cpassword == "") {
        e.preventDefault();
        $("#cpassword_field").after(
          '<span class="error">This field is required</span>'
        );
      } else if (cpassword.length != 8) {
        e.preventDefault();
        $("#cpassword_field").after(
          '<span class="error">Confirm Password must be maximum 8 character only.</span>'
        );
      } else if (password != cpassword) {
        e.preventDefault();
        $("#cpassword_field").after(
          '<span class="error">Password and Confirm password must be same.</span>'
        );
      }
    });
  });
</script>
@endsection