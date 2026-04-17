<?php
$requestUri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$requestUri = is_string($requestUri) && $requestUri !== '' ? $requestUri : '/';

if ($requestUri !== '/') {
    $requestedFile = realpath(__DIR__ . $requestUri);
    if ($requestedFile !== false && strpos($requestedFile, realpath(__DIR__)) === 0 && is_file($requestedFile)) {
        return false;
    }
}

require __DIR__ . '/index.php';
