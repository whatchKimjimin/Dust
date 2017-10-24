var Apps = function(){
	"use strict";

	var app = {
		DATA : {
			FireTF : true
		},
		initTag : function(){
			app.BODY 					= $(document);

			app.MAP 					= $("#map");
			app.BACK 					= $("#back");
			app.RESULT 					= $("#dustList");
			app.NAV						= $("#resultnav");
			app.MAIN					= $("#mainSection");


			// 관심 지역 페이지
			app.FAVORITE 				= $("#favorite");

			// 미세먼지 슬라이드 페이지 섹션
			app.DUSTSLIDE				= $("#slideSection");
			// 미세먼지 슬라이드 페이지 슬라이드 시작버튼
			app.STARTSLIDEBTN 			= $("#startSlideBtn");


			return this;	
		},
		initEvent : function(){
			//  미세먼지 슬라이드 쇼 시작 버튼
			app.STARTSLIDEBTN.on("click",app.SlideStart);

			// 관심지역 저장 버튼 이벤트
			app.FAVORITE.find("button").on("click",app.favoriteAjax);

			// svg 클릭 이벤트
			// app.MAP.find("svg path").on("click",app.koreaSvgClick);

			app.BACK.on("click",function(){
				app.MAP.find("svg").css({"display":"inline-block"});
				app.MAP.find("object").css({"display":"none"});
				app.BACK.css({"display":"none"});
			})

			app.NAV.find("div").on("click",app.grapShow);

			// 부트스트랩
			$('[data-toggle="tooltip"]').tooltip();


			// 화력발전소 위치 확인 버튼
			app.DUSTSLIDE.find("#firePowerBtn").on("click",function(){
				if(app.DUSTSLIDE.find("#firePower").is(":animated")) return;

				if(app.DATA.FireTF){
					$(this).html("취소");
					$("circle").fadeIn();
                    app.DUSTSLIDE.find("#firePower").fadeIn().siblings(".col-md-6").css({"float":"left"});
                    app.DATA.FireTF = false;
				}else{
                    $(this).html("화력 발전소 위치 확인");
                    $("circle").fadeOut();
                    $.when(app.DUSTSLIDE.find("#firePower").fadeOut()).done(function(){
                        app.DUSTSLIDE.find("#firePower").siblings(".col-md-6").css({"float":"none"})
					})
                    app.DATA.FireTF = true;
				}

			});


			// 화력발전소 위치 테이블 호버효과
			app.DUSTSLIDE.find("table > tbody > tr").hover(function(){
                app.DUSTSLIDE.find("circle[name="+$(this).attr("data")+"]").css({"r":"2","fill":"red","transition":"0.3s"});
			},function(){
                app.DUSTSLIDE.find("circle[name="+$(this).attr("data")+"]").css({"r":"1","fill":"orange","transition":"0.3s"});
			});



			return this;
		},
		start : function(){

			// 차트 숨기기 
			$(".charts").fadeOut();

			// 라라벨 토큰
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			// 관심지역 드래그앤드
			$( "#nullCheckDropzone, #CheckDropzone" ).sortable({
				connectWith: ".col-md-6"
			}).disableSelection();


			return this
			.initTag()
			.initEvent()
			.svgColor()
			.graphSetting()
			.SlideData();
		},
		SlideData : function(){
			if(document.getElementById("yesterday")){
				app.DATA.SlideData = JSON.parse(JSON.parse($("#yesterday").val())[0].value);
				
			}

			if(document.getElementById("lastweek")){
                app.DATA.SlideData = JSON.parse($("#lastweek").val());
                var arr = [];
                for(var a = 0 ; a < app.DATA.SlideData.length ; a++){
					arr[a] = JSON.parse(app.DATA.SlideData[a]);
				}

                app.DATA.SlideData = arr;





			}

			return this;
		},
		SlideStart : function(){
			// 다시보기 이벤트
			$(this).html("다시보기").unbind("click").on("click",app.SlideStart);

			// 이벤트 실행중이면 멈춤
			clearInterval(app.DATA.timer);

			// time progress
			var progress = $(".progress_bar");

			var a = 0;
			var progressPosition = 0;
			
			
			// 어제 슬라이드
			if(document.getElementById("yesterday")) {
                app.DATA.timer = setInterval(function () {
                    progress.animate({"marginLeft": progressPosition + "%"});

                    // finish
                    if (a === 22) clearInterval(app.DATA.timer);

                    var data = app.DATA.SlideData[a][a + 1];
                    for (var i = 0; i < data.length; i++) {
                        $("path[shortname=" + data[i].name + "]").css({"fill": data[i].grade});
                    }
                    a++;
                    progressPosition += 4.16666;

                    // console.log(a,progressPosition);
                }, 1500);
            }



         //   저번주 슬라이드
			if(document.getElementById("lastweek")){
                // 기본 인터벌 초기화
                clearInterval(app.DATA.dayTimer);
                clearInterval(app.DATA.startSlide);

                // 시작요일 
                $("#lastweekDay").html('월요일');
                
				var day = ['월요일','화요일','수요일','목요일','금요일','토요일','일요일'];
				// 시작 슬라이드 ###############################################################3
                var b = 0;
                app.DATA.startSlide = setInterval(function(){
                	if(b === 23) return;
                    progress.animate({"marginLeft": progressPosition + "%"});
                    var data = app.DATA.SlideData[a][b][b+1];

                    for (var i = 0; i < data.length; i++) {
                        $("path[shortname=" + data[i].name + "]").css({"fill": data[i].grade});
                    }
                    b++;
                    progressPosition += 4.16666;
                },500)
                a++;
                // 시작 슬라이드 ###############################################################3


                // 자동 슬라이드 ###############################################################3
                app.DATA.timer = setInterval(function () {
                    progressPosition = 0;
                    // finish
                    // 전 24시간 짜리 setinterval 취소
                	clearInterval(app.DATA.dayTimer);
                	// 시작 슬라이드 취소
                	clearInterval(app.DATA.startSlide);
					// 요일 애니메이션
					$("#lastweekDay").html(day[a]);

					var b = 0;
					//24시간짜리 인터벌
					app.DATA.dayTimer = setInterval(function(){
						// 마지막 마무리
						if(a === 7){
							clearInterval(app.DATA.dayTimer)
                            clearInterval(app.DATA.timer)
							return false;
                        }
                        // 24시간짜리 바
                        progress.animate({"marginLeft": progressPosition + "%"});


                        var data = app.DATA.SlideData[a][b][b+1];

                        for (var i = 0; i < data.length; i++) {
                            $("path[shortname=" + data[i].name + "]").css({"fill": data[i].grade});
                        }
                        b++;
                        progressPosition += 4.16666;
					},500)

                    // 끝

                    a++;
                }, 12000);
                // 자동 슬라이드 ###############################################################3

			}
            
		},
		// 메인에 있는맵 클릭시 시도군 나오는 지도 보여주는 함수
		koreaSvgClick : function(){
			var data = $(this).attr("data");
			var html,width,height,filename,style="";

			switch(data){
				case "강원도":
				width = 800;
				height = 800;
				filename = "gang";
				break;
				case "경기도":
				width = 1200;
				height = 1200;
				filename = "gido";
				break;
				case "서울특별시":
				width = 5500;
				height = 5500;
				filename = "seoul";
				style = "position:relative;left:-800px";
				break;
				case "인천광역시":
				width = 3000;
				height = 3000;
				filename = "inchen";
				style= "position:relative;left:-480px";
				break;
				case "부산광역시":
				width = 3500;
				height = 3500;
				filename = "busan";
				break;
				case "울산광역시":
				width = 3500;
				height = 3500;
				filename = "ulsan";
				break;
				case "대구광역시":
				width = 3500;
				height = 3500;
				filename = "dagu";
				break;
				case "충청남도":
				width = 1000;
				height = 1000;
				filename = "chungSouth";
				break;
				case "충청북도":
				width = 1100;
				height = 1100;
				filename = "chungNorth";
				style= "position:relative;top:-400px;left:-300px";
				break;
				case "전라남도":
				width = 950;
				height = 950;
				filename = "junlaSouth";
				break;
				case "전라북도":
				width = 1200;
				height = 1200;
				filename = "junlaNorth";
				break;
				case "제주특별시":
				width = 2000;
				height = 2000;
				filename = "jeju";
				break;
				case "경상북도":
				width = 1000;
				height = 1000;
				filename = "gungsangNorth";
				break;
				case "경상남도":
				width = 1000;
				height = 1000;
				filename = "gungsangSouth";
				break;
				case "광주광역시":
				width = 3900;
				height = 3900;
				filename = "gangju";
				break;
				case "세종특별시":

				break;
				case "대전광역시":
				width = 3000;
				height = 3000;
				filename = "dezun";
				style = "position:relative;left:100px";
				break;
			}

			
			app.MAP.find("svg").css({"display":"none"});
			app.MAP.find("object").attr("data","/img/"+filename+".svg").attr("width",width).attr("height",height).attr("style",style).css({"display":"inline-block"});
			app.BACK.css({"display":"block"});

			return this;
		},


		// 처음 그래프 셋팅
		graphSetting : function(){
			if(!document.getElementById('myChart')) return this;
			var ctx = document.getElementById('myChart').getContext('2d'); // 차트 dom 객체 저장 
			var t,test =[],date;

			$.post("/graph",function(datas){
				
				for(var a = 0 ; a < datas.length ; a++){
					test[a] = JSON.parse(datas[a]);
				}
				// test[0] = JSON.parse(data[0]);
				// test[1] = JSON.parse(data[1]);

				$.post("/graphdate",function(data2){
					date = data2;

					// 그래프 생성 객체
					var chart = new Chart(ctx, {
						type: 'line',
						data: {
							labels: date.reverse(),
							datasets: test
						},
						options: {

						}
					});

				})
			});
			Chart.defaults.global.hover;

			return this;
		},

		// 메인 내비게이션 클릭시 이벤트
		grapShow : function(){
			if(app.MAIN.find("canvas").is(":animated")) return;

			var no = $(this).index();

			switch(no){	
				case 0:
				$.when(app.MAIN.find("canvas").fadeOut(100)).done(function(){
					app.MAIN.find(".col-md-6").fadeIn(100);	
				})

				$(this).css({"background-color":"#333"});
				$(this).siblings().css({"background-color":"#999"});
				break;
				case 1:
				$.when(app.MAIN.find(".col-md-6").fadeOut(100)).done(function(){
					app.MAIN.find("canvas").fadeIn(100);
				})

				$(this).css({"background-color":"#333"});
				$(this).siblings().css({"background-color":"#999"});
				break;
			}

			return this;
		},
		// 메인 한국 svg 색깔 세팅
		svgColor : function(){

			var data = app.RESULT.find("table > tbody > tr");

			for(var i = 0 ; i < data.length ; i++){
				var name = data.eq(i).find("td").eq(0).html(); // 지역 이름
				var value = data.eq(i).find("td").eq(1).html().trim(); // 지역 미세먼지 상태
				var color;
				

				switch(value){
					case "좋음":
					color = "rgb(193, 227, 255)";
					break;
					case "보통":
					color = "rgb(215, 241, 185)";
					break;
					case "나쁨":
					color = "rgb(255, 237, 189)";
					break;
					case "매우 나쁨":
					color = "rgb(254, 225, 205)";
					break;
				}
				

				$("path[shortname="+name+"]").css({"fill":color});	
				

			}

			return this;
		},
		favoriteAjax : function(){
			

			var data = app.FAVORITE.find("#CheckDropzone > li");
			var arr = [];
			for(var a = 0 ; a < data.length ; a++){
				arr[a] = data.eq(a).attr("data");
			}

			$.ajax({
				method:"POST",
				url : "/mypage/favorite",
				data : { data : arr }
			}).done(function(data){
				alert(data.msg);
				if(data.success) location.href = '/mypage'; 
			})
			



			return this;
		}
	}


	return app;
}

window.onload = function(){
	var apps = new Apps();

	apps.start();
	return apps;
}