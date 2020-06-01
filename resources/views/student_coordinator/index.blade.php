<!DOCTYPE html>
<html lang="en">
<head>
  <title> @yield('title')</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-sm bg-primary navbar-dark">
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Events
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="/student_coordinator/events">All Events</a>
              <a class="dropdown-item" href="/student_coordinator/registered_events">Registered Events</a>
              <div class="dropdown-divider"></div>              
            </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Welcome {{ session('user')}}
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="/student_coordinator/profile">Profile</a>
              <a class="dropdown-item" href="/student_coordinator/change_password">Change Password</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="/student/logout">Logout</a>
            </div>
          </li>
          &nbsp;&nbsp;&nbsp;
            <a href="/student_coordinator/add_expence"><button name="expense" id="expense"  class="btn btn-success">Add expense</button></a> &nbsp;&nbsp;&nbsp;
            <a href="/student_coordinator/take_attendance"><button name="expense" id="attendance" class="btn btn-danger">Attendance</button></a>
        </ul>
        <h3><font color="white">Student Coordinator Panel</font></h3>
      </div>
</nav>
<br>
<h1 style="Text-align:center">@yield('head')</h1><br>
@yield('content')
</body>
</html>