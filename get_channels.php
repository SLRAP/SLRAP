<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

require_once 'db.php';

try {
    // Database එකේ ඇති Channels සියල්ල ලබාගැනීම
    $stmt = $pdo->prepare("SELECT channel_id, channel_title FROM channels ORDER BY last_synced_at DESC");
    $stmt->execute();
    $channels = $stmt->fetchAll();

    echo json_encode([
        "status" => "success",
        "data" => $channels
    ]);
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => "Failed to fetch channels"]);
}
?>
