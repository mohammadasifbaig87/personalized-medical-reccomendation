<?php
// process_symptoms.php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    $symptom = $data['symptom'];

    // Call the Python API to get recommendations
    $url = "http://127.0.0.1:5000/get_recommendations";  // Python Flask API endpoint
    $ch = curl_init($url);

    $payload = json_encode(["symptom" => $symptom]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);

    $response = curl_exec($ch);
    curl_close($ch);

    echo $response;
}
?>
