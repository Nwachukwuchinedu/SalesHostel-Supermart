<?php
// router.php

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$root = __DIR__;

// 1. Block direct access to .php files and explicit /index in the URL
// Check if the URI ends with .php or /index
if (substr($uri, -4) === '.php' || substr($uri, -6) === '/index') {
    http_response_code(404);
    include __DIR__ . '/404.php';
    exit;
}

// 2. Serve static files directly
if (file_exists($root . $uri) && !is_dir($root . $uri)) {
    return false; // Let PHP serve the file
}

// 3. Handle extensionless URLs (rewrite to .php)
$phpFile = $root . $uri . '.php';
if (file_exists($phpFile) && !is_dir($phpFile)) {
    // Fix for PHP_SELF and SCRIPT_NAME to match the included file
    $_SERVER['SCRIPT_NAME'] = $uri . '.php';
    $_SERVER['PHP_SELF'] = $uri . '.php';
    include $phpFile;
    exit;
}

// 4. Handle Directory Index
if (is_dir($root . $uri)) {
    $indexFile = rtrim($root . $uri, '/') . '/index.php';
    if (file_exists($indexFile)) {
        $_SERVER['SCRIPT_NAME'] = rtrim($uri, '/') . '/index.php';
        $_SERVER['PHP_SELF'] = rtrim($uri, '/') . '/index.php';
        include $indexFile;
        exit;
    }
}

// 5. 404 Not Found
http_response_code(404);
include __DIR__ . '/404.php';
?>
