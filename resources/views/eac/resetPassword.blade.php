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
	<style>
		.error {
			color: red !important;
		}
	</style>
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
	@if (session('error'))
	<div class="alert alert-danger alert-block">
		<button type="button" class="close" data-dismiss="alert">×</button>
		<strong>{{ Session::get('error') }}</strong>
	</div>
	@endif
	@if (session('success'))
	<div class="alert alert-success alert-block">
		<button type="button" class="close" data-dismiss="alert">×</button>
		<strong>{{ Session::get('success') }}</strong>
	</div>
	@endif
	<div class="login-container">
		<div class="login-container">
			<div class="login-form">
				<div class="login-content">
					<form id="resertPassFEC" method="post" action="{{route('resetPassword')}}">
						{{ csrf_field() }}
						<div class="form-forgotpassword-success"> <i class="entypo-check"></i>
							<h3>Change Your Passsword.</h3>
						</div>
						<div class="form-steps">
							<div class="step current" id="step-1">
								<div class="form-group">
									<div class="input-group" id="pass">
										<input type="hidden" class="form-control" name="email" value="{{Session::get('ForgotEacEmail')}}" />
										<div class="input-group-addon"> <i class="entypo-key"></i> </div>
										<input type="password" class="form-control" name="password" id="password" placeholder="New Password" data-mask="password" autocomplete="off" />
									</div>
								</div>
								<div class="form-group">
									<div class="input-group" id="cpass">
										<div class="input-group-addon"> <i class="entypo-key"></i> </div>
										<input type="password" class="form-control" name="confirmPassword" id="confirmPassword" placeholder="Confirm Password" data-mask="password" autocomplete="off" />
									</div>
								</div>
								<div class="form-group">
									<button type="submit" class="btn btn-info btn-block btn-login">
										Change Password<i class="entypo-right-open-mini"></i>
									</button>
								</div>
							</div>
						</div>
					</form>
				</div>
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
		<script src="{{ asset('backend/js/jquery-1.11.3.min.js') }}"></script>
		<script>
			$(document).ready(function() {
				$("#resertPassFEC").submit(function(e) {
					let password = $("#password").val();
					let confirmPassword = $("#confirmPassword").val();

					$(".error").remove();
					if (password == "") {
						e.preventDefault();
						$("#pass").after(
							'<span class="error">This field is required</span>'
						);
					} else if (password.length != 8) {
						e.preventDefault();
						$("#pass").after(
							'<span class="error">Password must be maximum 8 characters only.</span>'
						);
					}
					if (confirmPassword == "") {
						e.preventDefault();
						$("#cpass").after(
							'<span class="error">This field is required</span>'
						);
					} else if (confirmPassword.length != 8) {
						e.preventDefault();
						$("#cpass").after(
							'<span class="error">Confirm Password must be maximum 8 characters only.</span>'
						);
					} else if (password != confirmPassword) {
						e.preventDefault();
						$("#cpass").after(
							'<span class="error">Password and Confirm password must be same.</span>'
						);
					}
				});
			});
		</script>
		@yield('script')
</body>

</html>