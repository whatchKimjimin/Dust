<?php

//$curl = curl_init();
//// Set some options - we are passing in a useragent too here
//curl_setopt_array($curl, array(
//    CURLOPT_RETURNTRANSFER => 1,
//    CURLOPT_URL => 'https://openapi.naver.com/v1/search/news.json?query=%EC%A3%BC%EC%8B%9D&display=100&start=1&sort=sim',
//    CURLOPT_USERAGENT => 'Codular Sample cURL Request',
//    CURLOPT_HTTPHEADER => array(
//        'X-Naver-Client-Id: MRQsbNRJsc2qxRg8JYyT',
//        'X-Naver-Client-Secret: 9AAUATVru0'
//    )
//));
//// Send the request & save response to $resp
//$resp = json_decode(curl_exec($curl));
//// Close request to clear up some resources
//curl_close($curl);
//
//
//
//for($a = 0 ; $a < count($resp->items) ; $a++){
//    $title = $resp->items[$a]->title;
//
//    if(strpos( $title , '미세먼지') !== false or strpos( $title , '화력발전소') !== false){
//        echo $title."\n";
//    }
//}

// 카카오톡 프로필 요청
//$curl = curl_init();
//// Set some options - we are passing in a useragent too here
//curl_setopt_array($curl, array(
//    CURLOPT_RETURNTRANSFER => 1,
//    CURLOPT_URL => 'https://kapi.kakao.com/v1/api/talk/profile',
//    CURLOPT_USERAGENT => 'Codular Sample cURL Request',
//    CURLOPT_HTTPHEADER => array(
//        'Authorization: Bearer YNZntEd1lg9YejGXUPkpcQfNDOLk5pm69Er2ZgopdgcAAAFdfk0n2g',
//    )
//));
//// Send the request & save response to $resp
//$resp = json_decode(curl_exec($curl));
//// Close request to clear up some resources
//curl_close($curl);
//
//print_r($resp);




// 카카오톡
//$data = '{
//  "object_type": "feed",
//  "content": {
//    "title": "디저트 사진",
//    "description": "아메리카노, 빵, 케익",
//    "image_url": "http://mud-kage.kakao.co.kr/dn/NTmhS/btqfEUdFAUf/FjKzkZsnoeE4o19klTOVI1/openlink_640x640s.jpg",
//    "image_width": 640,
//    "image_height": 640,
//    "link": {
//      "web_url": "http://www.daum.net",
//      "mobile_web_url": "http://m.daum.net",
//      "android_execution_params": "contentId=100",
//      "ios_execution_params": "contentId=100"
//    }
//  }
//}';
//
////$json_data = array('object_type' => 'feed','content' => array('title' => '디저트 사진' ));
////print_r(json_encode($json_data));
//
//
//

$data = "template_object={
  \"object_type\": \"location\",
  \"content\": {
    \"title\": \"경포대\",
    \"description\": \"경기도 광주시 오포읍 \",
    \"image_url\": \"https://tourcoach.co.kr/img/RESOURCE/Main/ic_airplane.png\",
    \"image_width\": 800,
    \"image_height\": 800,
    \"link\": {
      \"web_url\": \"https://tourcoach.co.kr/tour/detail/123\",
      \"mobile_web_url\": \"https://tourcoach.co.kr/tour/detail/123\",
      \"android_execution_params\": \"platform=android\",
      \"ios_execution_params\": \"platform=ios\"
    }
  },
  \"buttons\": [
    {
      \"title\": \"웹으로 보기\",
      \"link\": {
        \"web_url\": \"https://tourcoach.co.kr/tour/detail/123\",
        \"mobile_web_url\": \"https://tourcoach.co.kr/tour/detail/123\"
      }
    }
  ],
  \"address\": \"경기 성남시 분당구 판교역로 235 에이치스퀘어 N동 7층\",
  \"address_title\": \"카카오 판교오피스\"
}";


