<?php
/**
 * Include this at the top of every file in /api.
 * Unlike require-auth.php (used by the HTML pages, which redirects to
 * login.php), this returns a JSON 401 response — because fetch() calls
 * expect JSON back, not an HTML redirect.
 */
session_start();
header('Content-Type: application/json');

require __DIR__ . '/../config/database.php';

if (empty($_SESSION['loggedInUserId'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Not authenticated. Please log in again.']);
    exit;
}

$userId = (int) $_SESSION['loggedInUserId'];

/**
 * Read JSON body (works for POST/DELETE sent with application/json)
 */
function readJsonBody(): array
{
    $data = json_decode(file_get_contents('php://input'), true);
    return is_array($data) ? $data : [];
}
