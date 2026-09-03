<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

require_once 'db.php';

// Frontend එකෙන් එන JSON data ලබාගැනීම
$data = json_decode(file_get_contents('php://input'), true);

if (!empty($data['google_id']) && !empty($data['email'])) {
    $google_id   = $data['google_id'];
    $name        = $data['name'];
    $email       = $data['email'];
    $profile_pic = $data['profile_pic'] ?? '';

    try {
        // User කලින් DB එකේ ඉන්නවද බලන්න
        $stmt = $pdo->prepare("SELECT id FROM users WHERE google_id = ?");
        $stmt->execute([$google_id]);
        $user = $stmt->fetch();

        if (!$user) {
            // අලුත් User කෙනෙක් නම් DB එකට Insert කරන්න
            $insertStmt = $pdo->prepare("INSERT INTO users (google_id, name, email, profile_pic) VALUES (?, ?, ?, ?)");
            $insertStmt->execute([$google_id, $name, $email, $profile_pic]);
            $user_id = $pdo->lastInsertId();
        } else {
            $user_id = $user['id'];
        }

        echo json_encode([
            "status" => "success",
            "user_id" => $user_id,
            "message" => "User authenticated and saved successfully"
        ]);
    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => "Database error: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid input data"]);
}
?>
