<?php
// Start session FIRST before any output
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Real-time streaming email sending - NO BUFFERING

// Disable ALL output buffering at PHP level
@ini_set('output_buffering', 'off');
@ini_set('zlib.output_compression', 0);
@ini_set('implicit_flush', 1);

// Clear all existing output buffers
while (@ob_end_flush());

// Enable implicit flush
ob_implicit_flush(true);

// Set headers to prevent buffering
header('Content-Type: text/html; charset=UTF-8');
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');
header('X-Accel-Buffering: no');

// Pad output (1KB) to overcome browser buffering threshold
echo str_repeat(' ', 1024);
flush();

// Initialize stop flag - clear any existing stop signal
$stopFlagFile = __DIR__ . '/stop_flag.txt';
if(file_exists($stopFlagFile)) {
    unlink($stopFlagFile);
}

// Include backend - output will stream in real-time
include 'backend.php';

// Clean up stop flag after sending completes
if(file_exists($stopFlagFile)) {
    unlink($stopFlagFile);
}
?>
