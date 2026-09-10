<?php
require __DIR__ . '/_auth.php';

$method = $_SERVER['REQUEST_METHOD'];

try {

    if ($method === 'GET') {

        $stmt = $pdo->prepare("SELECT currency, language FROM settings WHERE user_id = ?");
        $stmt->execute([$userId]);
        $row = $stmt->fetch();

        echo json_encode([
            'success'  => true,
            'currency' => $row['currency'] ?? 'KSh',
            'language' => $row['language'] ?? 'English',
        ]);
        exit;
    }

    if ($method === 'POST') {

        $body = array_merge($_POST, readJsonBody());
        $currency = trim($body['currency'] ?? 'KSh');
        $language = trim($body['language'] ?? 'English');

        $stmt = $pdo->prepare(
            "INSERT INTO settings (user_id, currency, language) VALUES (?, ?, ?)
             ON DUPLICATE KEY UPDATE currency = ?, language = ?"
        );
        $stmt->execute([$userId, $currency, $language, $currency, $language]);

        echo json_encode(['success' => true]);
        exit;
    }

    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed.']);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
