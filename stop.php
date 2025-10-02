<?php
// Start session FIRST to get the correct session ID
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Create stop flag file using the session ID with proper directory separator
$stop_file = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'mailer_stop_' . session_id();
file_put_contents($stop_file, '1');

echo json_encode(['status' => 'stopped', 'file' => $stop_file]);
?>
