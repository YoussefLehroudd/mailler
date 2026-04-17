<?php
/**
 * Mailler Configuration for Railway + Local
 * Set these as Railway Environment Variables or .env
 */

// SMTP Config (optional - for SMTP mode)
define('SMTP_HOST', $_ENV['SMTP_HOST'] ?? $_ENV['smtp_server'] ?? '');
define('SMTP_PORT', $_ENV['SMTP_PORT'] ?? $_ENV['smtp_port'] ?? '587');
define('SMTP_USER', $_ENV['SMTP_USER'] ?? $_ENV['smtp_username'] ?? '');
define('SMTP_PASS', $_ENV['SMTP_PASS'] ?? $_ENV['smtp_password'] ?? '');
define('SMTP_SECURE', $_ENV['SMTP_SECURE'] ?? $_ENV['smtp_secure'] ?? 'tls'); // tls, ssl, empty

// Fallback sender for PHP mail() or no SMTP
define('FALLBACK_SENDER', $_ENV['FALLBACK_SENDER'] ?? 'no-reply@' . ($_ENV['RAILWAY_STATIC_URL'] ? parse_url($_ENV['RAILWAY_STATIC_URL'], PHP_URL_HOST) : 'localhost') . '.local');
define('FALLBACK_NAME', $_ENV['FALLBACK_NAME'] ?? 'Mailler Service');

// Security
define('MAX_EMAILS_PER_MINUTE', $_ENV['MAX_EMAILS_PER_MINUTE'] ?? 10);
define('RATE_LIMIT_WINDOW', 60); // seconds

// Railway detection
define('IS_RAILWAY', !empty($_ENV['RAILWAY_ENVIRONMENT']) || !empty($_ENV['RAILWAY_GIT_COMMIT_SHA']));

// Debug
define('DEBUG_MODE', $_ENV['DEBUG_MODE'] ?? false);

if (DEBUG_MODE) {
    error_log("Config loaded: SMTP=" . (SMTP_HOST ? 'YES' : 'NO') . ", Railway=" . (IS_RAILWAY ? 'YES' : 'NO'));
}
?>
