<?php
require __DIR__ . '/_auth.php';

$method = $_SERVER['REQUEST_METHOD'];

try {

    if ($method === 'GET') {

        $stmt = $pdo->prepare(
            "SELECT id, trip, distance, litres, price, total_cost, cost_per_km, warning,
                    DATE_FORMAT(date, '%Y-%m-%d %H:%i') AS date
             FROM fuels WHERE user_id = ? ORDER BY id ASC"
        );
        $stmt->execute([$userId]);
        $rows = $stmt->fetchAll();

        foreach ($rows as &$r) {
            $r['id']          = (int) $r['id'];
            $r['distance']    = (float) $r['distance'];
            $r['litres']      = (float) $r['litres'];
            $r['price']       = (float) $r['price'];
            $r['total_cost']  = (float) $r['total_cost'];
            $r['cost_per_km'] = (float) $r['cost_per_km'];
        }

        echo json_encode(['success' => true, 'data' => $rows]);
        exit;
    }

    if ($method === 'POST') {

        $body = array_merge($_POST, readJsonBody());

        $trip     = trim($body['trip'] ?? '');
        $distance = (float) ($body['distance'] ?? 0);
        $litres   = (float) ($body['litres'] ?? 0);
        $price    = (float) ($body['price'] ?? 0);

        if ($trip === '' || $distance <= 0 || $litres <= 0 || $price <= 0) {
            echo json_encode(['success' => false, 'message' => 'Please fill in all fields with valid values.']);
            exit;
        }

        $totalCost = $litres * $price;
        $costPerKm = $distance > 0 ? $totalCost / $distance : 0;

        $warning = null;
        if ($litres < 20) {
            $warning = '⚠️ Low fuel purchase recorded';
        }

        $stmt = $pdo->prepare(
            "INSERT INTO fuels (user_id, trip, distance, litres, price, total_cost, cost_per_km, warning)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->execute([$userId, $trip, $distance, $litres, $price, $totalCost, $costPerKm, $warning]);

        echo json_encode(['success' => true, 'id' => (int) $pdo->lastInsertId()]);
        exit;
    }

    if ($method === 'DELETE') {

        $body = readJsonBody();
        $id   = (int) ($body['id'] ?? 0);

        $stmt = $pdo->prepare("DELETE FROM fuels WHERE id = ? AND user_id = ?");
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
