<?php
// check_stop.php - Stop flag management API

header('Content-Type: application/json');

$stopFlagFile = __DIR__ . '/stop_flag.txt';

// Handle POST request to set stop flag
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = isset($_POST['action']) ? $_POST['action'] : '';
    
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