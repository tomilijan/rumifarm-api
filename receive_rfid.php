<?php
// receive_rfid.php — Handles incoming RFID data from ESP32

// Load config (database credentials)
require_once 'config.php';

header("Content-Type: application/json");

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['error' => 'Invalid request method']);
    exit;
}

$rfid_tag = $_POST['rfid_tag'] ?? '';

if (empty($rfid_tag)) {
    echo json_encode(['error' => 'Missing RFID tag']);
    exit;
}

try {
    $db = Database::getInstance()->getConnection();

    // Update last_scanned in your ruminants table
    $stmt = $db->prepare("UPDATE ruminants SET last_scanned = NOW() WHERE rfid_tag = ?");
    $stmt->execute([$rfid_tag]);

    if ($stmt->rowCount() > 0) {
        echo json_encode(['status' => 'success', 'rfid_tag' => $rfid_tag]);
    } else {
        echo json_encode(['status' => 'not_found', 'rfid_tag' => $rfid_tag]);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
