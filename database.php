<?php
/**
 * Database connection
 * ---------------------------------------------------
 * Edit the four values below to match your MySQL setup
 * (e.g. the credentials shown in phpMyAdmin / XAMPP / your host).
 */
$host    = 'localhost';
$dbName  = 'budget_trucker';
$dbUser  = 'root';
$dbPass  = '';
$charset = 'utf8mb4';

$dsn = "mysql:host={$host};dbname={$dbName};charset={$charset}";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $dbUser, $dbPass, $options);
} catch (PDOException $e) {

    // If the request is for an API endpoint, fail with JSON instead of an HTML error page
    $isApi = strpos($_SERVER['SCRIPT_NAME'] ?? '', '/api/') !== false;

    http_response_code(500);

    if ($isApi) {
        header('Content-Type: application/json');
        echo json_encode([
            'success' => false,
            'message' => 'Database connection failed. Check config/database.php — ' . $e->getMessage()
        ]);
    } else {
        echo '<h2 style="font-family:sans-serif;color:#922b21">Database connection failed</h2>';
        echo '<p style="font-family:sans-serif">Please check the credentials in <code>config/database.php</code> and make sure the <code>budget_trucker</code> database has been imported from <code>database.sql</code>.</p>';
        echo '<p style="font-family:monospace;color:#888">' . htmlspecialchars($e->getMessage()) . '</p>';
    }
    exit;
}
