<?php
session_start();
header('Content-Type: application/json');

require __DIR__ . '/config/database.php';

/**
 * Send JSON response and stop execution
 */
function jsonResponse($success, $message, $extra = [])
{
    echo json_encode(array_merge([
        'success' => $success,
        'message' => $message
    ], $extra));

    exit;
}

try {

    // Read JSON body
    $request = json_decode(file_get_contents('php://input'), true);

    if (!is_array($request)) {
        $request = [];
    }

    // Get values from POST, GET, or JSON
    $action = $_POST['action']
        ?? $_GET['action']
        ?? $request['action']
        ?? '';

    $username = trim(
        $_POST['username']
        ?? $request['username']
        ?? ''
    );

    $password = $_POST['password']
        ?? $request['password']
        ?? '';

    // Validate action
    if (!in_array($action, ['login', 'register', 'logout'], true)) {
        jsonResponse(false, 'Invalid action.');
    }

    // Logout
    if ($action === 'logout') {
        session_unset();
        session_destroy();
        jsonResponse(true, 'Logged out successfully.');
    }

    // Validate input
    if ($username === '' || $password === '') {
        jsonResponse(false, 'Please enter username and password.');
    }

    /*
    ==================
    REGISTER
    ==================
    */
    if ($action === 'register') {

        // Check if username exists
        $stmt = $pdo->prepare(
            "SELECT id FROM users WHERE username = ?"
        );
        $stmt->execute([$username]);

        if ($stmt->fetch()) {
            jsonResponse(false, 'Username already exists.');
        }

        // Hash password
        $hash = password_hash($password, PASSWORD_DEFAULT);

        // Insert user
        $stmt = $pdo->prepare(
            "INSERT INTO users (username, password) VALUES (?, ?)"
        );

        if ($stmt->execute([$username, $hash])) {

            jsonResponse(
                true,
                'Account created successfully!'
            );
        }

        jsonResponse(false, 'Registration failed.');
    }

    /*
    ==================
    LOGIN
    ==================
    */
    if ($action === 'login') {

        $stmt = $pdo->prepare(
            "SELECT id, username, password
             FROM users
             WHERE username = ?"
        );

        $stmt->execute([$username]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            jsonResponse(false, 'Invalid username or password.');
        }

        if (!password_verify($password, $user['password'])) {
            jsonResponse(false, 'Invalid username or password.');
        }

        // Store session
        $_SESSION['loggedInUser'] = $user['username'];
        $_SESSION['loggedInUserId'] = (int)$user['id'];

        jsonResponse(true, 'Login successful!');
    }

} catch (PDOException $e) {

    jsonResponse(false, 'Database error: ' . $e->getMessage());

} catch (Exception $e) {

    jsonResponse(false, 'Error: ' . $e->getMessage());
}
?>