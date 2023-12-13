<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://ws.migtra.com/rawtest/codelcodvenbus',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'[
{ 
"id": 129192910, 
"asset": "ABCD12", 
"dtgps": "2019-03-21T20:40:35", 
"dtrx": "2019-03-21T20:41:25", 
"lat": -33.1234567, 
"lon": -70.1234567, 
"alt": 2401, 
"spd": 25, 
"angle": 125, 
"dop": 1.1, 
"fix": 1, 
"ign": 1 
}
]
',
  CURLOPT_HTTPHEADER => array(
    'Authorization: Basic Z3Bzd2l0OlZENDJoRmt2UTVuUjZBK3M=',
    'Content-Type: application/json'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
