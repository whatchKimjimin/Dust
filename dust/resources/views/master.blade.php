<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Document</title>
	<link rel="stylesheet" href="/css/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="/css/css.css">
	@yield('head')
</head>
<body>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand" href="/">미세먼지 연구소</a>
			</div>
			<ul class="nav navbar-nav">
				<li class="{{ Request::is('/') ? 'active' : ''}}"><a href="/">홈</a></li>
				<!-- <li><a href="/graph">그래프</a></li> -->
				<!-- <li><a href="/predict">예측</a></li> -->
				<li class="{{ Request::is('dustslide/*') ? 'active' : ''}}"><a href="/dustslide/yesterday">미세먼지 슬라이드</a></li>
			</ul>
			
			@if( !session()->has('loginData'))
			<ul class="nav navbar-nav navbar-right">
				<li><a href="/joinuser"><span class="glyphicon glyphicon-user"></span> 회원가입</a></li>
				<li><a href="/loginuser"><span class="glyphicon glyphicon-log-in"></span> 로그인</a></li>
			</ul>
			@else
			<ul class="nav navbar-nav navbar-right">
				<li><a><span class="glyphicon glyphicon-user"></span> {{ session('loginData')->username }}님</a></li>
				<li><a href="/mypage"><span class="glyphicon glyphicon-home"></span> 마이페이지</a></li>
				<li><a href="/logout"><span class="glyphicon glyphicon-log-in"></span> 로그아웃</a></li>
			</ul>
			
			@endif
		</div>
	</nav>
	
	<!-- container -->
	<div class="container">
		@yield('content')
	</div>
	
	<!-- script -->

	<script src="/js/jquery-1.12.3.min.js"></script>
	<script src="/js/jquery-ui.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
	<script src="/js/bootstrap.min.js"></script>
	<script src="/js/js.js"></script>
	@yield('script')
</body>
</html>