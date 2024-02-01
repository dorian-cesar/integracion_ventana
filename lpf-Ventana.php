<?php


$user="Ventana";


$pasw="123";

include "login/conexion.php";

Loop:
sleep(15);

$consulta="SELECT hash FROM masgps.hash where user='$user' and pasw='$pasw'";

$resutaldo= mysqli_query($mysqli,$consulta);

$data=mysqli_fetch_array($resutaldo);

$hash=$data['hash'];

$cap=$hash;


//header("refresh:2");
$listado = '';
$i=0;
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://www.trackermasgps.com/api-v2/tracker/list',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => '{"hash":"' . $cap . '"}',
  CURLOPT_HTTPHEADER => array(
    'Accept: application/json, text/plain, */*',
    'Accept-Language: es-419,es;q=0.9,en;q=0.8',
    'Connection: keep-alive',
    'Content-Type: application/json',
    'Cookie: _ga=GA1.2.728367267.1665672802; locale=es; _gid=GA1.2.967319985.1673009696; _gat=1; session_key=5d7875e2bf96b5966225688ddea8f098',
    'Origin: http://www.trackermasgps.com',
    'Referer: http://www.trackermasgps.com/',
    'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36'
  ),
));

$response2 = curl_exec($curl);

$json = json_decode($response2);

$array = $json->list;



//echo '[';
foreach ($array as $item) {

 
   $id = $item->id;
   $imei =$item->source->device_id;
  //echo " , &nbsp";
  

  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => 'http://www.trackermasgps.com/api-v2/tracker/get_state',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => '{"hash": "' . $cap . '", "tracker_id": ' . $id . '}',
    CURLOPT_HTTPHEADER => array(
      'Content-Type: application/json'
    ),
  ));


  $response2 = curl_exec($curl);

  curl_close($curl);

  $json2 = json_decode($response2);

  $lat = $array2 = $json2->state->gps->location->lat;
  
  $lng = $array2 = $json2->state->gps->location->lng;

  $last_u = $array2 = $json2->state->last_update;


  $ultima_Conexion=date("Y-m-d\TH:i:s", strtotime($last_u));

  $ultima_Conexion_utc_3 = $ultima_Conexion; // Guarda la fecha/hora en UTC-3 actual

  // Establecer la zona horaria de Santiago (UTC-3)
  $zona_horaria_santiago = new DateTimeZone('America/Santiago');
  
  // Crear un objeto DateTime con la fecha y hora en UTC-3
  $fecha_utc_3 = new DateTime($ultima_Conexion_utc_3, $zona_horaria_santiago);
  
  // Establecer la zona horaria a UTC (UTC+0)
  $zona_horaria_utc = new DateTimeZone('UTC');
  $fecha_utc_3->setTimezone($zona_horaria_utc);
  
  // Obtener la fecha y hora en formato deseado (UTC+0)
  $ultima_Conexion_utc_0 = $fecha_utc_3->format('Y-m-d\TH:i:s');
  
  // Reemplazar $ultima_Conexion con la fecha y hora en UTC+0
  $ultima_Conexion = $ultima_Conexion_utc_0;


  $plate = substr($item->label,0,7);

  $speed=$json2->state->gps->speed;
  $alt=$json2->state->gps->alt;

  $direccion=$json2->state->gps->heading;

  $connection_status=$json2->state->connection_status;

  $movement_status=$json2->state->movement_status;

  $signal_level=$json2->state->gps->signal_level;

  $ignicion=$json2->state->inputs[0];

  if($ignicion){$motor=1;}else{$motor=0;}

  date_default_timezone_set('UTC');
  
    $json3 =array (


      'id'=>$id,
      'asset'=>$plate,
      'dtgps'=>$ultima_Conexion, 
      'dtrx'=>date("Y-m-d\TH:i:s"),
      'lat'=>$lat,
      'lon'=>$lng,
      'alt'=>$alt,
      'spd'=>$speed,
      'angle'=>$direccion,
      'dop'=>1.1,
      'fix'=>1,
      //'signal_level'=>$signal_level,
      //'movement_status'=>$movement_status,
      'ign'=>($ignicion)?1:0,
      //'ignicion'=>$ignicion
      //'motor'=>$motor,
      
      
    );

    $total[$i]=$json3;

    $i++;

};
//echo
$payrol=json_encode($total, http_response_code(200));


$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://ws.migtra.com/rawdata/codelcodvenbus',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>$payrol,
  CURLOPT_HTTPHEADER => array(
    'Authorization: Basic Z3Bzd2l0OlZENDJoRmt2UTVuUjZBK3M=',
    'Content-Type: application/json'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;

echo "<br>";
goto Loop;







