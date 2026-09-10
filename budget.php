<?php
require __DIR__ . '/_auth.php';

$method = $_SERVER['REQUEST_METHOD'];

try {

    if ($method === 'GET') {

        $stmt = $pdo->prepare("SELECT amount FROM budgets WHERE user_id = ?");
        $stmt->execute([$userId]);
        $row = $stmt->fetch();

        echo json_encode(['success' => true, 'budget' => $row ? (float) $row['amount'] : 0]);
        exit;
    }

    if ($method === 'POST') {

        $body = array_merge($_POST, readJsonBody());
        $amount = (float) ($body['amount'] ?? 0);

        if ($amount < 0) {
            echo json_encode(['success' => false, 'message' => 'Invalid budget amount.']);
            exit;
        }

        $stmt = $pdo->prepare(
            "INSERT INTO budgets (user_id, amount) VALUES (?, ?)
             ON DUPLICATE KEY UPDATE amount = ?"
        );
        $stmt->execute([$userId, $amount, $amount]);

        echo json_encode(['success' => true, 'budget' => $amount]);
        exit;
    }

    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed.']);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
