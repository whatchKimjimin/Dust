@extends('master')

@section('content')
<div class="panel panel-default" id="slideSection">
	<div class="panel-heading">
		<ul class="nav nav-tabs">
			<li <?=$check == "yesterday"?"class='active'" : false?> ><a href="yesterday">어제</a></li>
			<li <?=$check == "lastweek"?"class='active'" : false?>><a href="lastweek">저번주</a></li>
			<li <?=$check == "lastmonth"?"class='active'" : false?>><a href="lastmonth">저번달</a></li>
		</ul>
		<br>

		<button data="{{$check}}" class="btn btn-info" id="startSlideBtn">
			<span class="glyphicon glyphicon-play" aria-hidden="true"></span> 슬라이드 시작
		</button>

		{{--lastweek--}}
		@isset($date)
			<br>
			<span class="label label-primary">{!! $date['startDate'] !!} ~ {!! $date['endDate'] !!}</span><br>
			<span class="badge" id="lastweekDay">월요일</span>
		@endisset
		{{--lastweek--}}

		<span id="month"></span>
		<ul class="time_list">
			<li>1h</li>
			<li>2h</li>
			<li>3h</li>
			<li>4h</li>
			<li>5h</li>
			<li>6h</li>
			<li>7h</li>
			<li>8h</li>
			<li>9h</li>
			<li>10h</li>
			<li>11h</li>
			<li>12h</li>
			<li>13h</li>
			<li>14h</li>
			<li>15h</li>
			<li>16h</li>
			<li>17h</li>
			<li>18h</li>
			<li>19h</li>
			<li>20h</li>
			<li>21h</li>
			<li>22h</li>
			<li>23h</li>
			<li>END</li>
		</ul>
		<div class="progress_bar"></div>
	</div>
	<div class="panel-body">
		

		<div class="row" style="text-align: center">
			<button id="firePowerBtn" class="btn btn-primary" style="margin-bottom: 20px;">화력 발전소 위치 확인</button><br>
			<div class="col-md-6" id="firePower" style="display: none;">
				<table class="table table-hover">
					<thead>
						<tr>
							<td><b>지역</b></td>
							<td><b>발전소명</b></td>
							<td><b>상세설명</b></td>
						</tr>
					</thead>
					<tbody>
						@foreach($firePower as $key => $val)
							<tr class="fireTr" data="{{$key}}">
								<td>{{$val}}</td>
								<td>{{$key}}</td>
								<td><a href="https://ko.wikipedia.org/wiki/{{$key}}" onclick="window.open(this.href, '_blank'); return false;">보러가기</a></td>
							</tr>
						@endforeach

					</tbody>
				</table>
			</div>
			<div class="col-md-6" style="margin: 0 auto; float: none;">
				<?=file_get_contents('img/korea.svg')?>
			</div>

		</div>

	</div>
</div>
<input type="hidden" id="{{$check}}" value='{!! $datas !!}'>

<!-- 슬라이드 데이터 -->

@endsection('content')

