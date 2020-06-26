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
  <link rel="stylesheet" href="{{ asset('backend/css/custom.css') }}" id="style-resource-8">
  <script src="{{ asset('backend/js/jquery-1.11.3.min.js') }}"></script>
  @yield('head')
</head>

<body class="page-body login-page login-form-fall">
  <script type="text/javascript">
    var baseurl = '../../index.html';
  </script>
  <div class="login-container">
    <div class="login-form">
      <div class="login-content">
        <div class="form-login-error">
          <h3>Invalid login</h3>
          <p>Enter <strong>demo</strong>/<strong>demo</strong> as login and password.</p>
        </div>
        @if (session('error'))
        <div class="alert alert-danger alert-block">
          <button type="button" class="close" data-dismiss="alert">×</button>
          <strong>{{ Session::get('error') }}</strong>
        </div>
        @endif
        <form method="post" action="/admin/authenticate">
          {{ csrf_field() }}
          <div class="form-group">
            <div class="input-group">
              <div class="input-group-addon"> <i class="entypo-user"></i> </div> <input type="text" class="form-control" name="username" id="username" placeholder="Username" autocomplete="off" />
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
              <div class="input-group-addon"> <i class="entypo-key"></i> </div> <input type="password" class="form-control" name="password" id="password" placeholder="Password" autocomplete="off" />
            </div>
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block btn-login"> <i class="entypo-login"></i>
              Login In
            </button>
          </div>
        </form>       
      </div>
    </div>

    <script src="{{ asset('backend/js/gsap/TweenMax.min.js') }}" id="script-resource-1"></script>
    <script src="{{ asset('backend/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js') }}" id="script-resource-2"></script>
    <script src="{{ asset('backend/js/bootstrap.js') }}" id="script-resource-3"></script>
    <script src="{{ asset('backend/js/joinable.js') }}" id="script-resource-4"></script>
    <script src="{{ asset('backend/js/resizeable.js') }}" id="script-resource-5"></script>
    <script src="{{ asset('backend/js/neon-api.js') }}" id="script-resource-6"></script>
    <script src="{{ asset('backend/js/cookies.min.js') }}" id="script-resource-7"></script>
    <script src="{{ asset('backend/js/jquery.validate.min.js') }}" id="script-resource-8"></script>
    <script src="{{ asset('backend/js/neon-login.js') }}" id="script-resource-9"></script>
    <!-- JavaScripts initializations and stuff -->
    <script src="{{ asset('backend/js/neon-custom.js') }}" id="script-resource-10"></script> <!-- Demo Settings -->
    <script src="{{ asset('backend/js/neon-demo.js') }}" id="script-resource-11"></script>
    <script src="{{ asset('backend/js/neon-skins.js') }}" id="script-resource-12"></script>
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