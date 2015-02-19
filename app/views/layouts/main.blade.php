<!doctype html>
<html lang='en'>
<head>
	<title>Little Helper Chainsaws</title>
	{{ HTML::script('js/scrollTo.js'); }}
	{{ HTML::style('css/normalize.css'); }}
	{{ HTML::style('css/foundation.css'); }}
	{{ HTML::style('css/foundation.min.css'); }}
	{{HTML::style('css/app.css'); }}
	<link href='http://fonts.googleapis.com/css?family=Belleza' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Bevan' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Metamorphous' rel='stylesheet' type='text/css'>
</head>
<body>

<nav>
	<ul>
	  <li><a href="/">HOME</a></li>
	  <li><a href="/buy">BUY NOW</a></li>
	  <li><a href="/contact">CONTACT</a></li>
	  <li><a href="/about">ABOUT</a></li>
	</ul>
</nav>
	<div class="right">
		<h1>Little Helper Chainsaws</h1>
		@yield('content')
	
		<footer>
			<ul>
			  <li><a href="/">HOME</a></li>
			  <li><a href="/buy">BUY NOW</a></li>
			  <li><a href="/contact">CONTACT</a></li>
			  <li><a href="/about">ABOUT</a></li>
			</ul>
			<div>Copyright&copy;Cloud Edwards <?php echo date('Y'); ?></div>
		</footer>

	</div>





 {{HTML::script('js/vendor/jquery.js') }}
 {{HTML::script('js/foundation.min.js') }}
    <script>
      $(document).foundation();
    </script>

</body>
</html>