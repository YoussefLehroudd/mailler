<?php
// This file streams email sending progress in real-time using Server-Sent Events

// Set headers for SSE
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
header('Connection: keep-alive');
header('X-Accel-Buffering: no'); // Disable nginx buffering

// Disable output buffering
if (ob_get_level()) ob_end_clean();

// Function to send SSE message
function sendSSE($data) {
    echo "data: " . json_encode($data) . "\n\n";
    if (ob_get_level()) ob_flush();
    flush();
}

// Include backend with modifications for streaming
$_POST['stream'] = true; // Flag to indicate streaming mode

// Capture and stream output
ob_start();
include 'backend.php';
$output = ob_get_clean();

// Send final output
sendSSE(array('type' => 'complete', 'message' => $output));
?>