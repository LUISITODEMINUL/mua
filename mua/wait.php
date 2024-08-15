<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Generar uniqueID
    $uniqueID = $_SESSION['uniqueID'];
    $chatID = $_SESSION['chatID'];
    // Preparar los datos para enviar a la API
    $data = [
        'uniqueID' => $uniqueID,
        'chatID' => $chatID,
    ];

    // Configurar cURL
    $ch = curl_init($_SESSION['urlApi'] . 'waitResponse');
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