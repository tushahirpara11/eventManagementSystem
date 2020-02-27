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
          <li class="nav-item">
            <a class="nav-link" href="/"></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/"></a>
          </li>
          <li class="nav-item">
                <a class="nav-link" href="/"></a>
          </li>
          
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Welcome {{ session('user')}}
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="/">Profile</a>
              <a class="dropdown-item" href="/">Change Password</a>
              <div class="dropdown-divider"></div>              
            </div>
          </li>
        </ul>
        <h3><font color="white">Student Panel</font></h3>
      </div>
</nav>
<br>
<h1 style="Text-align:center">@yield('head')</h1><br>
@yield('content')
</body>
</html>