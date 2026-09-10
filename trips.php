<?php
require __DIR__ . '/_auth.php';

$method = $_SERVER['REQUEST_METHOD'];

try {

    if ($method === 'GET') {

        $stmt = $pdo->prepare(
            "SELECT id, origin, destination, distance, fuel_used, fuel_price, trip_cost, consumption,
                    DATE_FORMAT(date, '%Y-%m-%d %H:%i') AS date
             FROM trips WHERE user_id = ? ORDER BY id ASC"
        );
        $stmt->execute([$userId]);
        $rows = $stmt->fetchAll();

        foreach ($rows as &$r) {
            $r['id']          = (int) $r['id'];
            $r['distance']    = (float) $r['distance'];
            $r['fuel_used']   = (float) $r['fuel_used'];
            $r['fuel_price']  = (float) $r['fuel_price'];
            $r['trip_cost']   = (float) $r['trip_cost'];
            $r['consumption'] = (float) $r['consumption'];
        }

        echo json_encode(['success' => true, 'data' => $rows]);
        exit;
    }

    if ($method === 'POST') {

        $body = array_merge($_POST, readJsonBody());

        $origin      = trim($body['origin'] ?? '');
        $destination = trim($body['destination'] ?? '');
        $distance    = (float) ($body['distance'] ?? 0);
        $fuelUsed    = (float) ($body['fuelUsed'] ?? 0);
        $fuelPrice   = (float) ($body['fuelPrice'] ?? 0);

        if ($origin === '' || $destination === '' || $distance <= 0 || $fuelUsed <= 0 || $fuelPrice <= 0) {
            echo json_encode(['success' => false, 'message' => 'Please fill in all fields with valid values.']);
            exit;
        }

        $tripCost   = $fuelUsed * $fuelPrice;
        $consumption = $fuelUsed > 0 ? $distance / $fuelUsed : 0; // KM per litre

        $stmt = $pdo->prepare(
            "INSERT INTO trips (user_id, origin, destination, distance, fuel_used, fuel_price, trip_cost, consumption)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->execute([$userId, $origin, $destination, $distance, $fuelUsed, $fuelPrice, $tripCost, $consumption]);

        echo json_encode(['success' => true, 'id' => (int) $pdo->lastInsertId()]);
        exit;
    }

    if ($method === 'DELETE') {

        $body = readJsonBody();
        $id   = (int) ($body['id'] ?? 0);

        $stmt = $pdo->prepare("DELETE FROM trips WHERE id = ? AND user_id = ?");
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
