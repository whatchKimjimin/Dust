@extends('master')

@section('content')
<h2>회원가입</h2>
<hr>
<form class="form-horizontal" method="post">
	{!! csrf_field() !!}

	<!-- err -->
	@if($errors->has('useremail'))
		<div class="alert alert-warning">
			<strong>
				{{ $errors->first('useremail',':message')  }}
			</strong>
		</div>
	@endif
	@if($errors->has('username'))
		<div class="alert alert-warning">
			<strong>
				{{ $errors->first('username',':message')  }}
			</strong>
		</div>
	@endif
	@if($errors->has('userpass'))
		<div class="alert alert-warning">
			<strong>
				{{ $errors->first('userpass',':message')  }}
			</strong>
		</div>
	@endif
	@if( session()->has('err') )
	<div class="alert alert-danger">
		<strong>
			{{ session()->get('err') }}
		</strong>
	</div>
	@endif

	<div class="form-group">
		<label class="control-label col-sm-2" for="email">이메일:</label>
		<div class="col-sm-10">
			<input type="email" class="form-control" id="email" placeholder="예) dust@gmail.com" name="useremail" required value="{{ old('useremail') }}">
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2" for="name">이름:</label>
		<div class="col-sm-10">          
			<input type="text" class="form-control" id="name" placeholder="예) 홍길동" name="username" required value="{{ old('username') }}">
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2" for="pwd">비밀번호:</label>
		<div class="col-sm-10">          
			<input type="password" class="form-control" id="pwd" placeholder="8글자 이상" name="userpass" required value="{{ old('userpass') }}">
		</div>
	</div>
	<div class="form-group">        
		<div class="col-sm-offset-2 col-sm-10">
			<button type="submit" class="btn btn-default">확인</button>
		</div>
	</div>
</form>

@endsection