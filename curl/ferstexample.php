<?php
$ch = curl_init("http://drpepper.net.ua");
$fp = fopen("example_homepage.txt", "w");

curl_setopt($ch, CURLOPT_URL,$fp);
curl_setopt($ch, CURLOPT_HEADER, 1); // читать заголовок
curl_setopt($ch, CURLOPT_NOBODY, 1); // читать ТОЛЬКО заголовок без тела
$result = curl_exec($ch);
curl_close($ch);
//echo $result;
fclose($fp);
?>