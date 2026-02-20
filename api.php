<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

// APNA GOOGLE SCRIPT URL YAHAN DALEIN
$API_URL = "https://script.google.com/macros/s/AKfycbzPyWTkn5L94I9PJ5KM_JNonvb8dOTpEA4tbqKC7d2j8I10W7xMsHHeOCroXcimWsy6jQ/exec";

$json_input = file_get_contents("php://input");
$input_data = json_decode($json_input, true);

if (!$input_data) {
    echo json_encode(["status" => "error", "message" => "No data received"]);
    exit;
}

// Data ko URL Query String mein convert karna (?action=login&phone=...)
$query_string = http_build_query($input_data);
$final_url = $API_URL . "?" . $query_string;

$ch = curl_init($final_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($ch);
curl_close($ch);

echo $response;

?>
