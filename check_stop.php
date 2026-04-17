<?php
// check_stop.php - Stop flag management API

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');

function getStopFlagFilePath()
{
    $sessionId = session_id();
    if ($sessionId === '') {
        $sessionId = 'guest';
    }

    return sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'mailler_stop_' . sha1($sessionId) . '.flag';
}

function isValidCsrfToken($token)
{
    return isset($_SESSION['csrf_token']) && is_string($token) && hash_equals($_SESSION['csrf_token'], $token);
}

$stopFlagFile = getStopFlagFilePath();

// Handle POST request to set stop flag
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = isset($_POST['action']) ? $_POST['action'] : '';
    $csrfToken = $_POST['csrf_token'] ?? '';

    if (!isValidCsrfToken($csrfToken)) {
        http_response_code(403);
        echo json_encode(['success' => false, 'message' => 'Invalid CSRF token']);
        exit;
    }
    
    if ($action === 'stop') {
        // Set stop flag
        file_put_contents($stopFlagFile, '1');
        echo json_encode(['success' => true, 'message' => 'Stop signal sent']);
    } elseif ($action === 'reset') {
        // Clear stop flag
        if (file_exists($stopFlagFile)) {
            unlink($stopFlagFile);
        }
        echo json_encode(['success' => true, 'message' => 'Stop flag cleared']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
    }
    exit;
}

// Handle GET request to check stop flag
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $shouldStop = file_exists($stopFlagFile) && file_get_contents($stopFlagFile) === '1';
    echo json_encode(['shouldStop' => $shouldStop]);
    exit;
}

echo json_encode(['success' => false, 'message' => 'Invalid request method']);
?>
