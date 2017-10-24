<?php

require 'vendor/autoload.php';

use GuzzleHttp\Client;
use Sunra\PhpSimple\HtmlDomParser;

$db = new \PDO("mysql:host=gondr.iptime.org;dbname=stu3;charset=utf8","stu3","1234");

// $req = $db->query("SELECT * FROM SI");

// foreach($req->fetch() as $row){
// 	$req2 = $db->query("SELECT * FROM GU WHERE SI_CODE = '{$row['code']}'");
// 	foreach($req2->fetch() as $row2){
// 		$client = new Client();

// 		$name = $row['name']."".$row2['name'];

// 		$position = $db->query("SELECT * FROM LOCALES WHERE NAME LIKE '%{$name}%' ORDER BY ID DESC LIMIT 1");

// 		$lat = $position['lat'];
// 		$lng = $position['lng'];

// 		$req3 = client('GET','http://apis.skplanetx.com/weather/dust?version=1&lat='.$lat.'&lon='.$lng.'',['header' => ['appkey' => '5d4f31bc-6b5c-3c8d-9715-2672fb5f2e6a']]);

// 		$result = json_decode($req3->getBody())->{'weather'}->{'dust'}[0]->{'pm10'};
// 		$date = json_decode($req3->getBody())->{'weather'}->{'dust'}[0]->{'timeObservation'};
// 		$req4 = $db->prepare("INSERT INTO DUSTDATA(NAME,SI_CODE,CODE,VALUE,GRADE,DATE)VALUE(:name,:sicode,:code,:value,:grade,:date)");
// 		$req4->execute(array(':name' => $name , ':sicode' => $row2['si_code'] , ':code' => $row['code'] , ':value' => $result->{'value'} , ':grade' => $result->{'grade'} , ':date' => $date));

// 	}
// }

// $location = ['02','031','032','033','041','042','043','051','052','053','054','055','061','062','063','064','044'];
// $date = date("Y-m-d");

// foreach ($location as $row) {
	

// 	$client = new Client();
// 	$req = $client->request('GET','http://www.airkorea.or.kr/pmRelaySub?strDateDiv=1&searchDate='.$date.'&district='.$row.'&itemCode=10007');
// 	$data = $req->getBody(true);
// 	$number = date("H");
// 	$dom = HtmlDomParser::str_get_html( $data );

// 	$result = $dom->find('#tablefix1 > tbody > tr');

// 	foreach($result as $row2){
// 		if( $row2->find("td")[0]->plaintext == "도시대기"){
// 			$name = $row2->find("td")[1]->plaintext;
// 			$value = $row2->find("td")[$number+1]->plaintext;
// 			echo $name." - ".$value."\n ";

// 			$req2 = $db->prepare("INSERT INTO dustdata(NAME,VALUE,DATE)VALUES(?,?,now())");
// 			$req2->execute(array($name,$value));
// 		}

// 	}

// }


	// $req = $db->query("select * from si");

	// foreach($req as $row) {

	// 	$req2 = $db->query("select * from gu where si_code = '{$row['code']}'");

	// 	foreach ($req2 as $row2) {
 //            $client = new Client();
 //            $req = $client->request('GET', 'http://openapi.airkorea.or.kr/openapi/services/rest/ArpltnInforInqireSvc/getMsrstnAcctoRltmMesureDnsty?stationName='.$row2['name'].'&dataTerm=month&pageNo=1&numOfRows=1&ServiceKey=u4Q%2FF%2BzFS1PHRIhVj2cJcxGP8J%2B5vOxCbaO039frcCGDEuD2km6rhbR2wZrwBrZtlLu2Z%2FbsqMHDVVGHwkq8ow%3D%3D&ver=1.3');

 //            $xml = $req->getBody();
 //            $dom = HtmlDomParser::str_get_html($xml);

 //            $result = $dom->find("response > body > items > item");

 //            $value = $result[0]->find("pm25Value")[0]->plaintext;
 //            $name = $row2['name'];형
 //            $date = $result[0]->find("dataTime")[0]->plaintext;
 //            echo $name."\n";

 //        }
 //    }		
			
	$koreas = ['서울','부산','대구','인천','광주','대전','울산','경기','강원','충북','충남','전남','전북','경북','경남','제주','세종'];


	foreach ($koreas as $korea) {
		
	
		$client = new Client();
	    $req = $client->request('GET', 'http://openapi.airkorea.or.kr/openapi/services/rest/ArpltnInforInqireSvc/getCtprvnRltmMesureDnsty?sidoName='.$korea.'&pageNo=1&numOfRows=500&ServiceKey=u4Q%2FF%2BzFS1PHRIhVj2cJcxGP8J%2B5vOxCbaO039frcCGDEuD2km6rhbR2wZrwBrZtlLu2Z%2FbsqMHDVVGHwkq8ow%3D%3D&ver=1.3');

	    

	       $xml = $req->getBody();

           $dom = HtmlDomParser::str_get_html($xml);

           $result = $dom->find("response > body > items > item");

           $dustAll = 0;
           $count = count($result);
           $dateSave = $result[0]->find("dataTime")[0]->plaintext;

           // echo count($result)."---------------------------\n";
           foreach ($result as $row) {
            	$value = $row->find("pm10Value")[0]->plaintext;
            	// $name = $row2['name'];
            	$date = $row->find("dataTime")[0]->plaintext;
            	$name = $row->find("stationName")[0]->plaintext;	

            	$dustAll += intval($value);

            	$req = $db->prepare("INSERT INTO dustdata(name,value,date,si)values(:name,:value,:date,:si)");
            	$req->execute(array(':name' => $name , ':value' => $value , ':date' => $date,':si' => $korea));
           }


           $req = $db->prepare("INSERT INTO sidustdata(name,value,date)values(:name,:value,:date)");
           $req->execute(array(':name' => $korea , ':value' =>  intval($dustAll/$count), ':date' => $dateSave));

	}

   //       
            

            


?>
