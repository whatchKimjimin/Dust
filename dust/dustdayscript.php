<?php

require 'vendor/autoload.php';

$db = new \PDO("mysql:host=gondr.iptime.org;dbname=stu3;charset=utf8","stu3","1234");

 


	// $date = date("Y-m-d H:00:00");
	// $req2 = $db->prepare("select * from sidustdata where date >= ?");
	// $req2->execute(array($date));
	// $json = array();
	// foreach ($req2->fetchAll() as $row) {
	// 	$req3 = $db->prepare("select * from si where shortname = ?");
	// 	$req3->execute(array($row['name']));
	// 	$si_id = $req3->fetch();
	// 	$json[] = array('si_id' => $si_id['id'],'value' => $row['value']);
	// }
	
	

	// $req4 = $db->prepare("insert into dustday(date,hour,value)values(?,?,?)");
	// $req4->execute(array( date("Y-m-d") , date("H") , json_encode($json) ));

	
	$json = array();
	$today = date("Y-m-d");
	$yesterday = date("Y-m-d H:00:00",strtotime("-1 day", strtotime( date("Y-m-d H:00:00") ) ));
	for($a = 1 ; $a < 24 ; $a++){
		if($a < 10 ) $date = $today.' 0'.$a.':00:00';
		else $date = $today.' '.$a.':00:00';

		// 시작 시간
		$startDate =  date("Y-m-d H:00:00",strtotime("-1 day",strtotime($date)));

		// 끝 시간 
		$endDate =  date("Y-m-d H:59:59",strtotime("-1 day",strtotime($date)));

		// 검색 쿼리
		$req = $db->prepare("select name , value , CASE WHEN 'value' >= 151 THEN 'rgb(254, 225, 205)' WHEN  `value` >= 81 AND  `value` < 150 THEN  'rgb(255, 237, 189)' WHEN  `value` <= 30 AND  `value` < 80 THEN  'rgb(215, 241, 185)' ELSE  'rgb(193, 227, 255)' END AS  `grade` from sidustdata where date between ? and ?");	
		$req->execute(array( $startDate , $endDate ));
		
		echo $startDate."\n";
		$arr = array();
		foreach($req->fetchAll() as $row){
			$arr[] = array('name' => $row['name'] , 'value' => $row['value'] ,'grade' => $row['grade']);
			echo $row['name']." = ".$row['value'].",".$row['grade']."\n";
		}
		$json[] = array($a => $arr);
	}
	$req = $db->prepare("insert into dustdays(date,value)values(?,?)");
	$req->execute(array($yesterday,json_encode($json,JSON_UNESCAPED_UNICODE)));
	
	

