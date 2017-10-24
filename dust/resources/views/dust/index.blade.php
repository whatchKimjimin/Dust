@extends('master')

@section('head')



@endsection('head')

@section('content')

<div class="row" id="mainSection">
	<div id="back">
		<span>돌아가기</span>
	</div>
	<div class="col-md-6" id="map">
		<object type='image/svg+xml'></object>
		<?=file_get_contents('img/korea.svg')?>
	</div>
	<div class="col-md-6" id="dustList">
	<span class="label label-default">최근 관측일 : {{ $date }}</span>
	
	<table class="table table-hover">
		<thead>
			<tr>
				<th>관측장소</th>
				<th>상태</th>
				<th>농도</th>
				<th></th>	
			</tr>
		</thead>
		<tbody>
			<tr class="information">
				<td>좋음</td>
				<td>보통</td>
				<td>나쁨</td>
				<td>매우나쁨</td>
			</tr>
			@foreach($datas as $value) 
			<tr class="{{ $value->color }}">
				<td> {{ $value->name }} </td>
				<td> {{ $value->grade }} </td>
				<td>{{ $value->value }}</td>
				<td></td>
			</tr>
			@endforeach
		</tbody>
	</table>
	
	
</div>


<canvas id="myChart" style="display: none;"></canvas>
</div>

<div id="resultnav">
	<div>
		<span>표</span>
	</div>
	<div>
		<span>그<br>래<br>프</span>
	</div>
</div>


@endsection