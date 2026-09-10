<?php
require __DIR__ . '/_auth.php';

$method = $_SERVER['REQUEST_METHOD'];

try {

    if ($method === 'GET') {

        $stmt = $pdo->prepare(
            "SELECT id, amount, category, description, DATE_FORMAT(date, '%Y-%m-%d %H:%i') AS date
             FROM expenses WHERE user_id = ? ORDER BY id ASC"
        );
        $stmt->execute([$userId]);
        $rows = $stmt->fetchAll();

        foreach ($rows as &$r) {
            $r['amount'] = (float) $r['amount'];
            $r['id'] = (int) $r['id'];
        }

        echo json_encode(['success' => true, 'data' => $rows]);
        exit;
    }

    if ($method === 'POST') {

        $body = array_merge($_POST, readJsonBody());

        $amount      = (float) ($body['amount'] ?? 0);
        $category    = trim($body['category'] ?? 'Other');
        $description = trim($body['description'] ?? '');

        if ($amount <= 0) {
            echo json_encode(['success' => false, 'message' => 'Invalid amount.']);
            exit;
        }

        $stmt = $pdo->prepare(
            "INSERT INTO expenses (user_id, amount, category, description) VALUES (?, ?, ?, ?)"
        );
        $stmt->execute([$userId, $amount, $category, $description]);

        echo json_encode(['success' => true, 'id' => (int) $pdo->lastInsertId()]);
        exit;
    }

    if ($method === 'DELETE') {

        $body = readJsonBody();
        $id   = (int) ($body['id'] ?? 0);

        $stmt = $pdo->prepare("DELETE FROM expenses WHERE id = ? AND user_id = ?");
        $stmt->execute([$id, $userId]);

        echo json_encode(['success' => true]);
        exit;
    }

    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed.']);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
