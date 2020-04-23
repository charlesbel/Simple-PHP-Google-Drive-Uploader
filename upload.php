<?php

$url = 'https://oauth2.googleapis.com/token';
$headers = array('Content-Type: application/x-www-form-urlencoded');
$postdata = 'client_id=YOUR_CLIENT_ID&client_secret=YOUR_CLIENT_SECRET&grant_type=refresh_token&refresh_token=YOUR_REFRESH_TOKEN';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
$response = curl_exec($ch);
curl_close($ch);

$response = json_decode($response, true);
$token = $response["access_token"];


$url = "https://www.googleapis.com/upload/drive/v2/files?uploadType=multipart";
   
$headers = array(
    "Content-Type: multipart/related; boundary=287032381131322",
    "Authorization: Bearer " . $token
    );
   
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_BINARYTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_POST, true);
$postdata = '
--287032381131322
Content-Type: application/json

{
  "title": "' . $_FILES['file']['name'] . '",
  "mimeType": "' . $_FILES['file']['type'] . '"
}
--287032381131322
Content-Type: ' . $_FILES['file']['type'] . '

' . file_get_contents($_FILES['file']['tmp_name']) . '
--287032381131322--
';
curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
   
$output = curl_exec($ch);
curl_close($ch);

echo $output;

?>
