<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">


	@stack('styles')

	
</head>
<body>
@yield('content')
<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
@stack('scripts')
</body>
</html>