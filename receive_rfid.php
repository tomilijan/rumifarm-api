<?php
header('Content-Type: application/json');
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rfid_tag = $_POST['rfid_tag'] ?? null;

    if (!$rfid_tag) {
        echo json_encode(['error' => 'No RFID tag received']);
        exit;
    }

    try {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("INSERT INTO ruminants (rfid_tag, last_scanned) VALUES (?, NOW())
            ON DUPLICATE KEY UPDATE last_scanned = NOW()");
        $stmt->execute([$rfid_tag]);

        echo json_encode(['success' => true, 'rfid_tag' => $rfid_tag]);
    } catch (Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Invalid request method']);
}
?>
