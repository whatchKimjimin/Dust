<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Charts;

class DustController extends Controller
{
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    // 미세먼지 상태 함수
	private function dustlevel($value){
		$result = null; // 상태 저장 변수
		$color = null; // 색깔 클래스 저장 변수

		if($value >= 151){
			$result = "매우 나쁨";
			$color = "red";
		}else if($value >= 81){
			$result = "나쁨";
			$color = "orange";
		}else if($value >= 30){
			$result = "보통";
			$color = "green";
		}else{
			$result = "좋음";
			$color = "blue";
		}

		$returnData = [$result,$color];
		return $returnData;
	}

	public function index(){
		
		$data = [];  // 메인에 넘겨줄 배열 변수

    	$date = DB::table('sidustdata')->orderBy('date','desc')->first(); // 최근 날짜 가져오기
    	$date = $date->date; // 최근날짜 변수
    	$koreas = ['서울','부산','대구','인천','광주','대전','울산','경기','강원','충북','충남','전남','전북','경북','경남','제주','세종'];
    	foreach ($koreas as $korea) {

    		// 지역의 최근 미세먼지 평균을 받아온다.
    		$dust = DB::table('sidustdata')->where('name' , '=' , $korea)->orderBy('date','desc')->first();

    		// 미세먼지 상태 함수 실행하여 정보 변환 시켜옴
    		$grade = $this->dustlevel($dust->value);


			// 메인으로 넘길 값들 저장
    		$data[] = (object)array('name' => $korea , 'value' => $dust->value , 'grade' => $grade[0] , 'color' => $grade[1]);
    	}


    	return view('dust.index',['datas' => $data,'date' => $date]);
    }



	// 미세먼지 평균값을 에이젝스로 넘겨줌
    public function graphAjax(Request $req){
        $names = null;

    	// 17개의 특별시,도 이름 가져옴
        if($req->session()->has('loginData')){
            // 유저 아이디 값
            $user_id = $req->session()->get('loginData')->id;

            // 관심지역 가져오기
            $favoritesData = DB::table('favorites')->select('si_id')->where('user_id' , '=' , $user_id)->get();


            $cityCodes = array();
            for($i = 0; $i  < count($favoritesData); $i++){
                // sidustdata테이블에서 값을 가져올라면 shortname 으로 바꿔서 넣줘야한다.
                $shortName = DB::table('si')->select('shortname')->where('id', '=' , $favoritesData[$i]->si_id)->get();
                $cityCodes[] = $shortName[0]->shortname;
            }

            $names = DB::table('sidustdata')->select('name')->distinct('name')->whereIn('name',$cityCodes)->get();
        }else{
            $names = DB::table('sidustdata')->select('name')->distinct('name')->get();   
        }


        $result = [];


        foreach ($names as $name) {
    		// 최근 7시간의 미세먼지 기록들을 가져옴

            $datas = DB::table('sidustdata')->select('value')->where('name','=',$name->name)->orderBy('date','desc')->limit(7)->get();
            


            $value = [];
            foreach($datas as $data){
               $value[] = $data->value;	
           }

           $color = $this->dustlevel($value[0]);
           switch($color[1]){
               case "blue":
               $color = "32a1ff";
               break;
               case "green":
               $color = "7acf16";
               break;
               case "orange":
               $color = "fd934c";
               break;
               case "red":
               $color = "ff7070";
               break;
           }

    		//  그래프에 필요한 값들
           $data = array('label' => $name->name , 'backgroundColor' => 'rgba(255, 99, 132,0)' , 'borderColor' => "#".$color ,'data' => array_reverse($value));
    		// 스크립트로 넘기기위한 준비
           $result[] = json_encode($data);

       }

       return $result;
   }


	// 미세먼지가 업데이트된 최근 날짜 7개를 넘긴다.
   public function graphDateAjax(Request $req){
     $graphDateSql = DB::table('dustdata')->select('date')->distinct('date')->orderBy('date','desc')->limit(7)->get();

     $graphDate = [];
     foreach ($graphDateSql as $value) {
            $graphDate[] = $value->date;
        }
          return $graphDate;
    }



    // 시간대별 미세먼지 슬라이드 뷰
    public function dustSlideView(){
        return view('dust.slide');
    }

    // 시간대 별 미세먼지 슬라이드 처리
    public function dustSlide(Request $req , $check = "yesterday"){
        $date = null;
        $firePower = array('서울화력발전소' => '서울' , '광양복합화력발전소' => '전남' , '군산복합화력발전소' => '전북' , '남제주화력발전소' => '제주' , '당진복합화력발전소' => '충남' , '당진화력발전소' => '충남' ,'대산복합화력발전소' => '충남' , '동두천복합화력발전소' => '경기' , '동해화력발전소' => '강원' , '보령화력발전소' => '충남' , '부산복합화력발전소' => '부산' , '부천열병합발전소' => '경기' , '북평화력발전소' => '강원' ,'분당복합화력발전소' => '경기' , '분당복합화력발전소' => '강원' , '삼천포화력발전소' => '전남' , '서인천복합화력발전소' => '인천' , '서천화력발전소' => '충남' , '세종천연가스발전소' => '세종' , '신보령화력발전소' => '충남' , '신인천복합화력발전소' => '인천' , '안동복합화력발전소' => '경북' , '안산복합화력발전소' => '경기' , '안양열병합발전소' => '경기' , '양주열병합발전소' => '경기' ,'여수화력발전소' => '전남' , '영동화력발전소' => '경북' , '영월복합화력발전소' => '경북' , '오산열병합발전소' => '경기' , '오성복합화력발전소' => '경기' , '오성복합화력발전소' => '경기' , '울산화력발전소' => '울산' , '율촌복합화력발전소' => '전남' , '인천LNG복합발전소' => '인천' , '인천복합화력발전소' => '인천' , '일산열병합발전소' => '경기' , '제주화력발전소' => '제주' , '태안화력발전소' => '충남' , '파주천연가스발전소' => '경기' , '평택화력발전소' => '경기' , '포천복합화력발전소' => '경기' , '포천천연가스발전소' => '경기' , '하동화력발전소' => '전남' , '호남화력발전소' => '전남');
        
        switch($check){
          case "yesterday":


            try{
              $datas = DB::table('dustdays')->where('date' , '=' ,date("Y-m-d", strtotime(date("Y-m-d")." -1 day")) )->get();
            }catch(\Exception $e){
              die("디비 에러");
            }

            break;
          case "lastweek":
              $startDate = date("Y-m-d",strtotime ("last Monday -7 day"));
              $endDate = date("Y-m-d",strtotime ("last Monday -1 day"));
              $date = array('startDate' => $startDate , 'endDate' => $endDate);

              $datas = DB::table('dustdays')->whereBetween('date',[$startDate,$endDate])->get();

              $arr = array();
              foreach ($datas as $row){
                  $arr[] = $row->value;
              }
              $datas = $arr;
            break;
          case "lastmonth":
              die("준비중입니다");
            break;
          default:
            die('잘못된 경로입니다.');
            break;
        }

        return view('dust.slide',['check' => $check , 'datas' => json_encode($datas) , 'date' => $date , 'firePower' => $firePower]);
    }

     public function dustSlideData(Request $req){
        try{
          $data = DB::table('dustdays')->where('date' , '=' , $req->input('date'))->get();
        }catch(\Exception $e){
          return response()->json(array('success' => false));
        }


        return response()->json(array('success' => true,'data' => $data));
    }


}
