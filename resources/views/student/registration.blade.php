<html>
    <head>
        <title>Registration</title>

        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <?php include('bootlinks.php') ?>
        <style>
        .error {
    color: red;
  }

        .register{
    background: -webkit-linear-gradient(left, #3931af, #00c6ff);
    margin-top: 1%;
    padding: 3%;
}
.register-left{
    text-align: center;
    color: #fff;
    margin-top: 4%;
}
.register-left input{
    border: none;
    border-radius: 1.5rem;
    padding: 2%;
    width: 60%;
    background: #f8f9fa;
    font-weight: bold;
    color: #383d41;
    margin-top: 30%;
    margin-bottom: 3%;
    cursor: pointer;
}
.register-right{
    background: #f8f9fa;
    border-top-left-radius: 10% 50%;
    border-bottom-left-radius: 10% 50%;
}
.register-left img{
    margin-top: 15%;
    margin-bottom: 5%;
    width: 25%;
    -webkit-animation: mover 2s infinite  alternate;
    animation: mover 1s infinite  alternate;
}
@-webkit-keyframes mover {
    0% { transform: translateY(0); }
    100% { transform: translateY(-20px); }
}
@keyframes mover {
    0% { transform: translateY(0); }
    100% { transform: translateY(-20px); }
}
.register-left p{
    font-weight: lighter;
    padding: 12%;
    margin-top: -9%;
}
.register .register-form{
    padding: 10%;
    margin-top: 10%;
}
.btnRegister{
    float: right;
    margin-top: 10%;
    border: none;
    border-radius: 1.5rem;
    padding: 2%;
    background: #0062cc;
    color: #fff;
    font-weight: 600;
    width: 50%;
    cursor: pointer;
}
.register .nav-tabs{
    margin-top: 3%;
    border: none;
    background: #0062cc;
    border-radius: 1.5rem;
    width: 28%;
    float: right;
}
.register .nav-tabs .nav-link{
    padding: 2%;
    height: 34px;
    font-weight: 600;
    color: #fff;
    border-top-right-radius: 1.5rem;
    border-bottom-right-radius: 1.5rem;
}
.register .nav-tabs .nav-link:hover{
    border: none;
}
.register .nav-tabs .nav-link.active{
    width: 100px;
    color: #0062cc;
    border: 2px solid #0062cc;
    border-top-left-radius: 1.5rem;
    border-bottom-left-radius: 1.5rem;
}
.register-heading{
    text-align: center;
    margin-top: 8%;
    margin-bottom: -15%;
    color: #495057;
}
</style>
@if (session('success'))
<div class="alert alert-success alert-block">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <strong>{{ Session::get('success') }}</strong>
</div>
@endif 
@if (session('error'))
<div class="alert alert-success alert-block">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <strong>{{ Session::get('error') }}</strong>
</div>
@endif
</head>

<body>

<div class="container register">
        <div class="row">
            <div class="col-md-3 register-left">
                <img src="https://image.ibb.co/n7oTvU/logo_white.png" alt=""/>
                <h3>Welcome</h3>
                <p><b> If you already registerd go for login</b></p>
                <a href="/student/login"><input type="submit" name="" value="Login"/></a><br/>

            </div>
            <div class="col-md-9 register-right">
            <form method="POST" id="registration" enctype="multipart/form-data" action="/student/register">
            {{ csrf_field() }}
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <h3 class="register-heading">Student Registration</h3>
                        <div class="row register-form">
                            <div class="col-md-6">
                            <input type="hidden" name="u_type" value="0" />                                <div class="form-group">
                                    <input type="text" name="f_name" id="f_name" class="form-control" placeholder="First Name " />
                                </div>
                                <div class="form-group">
                                    <input type="text" name="l_name" id="l_name" class="form-control" placeholder="Last Name " />
                                </div>
                                <div class="form-group">
                                    <input type="email" name="email" id="email" class="form-control" placeholder="Your Email " />
                                </div>
                                <div class="form-group">
                                    <input type="number" name="phone" id="phone" class="form-control" placeholder="Mobile No " />
                                </div>  
                                <div class="form-group">
                                    <input type="password" name="password" id="password" class="form-control"  placeholder="Your Password " />
                                </div>
                                <div class="form-group">
                                    <input type="password" name="c_password" id="c_password" class="form-control"  placeholder="Confirm Password " />
                                </div>
                                <!---                                                           
                                <div class="form-group">
                                    <div class="maxl">
                                        <label class="radio inline"> 
                                            <input type="radio" name="gender" value="male" checked>
                                            <span> Male </span> 
                                        </label>
                                        <label class="radio inline"> 
                                            <input type="radio" name="gender" value="female">
                                            <span>Female </span> 
                                        </label>
                                    </div>
                                </div>--->
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="number" name="enrollment" id="enrollment" class="form-control" placeholder="Your Enrollment Number " />
                                </div>
                                <div class="form-group">
                                    <select name="gender" id="gender" class="form-control">
                                       <option value="Select Gender">Select Gender</option>
                                       <option value="M">Male</option>
                                       <option value="F">Female</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input type="date" name="dob" id="dob" class="form-control" placeholder="Your DOB" />
                                </div>                                
                                <div class="form-group">
                                    <select name="branch" id="branch" class="form-control">
                                    <option value="Select Branch">Select Branch</option>
                                    @foreach ($branches as $branch)
                                       <option value="{{$branch->b_id}}">{{$branch->b_name}}</option>
                                    @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select name="stream" id="stream" class="form-control">
                                    <option value="Select Stream">Select Stream</option>                                 
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select name="division" id="division" class="form-control">
                                    <option value="Select Division">Select Division</option>
                                    </select>
                                </div>
                                <input type="submit" class="btnRegister"  value="Register"/>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
    </body>
    <script>
  $(document).ready(function() {
    $("#registration").submit(function(e) {
      let f_name = $("#f_name").val();
      let l_name = $("#l_name").val();
      let email = $("#email").val();
      let phone = $("#phone").val();
      let password = $("#password").val();
      let c_password = $("#c_password").val();
      let enrollment = $("#enrollment").val();
      let gender = $("#gender").val();
      let dob = $("#dob").val();
      let branch = $("#branch").val();
      let stream = $("#stream").val();      
      let division = $("#division").val();

      $(".error").remove();
      // return false;
      if (f_name == "") {
        e.preventDefault();
        $("#f_name").after(
          '<span class="error">This field is required</span>'
        );
      }else if (!/^[a-zA-Z]/.test(f_name) || f_name == "") {
        e.preventDefault();
        $("#f_name").after(
          '<span class="error">Please Enter Alphabets Only</span>'
        );
      } else if (f_name.length > 15) {
        e.preventDefault();
        $("#f_name").after(
          '<span class="error">first name should maximum 15 characters only.</span>'
        );
      }
      if (l_name == "") {
        e.preventDefault();
        $("#l_name").after(
          '<span class="error">This field is required</span>'
        );
      }else if (!/^[a-zA-Z]/.test(l_name) || l_name == "") {
        e.preventDefault();
        $("#l_name").after(
          '<span class="error">Please Enter Alphabets Only</span>'
        );
      } else if (l_name.length > 15) {
        e.preventDefault();
        $("#l_name").after(
          '<span class="error">last name should maximum 15 characters only.</span>'
        );
      }
      if (email == "") {
        e.preventDefault();
        $("#email").after(
          '<span class="error">This field is required</span>'
        );
      }
      if (phone == "") {
        e.preventDefault();
        $("#phone").after(
          '<span class="error">This field is required</span>'
        );
      }else if (phone.length < 10) {
        e.preventDefault();
        $("#phone").after(
          '<span class="error">Mobile Number Should be 10 numbes only</span>'
        );
      }
      else if (phone.length > 10) {
        e.preventDefault();
        $("#phone").after(
          '<span class="error">Mobile Number Should be 10 numbes only</span>'
        );
      }
      if (password == "") {
        e.preventDefault();
        $("#password").after(
          '<span class="error">This field is required</span>'
        );
      }else if(password.length < 8){
        e.preventDefault();
        $("#password").after(
          '<span class="error">password must be 8 character long</span>'
        ); 
      }
      if (c_password == "") {
        e.preventDefault();
        $("#c_password").after(
          '<span class="error">This field is required</span>'
        );
      }else if(password != c_password){
        e.preventDefault();
        $("#c_password").after(
          '<span class="error">Confirm password must be same as password</span>'
        ); 
      }
      if (enrollment == "") {
        e.preventDefault();
        $("#enrollment").after(
          '<span class="error">This field is required</span>'
        );
      }else if (enrollment.length < 12) {
        e.preventDefault();
        $("#enrollment").after(
          '<span class="error">Enrollment Number Should be 12 digits</span>'
        );
      }else if (enrollment.length > 12) {
        e.preventDefault();
        $("#enrollment").after(
          '<span class="error">Enrollment Number Should be 12 digits</span>'
        );
      }
      if (gender == "Select Gender") {
        e.preventDefault();
        $("#gender").after(
          '<span class="error">Please Select Gender</span>'
        );
      }
      if (dob == "") {
        e.preventDefault();
        $("#dob").after(
          '<span class="error">Please Select Date of Birth</span>'
        );
      }
      if (branch == "Select Branch") {
        e.preventDefault();
        $("#branch").after(
          '<span class="error">Please Select branch</span>'
        );
      }
      if (stream === null) {
        e.preventDefault();
        $("#stream").after(
          '<span class="error">Please Select Stream</span>'
        );
      }else if(stream == "Select Stream"){
        e.preventDefault();
        $("#stream").after(
          '<span class="error">Please Select Stream</span>'
        );
      }
      if (division === null) {
        e.preventDefault();
        $("#division").after(
          '<span class="error">Please Select Division</span>'
        );
      }else if(division == "Select Division"){
        e.preventDefault();
        $("#division").after(
          '<span class="error">Please Select Division</span>'
        );
      }
      
    });
  });
</script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script>
  $("select[name='branch']").change(function () {
    $("#stream").html('');
    var branch = $(this).val();
    var token = $("input[name='_token']").val();
    $.ajax({
      url: "<?php echo route('ajaxbranch') ?>",
      method: 'POST',
      data: { b_id: branch, _token: token },
      success: function (option) {       
        for(i=0;i<option.option.length;i++){          
          $("#stream").append(`<option value="${option.option[i].s_id}">${option.option[i].s_name} </option>`);
        }
      }
    });
  });
  $("select[name='stream']").click(function () {
    $("#division").html('');
    var stream = $(this).val();
    var token = $("input[name='_token']").val();
    $.ajax({
      url: "<?php echo route('ajaxstream') ?>",
      method: 'POST',
      data: { s_id: stream, _token: token },
      success: function (option) {        
        for(i=0;i<option.option.length;i++){          
          $("#division").append(`<option value="${option.option[i].d_id}">${option.option[i].d_name} </option>`);
        }
      }
    });
  });
</script>
</html>