//$data = "template_object= {
//  \"object_type\": \"list\",
//  \"header_title\": \"추천 결과\",
//  \"header_link\": {
//    \"web_url\": \"http://www.daum.net\",
//    \"mobile_web_url\": \"http://m.daum.net\",
//    \"android_execution_params\": \"main\",
//    \"ios_execution_params\": \"main\"
//  },
//  \"contents\": [
//    {
//      \"title\": \"자전거 라이더를 위한 공간\",
//      \"description\": \"매거진\",
//      \"image_url\": \"http://mud-kage.kakao.co.kr/dn/QNvGY/btqfD0SKT9m/k4KUlb1m0dKPHxGV8WbIK1/openlink_640x640s.jpg\",
//      \"image_width\": 640,
//      \"image_height\": 640,
//      \"link\": {
//        \"web_url\": \"http://www.daum.net/contents/1\",
//        \"mobile_web_url\": \"http://m.daum.net/contents/1\",
//        \"android_execution_params\": \"/contents/1\",
//        \"ios_execution_params\": \"/contents/1\"
//      }
//    },
//    {
//      \"title\": \"비쥬얼이 끝내주는 오레오 카푸치노\",
//      \"description\": \"매거진\",
//      \"image_url\": \"http://mud-kage.kakao.co.kr/dn/boVWEm/btqfFGlOpJB/mKsq9z6U2Xpms3NztZgiD1/openlink_640x640s.jpg\",
//      \"image_width\": 640,
//      \"image_height\": 640,
//      \"link\": {
//        \"web_url\": \"http://www.daum.net/contents/2\",
//        \"mobile_web_url\": \"http://m.daum.net/contents/2\",
//        \"android_execution_params\": \"/contents/2\",
//        \"ios_execution_params\": \"/contents/2\"
//      }
//    },
//    {
//      \"title\": \"감성이 가득한 분위기\",
//      \"description\": \"매거진\",
//      \"image_url\": \"http://mud-kage.kakao.co.kr/dn/NTmhS/btqfEUdFAUf/FjKzkZsnoeE4o19klTOVI1/openlink_640x640s.jpg\",
//      \"image_width\": 640,
//      \"image_height\": 640,
//      \"link\": {
//        \"web_url\": \"http://www.daum.net/contents/3\",
//        \"mobile_web_url\": \"http://m.daum.net/contents/3\",
//        \"android_execution_params\": \"/contents/3\",
//        \"ios_execution_params\": \"/contents/3\"
//      }
//    }
//  ],
//  \"buttons\": [
//    {
//      \"title\": \"웹으로 이동\",
//      \"link\": {
//        \"web_url\": \"http://www.daum.net\",
//        \"mobile_web_url\": \"http://m.daum.net\"
//      }
//    },
//    {
//      \"title\": \"앱으로 이동\",
//      \"link\": {
//        \"android_execution_params\": \"main\",
//        \"ios_execution_params\": \"main\"
//      }
//    }
//  ]
//}";
$curl = curl_init();
// Set some options - we are passing in a useragent too here
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'https://kapi.kakao.com/v2/api/talk/memo/default/send',
    CURLOPT_USERAGENT => 'Codular Sample cURL Request',
    CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer _gLPgv5BN2QwEw4-_3vFbpY_uK8gr6bN05sTkAoqAuYAAAFeVKxo6Q',
    ),
//    CURLOPT_POSTFIELDS => array('template_id=4415')
    CURLOPT_POSTFIELDS => $data
));
// Send the request & save response to $resp
$resp = json_decode(curl_exec($curl));
// Close request to clear up some resources
curl_close($curl);
echo $data;
print_r($resp);

//https://maps.googleapis.com/maps/api/staticmap?center=Berkeley,CA&zoom=14&size=400x400&key=AIzaSyDqWBda5DAqcIJQIWAs6_kYjTPCLUd1Ejw

// 페이스북 Greeting Text
//$data = array('recipient' => array('id' => '1972821279657282') , "message" => array( 'text' => 'hello'));
//
//$curl = curl_init();
//// Set some options - we are passing in a useragent too here
//curl_setopt_array($curl, array(
//    CURLOPT_RETURNTRANSFER => 1,
//    CURLOPT_URL => 'https://graph.facebook.com/v2.6/245902125919040/messages?access_token=EAADfpYzda0ABAIuIPpBqqAeExU2rmIjnAEiay5egCyeaW0Q4zxU0iu7lPinJO3ZBXkCMh1ommXSU6jJlZCnTOQQHR4PeWBGO6JFC2eG2ZCA3oU1EZBkDU9RtBdUC3OKyqwnLMBKGBD0sMmprh2Pg39dOHbxiQgUOvhyEYxPRuQZDZD',
//    CURLOPT_HTTPHEADER => array(
//        'Content-Type: application/json'
//    ),
//    CURLOPT_POSTFIELDS => json_encode($data)
//));
//// Send the request & save response to $resp
//$resp = json_decode(curl_exec($curl));
//// Close request to clear up some resources
//curl_close($curl);
//
//echo json_encode($data);
//print_r($resp);



//
//$curl = curl_init();
//// Set some options - we are passing in a useragent too here
//curl_setopt_array($curl, array(
//    CURLOPT_RETURNTRANSFER => 1,
//    CURLOPT_URL => 'http://apis.skplanetx.com/weather/current/minutely?lon=128.9056658&village=&cellAWS=&lat=37.7442995&country=&city=&version=1',
//    CURLOPT_HTTPHEADER => array(
//        'appKey: 5d4f31bc-6b5c-3c8d-9715-2672fb5f2e6a'
//    )
//));
//// Send the request & save response to $resp
//$resp = json_decode(curl_exec($curl));
//// Close request to clear up some resources
//curl_close($curl);
//
//
////print_r($resp);
//
//echo $resp->weather->minutely[0]->timeObservation;
//echo $resp->weather->minutely[0]->temperature->tc;
//
////echo $resp->weather->temperature->tc;
