<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TourController extends Controller
{
    public function send(Request $req){

        $curl = curl_init();
        // Set some options - we are passing in a useragent too here
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => 'https://kapi.kakao.com/v2/api/talk/memo/default/send',
            CURLOPT_USERAGENT => 'Codular Sample cURL Request',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer EJEKbW0elFJdx6er4TIDmkUUSZgkWV0ozwFPoAopdtYAAAFeWdXQgQ',
            ),
//            CURLOPT_POSTFIELDS => array('template_id=4415')
            CURLOPT_POSTFIELDS => $req->input("data")
        ));
        // Send the request & save response to $resp
        $resp = curl_exec($curl);
        // Close request to clear up some resources
        curl_close($curl);

        echo $resp;
    }
}