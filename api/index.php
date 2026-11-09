<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Setup temporary writable directories in /tmp for Vercel serverless environment
$storagePath = '/tmp/storage';
$dirs = [
    $storagePath . '/framework/views',
    $storagePath . '/framework/cache/data',
    $storagePath . '/framework/sessions',
    $storagePath . '/logs',
    $storagePath . '/app/public',
    '/tmp/bootstrap/cache',
];

foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
}

// Redirect cache & views to writable /tmp
putenv("APP_CONFIG_CACHE=/tmp/bootstrap/cache/config.php");
putenv("APP_EVENTS_CACHE=/tmp/bootstrap/cache/events.php");
putenv("APP_PACKAGES_CACHE=/tmp/bootstrap/cache/packages.php");
putenv("APP_ROUTES_CACHE=/tmp/bootstrap/cache/routes.php");
putenv("APP_SERVICES_CACHE=/tmp/bootstrap/cache/services.php");
putenv("VIEW_COMPILED_PATH={$storagePath}/framework/views");

require __DIR__ . '/../vendor/autoload.php';

/** @var \Illuminate\Foundation\Application $app */
$app = require_once __DIR__ . '/../bootstrap/app.php';

// Force Laravel to use writable /tmp storage on Vercel
if (method_exists($app, 'useStoragePath')) {
    $app->useStoragePath($storagePath);
}

$app->handleRequest(Request::capture());
