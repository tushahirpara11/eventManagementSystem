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
<h3>User Masters</h3> <br />
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
      <th>First Name</th>
      <th>Last Name</th>
      <th>Email</th>
      <th>Phone</th>
      <th>Branch</th>
      <th>Stream</th>
      <th>Division</th>
      <th>Gender</th>
      <th>Type</th>
      <th>Status</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    @for($i = 0; $i < count($data); $i++) <tr class="odd gradeX">
      <td>{{$i+1}}</td>
      <td>{{$data[$i]->f_name}}</td>
      <td>{{$data[$i]->l_name}}</td>
      <td>{{$data[$i]->email}}</td>
      <td>{{$data[$i]->phone}}</td>
      <td>{{$data[$i]->b_name}}</td>
      <td>{{$data[$i]->s_name}}</td>
      <td>{{$data[$i]->d_name}}</td>
      <td>{{$data[$i]->gender}}</td>
      @if($data[$i]->u_type ==3)
      <td>Coordinator</td>
      @else
      <td>Student</td>
      @endif
      <td>@if($data[$i]->status == 1)
        <form action="{{ route('fc.updateEventRegisterStatus', [0,$data[$i]->s_e_id,$data[$i]->u_id]) }}" method="post" style="display: inline;">
          {{csrf_field()}}
          <button type="submit" class="btn btn-success btn-sm btn-icon icon-left"><i class="entypo-check"></i>Active</button>
        </form>
        @elseif($data[$i]->status == 0)
        <form action="{{ route('fc.updateEventRegisterStatus', [1,$data[$i]->s_e_id,$data[$i]->u_id]) }}" method="post" style="display: inline;">
          {{csrf_field()}}
          <button type="submit" class="btn btn-danger btn-sm btn-icon icon-left"><i class="entypo-cancel"></i>Deactive</button>
        </form>
        @endif
      </td>
      <td class="col-md-2">
        <form style="display: inline;">
          <a href="javascript:;" id="{{$data[$i]->u_id}}_{{$data[$i]->f_name}}_{{$data[$i]->l_name}}_{{$data[$i]->email}}_{{$data[$i]->phone}}_{{$data[$i]->dob}}_{{$data[$i]->b_id}}_{{$data[$i]->b_name}}_{{$data[$i]->s_id}}_{{$data[$i]->s_name}}_{{$data[$i]->d_id}}_{{$data[$i]->d_name}}_{{$data[$i]->gender}}_{{$data[$i]->u_type}}" onclick="openmodal(this.id);" class="btn btn-default btn-sm btn-icon icon-left"><i class="entypo-pencil"></i>Edit</a>
        </form> &nbsp; &nbsp;
      </td>
      </tr>
      @endfor
  </tbody>
  <tfoot>
    <tr>
      <th></th>
      <th>First Name</th>
      <th>Last Name</th>
      <th>Email</th>
      <th>Phone</th>
      <th>Branch</th>
      <th>Stream</th>
      <th>Division</th>
      <th>Gender</th>
      <th>User Type</th>
      <th></th>
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

<div class="modal fade" id="modal-6">
  <form method="post" id="updateUser" action="{{route('fc.updateuser')}}">
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
                <input type="text" disabled class="form-control" name="f_name" id="f_name_field" placeholder="First Name" />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="field-2" class="control-label">Last Name</label>
                <input type="text" disabled  class="form-control" name="l_name" id="l_name_field" placeholder="Last Name" />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="field-2" class="control-label">Email</label>
                <input type="email" disabled class="form-control" name="email" id="email_field" placeholder="Email" />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="field-2" class="control-label">Phone</label>
                <input type="tel" disabled  class="form-control" name="phone" id="phone_field" placeholder="Phone" />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="field-2" class="control-label">Birth Date</label>
                <input type="date" disabled class="form-control" name="dob" id="dob_field" />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="field-1" class="control-label">Branch Name</label>
                <select disabled name="b_id" id="b_id_field" style="position: static;" class="form-control" data-placeholder="Select one Branch...">
                  <option id="b_id_val" value=""></option>
                  @for($i = 0; $i < count($branch); $i++) <option value="{{$branch[$i]->b_id}}">{{$branch[$i]->b_name}}</option>
                    @endfor
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="field-1" class="control-label">Branch Name</label>
                <select disabled name="s_id" id="s_id_field" style="position: static;" class="form-control" data-placeholder="Select one Branch...">
                  <option id="s_id_val" value=""></option>
                  @for($i = 0; $i < count($stream); $i++) <option value="{{$stream[$i]->s_id}}">{{$stream[$i]->s_name}}</option>
                    @endfor
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="field-1" class="control-label">Branch Name</label>
                <select disabled name="d_id" id="d_id_field" style="position: static;" class="form-control" data-placeholder="Select one Branch...">
                  <option id="d_id_val" value=""></option>
                  @for($i = 0; $i < count($division); $i++) <option value="{{$division[$i]->d_id}}">{{$division[$i]->d_name}}</option>
                    @endfor
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <input disabled type="hidden" name="gender_hidden" value="" id="gender_hidden" />
                <label for="field-1" class="control-label">Gender</label><br />
                &nbsp;
                <input disabled type="radio" name="gender" value="male" id="male_field">Male
                &nbsp;
                <input  disabled type="radio" name="gender" value="female" id="female_field">Female
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="field-1" class="control-label">User Type</label>
                <select name="u_type" id="u_type_field" style="position: static;" class="form-control" data-placeholder="Select one Branch...">
                  <option id="u_type_val" value=""></option>
                  <option value="0">Student</option>
                  <option value="3">Coordinator</option>
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

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

<script>
  $("select[name='b_id']").change(function() {
    $("#s_id_field").html('');
    var branch = $(this).val();
    var token = $("input[name='_token']").val();
    $.ajax({
      url: "<?php echo route('ajaxbranch') ?>",
      method: 'POST',
      data: {
        b_id: branch,
        _token: token
      },
      success: function(option) {
        for (i = 0; i < option.option.length; i++) {
          $("#s_id_field").append(`<option value="${option.option[i].s_id}">${option.option[i].s_name} </option>`);
        }
      }
    });
  });
  $("select[name='s_id']").click(function() {
    $("#d_id_field").html('');
    var stream = $(this).val();
    var token = $("input[name='_token']").val();
    $.ajax({
      url: "<?php echo route('ajaxstream') ?>",
      method: 'POST',
      data: {
        s_id: stream,
        _token: token
      },
      success: function(option) {
        for (i = 0; i < option.option.length; i++) {
          $("#d_id_field").append(`<option value="${option.option[i].d_id}">${option.option[i].d_name} </option>`);
        }
      }
    });
  });
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