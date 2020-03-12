<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>LogIn</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css">
    <script src="main.js"></script>
    <?php include 'bootlinks.php';?>
<style>
.error{
  color:red;
}
        :root {
  --input-padding-x: 1.5rem;
  --input-padding-y: .75rem;
}


.card-signin {
  border: 0;
  border-radius: 1rem;
  box-shadow: 0 0.5rem 1rem 0 rgba(0, 0, 0, 0.1);
}

.card-signin .card-title {
  margin-bottom: 2rem;
  font-weight: 300;
  font-size: 1.5rem;
}

.card-signin .card-body {
  padding: 2rem;
}

.form-signin {
  width: 100%;
}

.form-signin .btn {
  font-size: 80%;
  border-radius: 5rem;
  letter-spacing: .1rem;
  font-weight: bold;
  padding: 1rem;
  transition: all 0.2s;
}

.form-label-group {
  position: relative;
  margin-bottom: 1rem;
}

.form-label-group input {
  height: auto;
  border-radius: 2rem;
}

.form-label-group>input,
.form-label-group>label {
  padding: var(--input-padding-y) var(--input-padding-x);
}

.form-label-group>label {
  position: absolute;
  top: 0;
  left: 0;
  display: block;
  width: 100%;
  margin-bottom: 0;
  /* Override default `<label>` margin */
  line-height: 1.5;
  color: #495057;
  border: 1px solid transparent;
  border-radius: .25rem;
  transition: all .1s ease-in-out;
}

.form-label-group input::-webkit-input-placeholder {
  color: transparent;
}

.form-label-group input:-ms-input-placeholder {
  color: transparent;
}

.form-label-group input::-ms-input-placeholder {
  color: transparent;
}

.form-label-group input::-moz-placeholder {
  color: transparent;
}

.form-label-group input::placeholder {
  color: transparent;
}

.form-label-group input:not(:placeholder-shown) {
  padding-top: calc(var(--input-padding-y) + var(--input-padding-y) * (2 / 3));
  padding-bottom: calc(var(--input-padding-y) / 3);
}

.form-label-group input:not(:placeholder-shown)~label {
  padding-top: calc(var(--input-padding-y) / 3);
  padding-bottom: calc(var(--input-padding-y) / 3);
  font-size: 12px;
  color: #777;
}

.btn-google {
  color: white;
  background-color: #ea4335;
}

.btn-facebook {
  color: white;
  background-color: #3b5998;
}

/* Fallback for Edge
-------------------------------------------------- */

@supports (-ms-ime-align: auto) {
  .form-label-group>label {
    display: none;
  }
  .form-label-group input::-ms-input-placeholder {
    color: #777;
  }
}

        </style>
        @if (session('error'))
        <div class="alert alert-danger alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ Session::get('danger') }}</strong>
        </div>
        @endif
</head>
<br><br><center>
    <body>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header bg-primary"><h3>Reset Password<h3></div><br>
                <div class="card-block">
                    <div class="container">
                      <form  method="POST" id="reset_password" action="/student/reset_password">
                          {{ csrf_field() }}
                          <input type="hidden" name="email" value="{{ session('email') }}"><br>

                          <input type="password" id="password" name="password" class="form-control" placeholder="Password" /> <br>
                        
                          <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="Confirm Password" /><br>

                          <button type="submit" name="submit" class="btn btn-success">Submit</button><br><br>
                      </form>
                  </div>
              </div>
          </div>
      </div>
    </body></center>
</html>
<script>
$(document).ready(function() {
    $("#reset_password").submit(function(e) {
      let password = $("#password").val();
      let confirm_password = $("#confirm_password").val();
      $(".error").remove();
      // return false;
      if (password == "") {
        e.preventDefault();
        $("#password").after(
          '<span class="error">This field is required</span>'
        );
      }else if(password.length < 8)
      {
          e.preventDefault();
          $("#password").after(
          '<span class="error">password must be 8 character long</span>'
        );
      }
      if(confirm_password == ""){
        e.preventDefault();
        $("#confirm_password").after(
          '<span class="error">This field is required</span>'
        );
      }
      if(password != confirm_password)
      {
        e.preventDefault();
        $("#confirm_password").after(
          '<span class="error">Password and Confirm Password not match</span>'
        );
      }  
    });
  });
</script>