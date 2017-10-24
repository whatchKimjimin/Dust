@extends('master')


@section('content')
<div class="panel panel-default" id="favorite">
	<div class="panel-heading"><b>관심 지역 설정</b><span class="pull-right label label-default">(끌어서 사용하세요.)</span></div>
	<div class="panel-body">
		<div class="col-md-6">
			<center>
				<b>선택안된 지역</b>
			</center>
			<div class="col-md-6" id="nullCheckDropzone">
				@foreach($notCheck as $row)
				<li data="{{ $row->id }}">{{$row -> name}}</li>
				@endforeach
			</div>
		</div>
		<div class="col-md-6">
			<center>
				<b>선택된 지역</b>
			</center>
			<div class="col-md-6" id="CheckDropzone">
				@foreach($check as $row)
				<li data="{{ $row->id }}">{{$row -> name}}</li>
				@endforeach
			</div>
		</div>
		<button class="pull-right btn btn-success">저장</button>
	</div>
</div>

@endsection('content')