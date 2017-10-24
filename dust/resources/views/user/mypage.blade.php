@extends('master')


@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		<h3>마이 페이지</h3>
	</div>
	<div class="panel-body">

		<!-- 관심 지역 -->
		<b>관심 지역 <a href="/mypage/favorite"><span class="glyphicon glyphicon-pencil"></span> 수정</a></b>
		<p><small>관심지역을 설정하면 다양한 기능을 사용할수 있습니다.</small></p>
		@foreach($favorites as $row)
			<div class="chip">{{ $row->name }}</div>
		@endforeach
		
		

		<hr>
	</div>
</div>
</div>	
@endsection('content')

