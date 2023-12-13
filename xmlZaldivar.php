<?php 


$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://wspos.samtech.cl/WSP.asmx',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'<?xml version="1.0" encoding="utf-8"?><soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope"><soap12:Body><Post_XML xmlns="samtechpos"><xmldoc>
<![CDATA[
<datos>
  <movil>
    <pgps>Wit</pgps>
    <empresa>cimcmz</empresa>
    <tercero>Tandem</tercero>
    <pat>'.$plate.'</pat>
    <fn>'.$ultima_Conexion.'</fn>
    <lat>'.$lat.'</lat>
    <lon>'.$lng.'</lon>
    <ori>'.$direccion.'</ori>
    <vel>'.$speed.'</vel>
    <mot>'.$motor.'</mot>
    <hdop>'.$signal_level.'</hdop>
    <odo>'.$odometro.'</odo>
    <eve>46</eve>
    <conductor>No asignado</conductor>
    <numSAT>5</numSAT>
    <sens1>0</sens1>
    <sens2>0</sens2>
  </movil>
  <usuario xmlns="user">
    <login>witla1</login>
    <clave>W1tG2p$l4.</clave>
  </usuario>
</datos>
]]>
</xmldoc>
</Post_XML>
</soap12:Body>
</soap12:Envelope>
',
  CURLOPT_HTTPHEADER => array(
    'content-type: application/soap+xml; charset=utf-8'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo "$plate $response";
echo "<br>";
 