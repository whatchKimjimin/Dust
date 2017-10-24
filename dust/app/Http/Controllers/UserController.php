<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

	// 로그인 뷰
    public function loginView(){

    	return view('user.login');
    }

    // 회원가입 뷰
    public function joinView(){

    	return view('user.join');
    }

    // 회원가입
    public function join(Request $req){
    	
    	
    	$rules = [
			'useremail' => ['required'],
			'username' => ['required',"max:20","min:3"],
			'userpass' => ['required',"min:8","max:20"]
		];
		/***********************************************
		* 이메일은 주어진 조건에 맞게 정규표현식을 지정.
		* 비밀번호는 영문, 특문, 숫자가 각 하나씩은 포함되도록 정규표현식을 지정함.
		* messages 배열에는 각각의 규정을 지키지 않았을 때 나타날 에러메시지를 지정함.
		****************************************************/
		$messages = [
			'useremail.required' => '아이디는 필수 입력사항입니다',
			'username.required' => '이름은 반드시 입력되어야 합니다.',
			'username.max' => '이름은 최대 20글자 입니다',
			'username.min' => '이름은 최대 3글자 입니다',
			'userpass.required' => '비밀번호 입력란은 필수 입력사항입니다',
			'userpass.max' => '비밀번호은 최대 20글자 입니다',
			'userpass.min' => '비밀번호은 최소 8글자 입니다',
		];

		$validator = \Validator::make($req->all(), $rules, $messages);

		if($validator->fails()){
			return back()->withErrors($validator)->withInput();
		}
    	
    	$inputEmail = $req->input('useremail');
		$user = \App\Kuser::select('useremail')->where('useremail', '=', $inputEmail)->first();

		if($user){
			//해당 사용자가 존재한다면.
			// back: 이전페이지로 돌아가면서 flash_message에 내용을 저장, withInput을 통해 입력값도 함께 돌려보내줌.
			return back()->with('err', '해당 이메일의 사용자가 이미 존재합니다.')->withInput();
		}
		//리퀘스트로 넘어온 요청을 전부 create에 넘겨줌.
		$inputArray = $req->all();
		$inputArray['userpass'] = bcrypt($inputArray['userpass']);
		$user = \App\Kuser::create($inputArray);

		if(! $user){
			//사용자 가입이 실패한 경우.
			return back()->with('err', '오류로 가입되지 못했습니다.')->withInput();	
		}

		return redirect('/loginuser')->with('success', '성공적으로 가입되었습니다.');
    	// \App\User::create($input);
    }

    // 로그인 
    public function login(Request $req){
    	


		$inputEmail = $req->input('useremail');
		$inputPass = $req->input('userpass');

		$user = \App\Kuser::where([ ['useremail' , '=' ,$inputEmail ] ])->first();

		if( !$user ){
			return back()->with('err','아이디를 다시입력해주세요.')->withInput();
		}

		if( ! \Hash::check( $inputPass ,  $user->userpass) ){
			return back()->with('err','비밀번호를 다시입력해주세요')->withInput();
		}


		$req->session()->put('loginData',$user);
		return redirect("/");

    }

    // 로그아웃
    public function logout(Request $req){
    	$req->session()->forget('loginData');
    	return redirect("/");
    }

    // 마이페이지 
    public function mypageView(){
    	// 유저 데이터
    	$user_id = session('loginData');
    	// 유저의 관심지역 가져오기
    	$favoritesData = DB::table('favorites')->where('user_id' , '=' , $user_id->id)->get();

    	$cityCodes = array();
    	for($i = 0; $i  < count($favoritesData); $i++){
			$cityCodes[] = $favoritesData[$i]->si_id;
    	}

    	$favoritesResult = DB::table('si')->whereIn('id', $cityCodes)->get();

    	return view("user.mypage",['favorites' => $favoritesResult]);
    }


    // 관심 지역
    public function favoriteView(){
    	// 유저 데이터
    	$user_id = session('loginData');

    	// 지역 가져오기 
    	$favoritesData = DB::table('favorites')->select('si_id')->where('user_id' , '=' , $user_id->id)->get();
    	$cityCodes = array();

    	for($i = 0; $i  < count($favoritesData); $i++){
			$cityCodes[] = $favoritesData[$i]->si_id;
    	}

    	$CheckCity = DB::table('si')->whereIn('id', $cityCodes)->get();
    	$notCheckCity = DB::table('si')->whereNotIn('id', $cityCodes)->get();
    	

    	return view("user.favorite",['check' => $CheckCity , 'notCheck' => $notCheckCity]);
    }


    // 관심 지역 추가
    public function favorite(Request $req){
    	// 로그인한 회원만 접근 가능
    	if (!$req->session()->has('loginData')) return response()->json(array('success' => false , 'msg' => '로그인한 회원만 가능합니다.'));


    	// 유저 데이터
    	$user_id = $req->session()->get('loginData')->id;


    	// 모든 유저의 관심 지역 포맷
    	DB::table('favorites')->where('user_id' , '=' , $user_id)->delete();


    	// 데이터 없으면 끝낸다
    	if(!$req->has('data')) return response()->json(array('success' => true , 'msg' => '저장되었습니다.'));


    	// 받아온 데이터를 변수에 넣어준다.
    	$si_id = $req->input('data');
    	$sql = [];


    	// insert할 value들을 넣는곳
    	foreach($si_id as $data){
    		$sql[] = array('user_id' => intval($user_id) , 'si_id' => intval($data));
    	}

    	
    	// insert query
    	try{
    		DB::table('favorites')->insert($sql);
    	}catch(\Exception $e){
    		return response()->json(array('success' => false , 'msg' => '다시시도해주세요.'));
    	}

    	return response()->json(array('success' => true , 'msg' => '저장되었습니다.'));
    }
}
