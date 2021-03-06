<!doctype html>
<html lang='en'>
<head>
	<title>Little Helper Chainsaws</title>
	{{ HTML::style('css/normalize.css'); }}

	{{HTML::style('css/app.css'); }}
	{{HTML::style('css/main.css'); }}
	{{HTML::style('css/forms.css'); }}
	{{HTML::style('css/nav.css'); }}
	{{HTML::style('css/responsive.css'); }}


	<meta charset="utf-8">
	<meta name="publishable-key" content="{{Config::get('stripe.publishable-key')}}">
	<!-- Favicon -->
	<link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
	<!-- GOOGLE FONTS -->
	<link href='http://fonts.googleapis.com/css?family=Belleza' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Bevan' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Metamorphous' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>

	<!-- JS STRIPE <script src="https://js.stripe.com/v2/"></script>  -->
	
</head>
<body>

<div class="wrapper">

<h1>Little Helper Chainsaws</h1>

<div class="nav">		
	<nav>
		<ul>
		  <li><a href="/">HOME</a></li>
		  <li><a href="/buy">ORDERING</a></li>
		  <li><a href="/contact">CONTACT</a></li>
		</ul>
	</nav>
</div>


<div class="content">

		@if (Session::has('message'))
            <div class="alert-box">
                {{{ Session::get('message') }}}
            </div>
        @endif

		@yield('content')

</div>

<div class="footer">
		<footer>
			<ul>
			  <li><a href="/">HOME</a></li>
			  <li><a href="/buy">BUY NOW</a></li>
			  <li><a href="/contact">CONTACT</a></li>
			 
			</ul>
			<div>Copyright&copy;Cloud Edwards <?php echo date('Y'); ?></div>
		</footer>
</div>
</div>

	<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
 	{{HTML::script('js/foundation.min.js') }}
	{{ HTML::script('js/jquery-scrollTo/jquery.scrollTo.js'); }}

	
    <script>
      $(document).foundation();
    </script>
	
	
    @yield('footer')

</body>
</html>