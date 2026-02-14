<?php

/**
 * This file is a bootstrap for XAMPP default configuration
 * It loads the Symfony application from public/index.php
 * For production, configure Apache VirtualHost to point DocumentRoot to public/
 */

// Adjust REQUEST_URI to remove the project base path
$requestUri = $_SERVER['REQUEST_URI'] ?? '/';

// Extract query string
$queryString = '';
if (($pos = strpos($requestUri, '?')) !== false) {
    $queryString = substr($requestUri, $pos);
    $requestUri = substr($requestUri, 0, $pos);
}

// Get the base path (e.g., /santeplus)
$scriptName = $_SERVER['SCRIPT_NAME'] ?? '/index.php';
$basePath = dirname($scriptName);
if ($basePath === '/' || $basePath === '\\' || $basePath === '.') {
    $basePath = '';
} else {
    $basePath = rtrim($basePath, '/');
}

// Remove the base path from REQUEST_URI
if ($basePath !== '' && strpos($requestUri, $basePath) === 0) {
    $requestUri = substr($requestUri, strlen($basePath));
}

// Remove /public if present
if (strpos($requestUri, '/public') === 0) {
    $requestUri = substr($requestUri, 7);
}

// Ensure we have at least a slash
if ($requestUri === '' || $requestUri[0] !== '/') {
    $requestUri = '/' . $requestUri;
}

// Update REQUEST_URI
$_SERVER['REQUEST_URI'] = $requestUri . $queryString;

// Update SCRIPT_NAME to point to public/index.php
$_SERVER['SCRIPT_NAME'] = ($basePath !== '' ? $basePath : '') . '/public/index.php';

// Change to public directory
chdir(__DIR__ . '/public');

// Include the Symfony front controller
// We need to capture the return value and return it
$kernelLoader = require __DIR__ . '/public/index.php';

// Return the kernel loader function
return $kernelLoader;

