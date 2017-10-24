<?php


require 'vendor/autoload.php';

use GuzzleHttp\Client;
use Sunra\PhpSimple\HtmlDomParser;

//$db = new \PDO("mysql:host=tourcoach.co.kr;dbname=tourcoach;charset=utf8","root","wlalswl1");

$keyword = urlencode('군산 해망굴');
$client = new Client();
$req = $client->request('GET' , 'http://data.visitkorea.or.kr/search.do?keyword='.$keyword);

$html = $req->getBody();

$dom = HtmlDomParser::str_get_html($html);
print_r($dom->find('.lodList'));

//if( isset(get_object_vars(json_decode($json))[0]) ){
//   echo 1;
//}else{
//    foreach (json_decode($json)->{'http://data.visitkorea.or.kr/resource/695592'} as $row){
//        print_r($row);
//    }
//}
