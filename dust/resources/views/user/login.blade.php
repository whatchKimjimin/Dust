@extends('master')

@section('content')
<h2>로그인</h2>
<hr>
<form class="form-horizontal" method="post">
	{{ csrf_field() }}
	@if( session()->has('success') )
		<div class="alert alert-success">
			<strong>{{ session()->get('success') }}</strong>
		</div>
	@endif

	@if( session()->has('err') )
		<div class="alert alert-danger">
			<strong>{{ session()->get('err') }}</strong>
		</div>
	@endif

	@if($errors->has('useremail'))
		<div class="alert alert-warning">
			<strong>
				{{ $errors->first('useremail',':message')  }}
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

	<div class="form-group">
		<label class="control-label col-sm-2" for="email">이메일:</label>
		<div class="col-sm-10">
			<input type="email" class="form-control" id="email" placeholder="아이디" name="useremail" required value="{{ old('useremail') }}">
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2" for="pwd">비밀번호:</label>
		<div class="col-sm-10">          
			<input type="password" class="form-control" id="pwd" placeholder="비밀번호" name="userpass" required>
		</div>
	</div>
	<div class="form-group">        
		<div class="col-sm-offset-2 col-sm-10">
			<button type="submit" class="btn btn-default">확인</button>
		</div>
	</div>
</form>
@endsection