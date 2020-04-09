<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="description" content="Event Management System" />

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">  
  <link rel="icon" href="{{ asset('backend/images/favicon.ico') }}">
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-141030632-1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('config', 'UA-141030632-1', {
      "groups": "laborator_analytics",
      "link_attribution": true,
      "linker": {
        "accept_incoming": true,
        "domains": ["laborator.co", "kaliumtheme.com", "oxygentheme.com", "neontheme.com", "themeforest.net", "laborator.ticksy.com"]
      }
    });
  </script>
  <title>Event Management System</title>
  <link rel="stylesheet" href="{{ asset('backend/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css') }}" id="style-resource-1">
  <link rel="stylesheet" href="{{ asset('backend/css/font-icons/entypo/css/entypo.css') }}" id="style-resource-2">
  <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic" id="style-resource-3">
  <link rel="stylesheet" href="{{ asset('backend/css/bootstrap.css') }}" id="style-resource-4">
  <link rel="stylesheet" href="{{ asset('backend/css/neon-core.css') }}" id="style-resource-5">
  <link rel="stylesheet" href="{{ asset('backend/css/neon-theme.css') }}" id="style-resource-6">
  <link rel="stylesheet" href="{{ asset('backend/css/neon-forms.css') }}" id="style-resource-7">
  <link rel="stylesheet" href="{{ asset('backend/css/custom.css') }}" id=" style-resource-8">
  <script src="{{ asset('backend/js/jquery-1.11.3.min.js') }}"></script>
  @yield('head')
</head>

<body class="page-body page-fade">
  <div class="page-container">
    <div class="sidebar-menu">
      <div class="sidebar-menu-inner">
        @include('fclayout.header')
        @include('fclayout.sidebar')
      </div>
    </div>
    <div class="main-content">
      <div class="row">
        <!-- Profile Info and Notifications -->
        <div class="col-md-6 col-sm-8 clearfix">
          <ul class="user-info pull-left pull-none-xsm">
            <!-- Profile Info -->
            <li class="profile-info dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <img src="{{ asset('backend/images/thumb-1%402x.png') }}" alt="" class="img-circle" width="44" />
                Admin
              </a>
              <ul class="dropdown-menu">
                <!-- Reverse Caret -->
                <li class="caret"></li> <!-- Profile sub-links -->
                <li> <a href="#"> <i class="entypo-user"></i>
                    Edit Profile
                  </a>
                </li>
              </ul>
            </li>
          </ul>
        </div> <!-- Raw Links -->
        <div class="col-md-6 col-sm-4 clearfix hidden-xs">
          <ul class="list-inline links-list pull-right">
            <li> <a href="/fc/logout">
                Log Out <i class="entypo-logout right"></i> </a> </li>
          </ul>
        </div>
      </div>
      <hr />
      @yield('content')
      @include('fclayout.footer')
    </div>
  </div>

  <link rel="stylesheet" href="{{ asset('backend/js/jvectormap/jquery-jvectormap-1.2.2.css') }}" id="style-resource-1">
  <link rel="stylesheet" href="{{ asset('backend/js/datatables/datatables.css') }}" id="style-resource-1">
  <link rel="stylesheet" href="{{ asset('backend/js/rickshaw/rickshaw.min.css') }}" id="style-resource-2">
  <link rel="stylesheet" href="{{ asset('backend/js/select2/select2-bootstrap.css') }}" id="style-resource-1">
  <link rel="stylesheet" href="{{ asset('backend/js/select2/select2.css') }}" id="style-resource-2">
  <link rel="stylesheet" href="{{ asset('backend/js/selectboxit/jquery.selectBoxIt.css') }}" id="style-resource-3">

  <script src="{{ asset('backend/js/datatables/datatables.js') }}" id="script-resource-8"></script>
  <script src="{{ asset('backend/js/select2/select2.min.js')}}" id="script-resource-9"></script>
  <script src="{{ asset('backend/js/selectboxit/jquery.selectBoxIt.min.js') }}" id="script-resource-11"></script>
  <script src="{{ asset('backend/js/gsap/TweenMax.min.js') }}" id="script-resource-1"></script>
  <script src="{{ asset('backend/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js') }}" id="script-resource-2"></script>
  <script src="{{ asset('backend/js/bootstrap.js') }}" id="script-resource-3"></script>
  <script src="{{ asset('backend/js/joinable.js') }}" id="script-resource-4"></script>
  <script src="{{ asset('backend/js/resizeable.js') }}" id="script-resource-5"></script>
  <script src="{{ asset('backend/js/neon-api.js') }}" id="script-resource-6"></script>
  <script src="{{ asset('backend/js/cookies.min.js') }}" id="script-resource-7"></script>
  <script src="{{ asset('backend/js/jvectormap/jquery-jvectormap-1.2.2.min.js') }}" id="script-resource-8"></script>
  <script src="{{ asset('backend/js/jvectormap/jquery-jvectormap-europe-merc-en.js') }}" id="script-resource-9"></script>
  <script src="{{ asset('backend/js/jquery.sparkline.min.js') }}" id="script-resource-10"></script>
  <script src="{{ asset('backend/js/rickshaw/vendor/d3.v3.js') }}" id="script-resource-11"></script>
  <script src="{{ asset('backend/js/rickshaw/rickshaw.min.js') }}" id="script-resource-12"></script>
  <script src="{{ asset('backend/js/raphael-min.js') }}" id="script-resource-13"></script>
  <script src="{{ asset('backend/js/morris.min.js') }}" id="script-resource-14"></script>
  <script src="{{ asset('backend/js/toastr.js') }}" id="script-resource-15"></script>
  <script src="{{ asset('backend/js/neon-chat.js') }}" id="script-resource-16"></script>
  <!-- JavaScripts initializations and stuff -->
  <script src="{{ asset('backend/js/neon-custom.js') }}" id="script-resource-17"></script> <!-- Demo Settings -->
  <script src="{{ asset('backend/js/neon-demo.js') }}" id="script-resource-18"></script>
  <script src="{{ asset('backend/js/neon-skins.js') }}" id="script-resource-19"></script>
  <script type="text/javascript">
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-28991003-7']);
    _gaq.push(['_setDomainName', 'demo.neontheme.com']);
    _gaq.push(['_trackPageview']);
    (function() {
      var ga = document.createElement('script');
      ga.type = 'text/javascript';
      ga.async = true;
      ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
      var s = document.getElementsByTagName('script')[0];
      s.parentNode.insertBefore(ga, s);
    })();
  </script>
  @yield('script')
</body>

</html>