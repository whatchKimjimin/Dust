<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });



Route::get("/","DustController@index")->name("main");


// 회원가입 뷰
Route::get("/joinuser","UserController@joinView")->name("joinview");
// 회원가입 처리
Route::post("/joinuser","UserController@join")->name("join");

// 로그인 뷰
Route::get("/loginuser","UserController@loginView")->name("loginView");
// 로그인 처리
Route::post("/loginuser","UserController@login")->name("login");
// 로그아웃 처리
Route::get("/logout","UserController@logout")->name("logout");
// 마이페이지 뷰
Route::get("/mypage","UserController@mypageView")->name("mypageView");

// 관심 지역 뷰 
Route::get("/mypage/favorite","UserController@favoriteView")->name("favoriteView");
Route::post("/mypage/favorite","UserController@favorite")->name("favorite");

// graph ajax
Route::post("/graph","DustController@graphAjax")->name("graphAjax");
Route::post("/graphdate","DustController@graphDateAjax")->name("graphDateAjax");


// 시간대별 미세먼지 슬라이드
// Route::get("/dustslide","DustController@dustSlideView")->name("dustSlideView");
Route::get("/dustslide/{check}","DustController@dustSlide")->name("dustSlide");

// 미세먼지 슬라이드 데이터 받아오기
Route::post("/dustslide/ajax","DustController@dustSlideData")->name("dustSlideData");

// tourcoachApi
Route::post("/tour/send","TourController@send")->name("send");

// Route::get("/test","DustController@test")->name("test");

/*
DB::listen(function($query){
	var_dump($query->sql);
});
*/
