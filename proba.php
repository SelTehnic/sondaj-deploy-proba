<?php
// Pagină de probă pentru instalarea Sondaj Live pe cPanel. Nu conține date și se șterge după probă.
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');

$extensii = ['bcmath', 'ctype', 'curl', 'dom', 'fileinfo', 'filter', 'gd', 'intl', 'json', 'mbstring',
    'openssl', 'pdo_mysql', 'redis', 'session', 'sodium', 'tokenizer', 'xml', 'zip'];

$opcache = function_exists('opcache_get_status') ? @opcache_get_status(false) : false;

echo json_encode([
    'versiune_proba' => 1,
    'sapi' => PHP_SAPI,
    'php' => PHP_VERSION,
    'server' => $_SERVER['SERVER_SOFTWARE'] ?? null,
    'pid' => getmypid(),
    'open_basedir' => ini_get('open_basedir'),
    'memory_limit' => ini_get('memory_limit'),
    'opcache_activ' => is_array($opcache) ? ($opcache['opcache_enabled'] ?? false) : false,
    'script_deja_in_opcache' => function_exists('opcache_is_script_cached') ? opcache_is_script_cached(__FILE__) : null,
    'extensii_lipsa' => array_values(array_filter($extensii, fn ($e) => !extension_loaded($e))),
    'timp_ms' => round((microtime(true) - $_SERVER['REQUEST_TIME_FLOAT']) * 1000, 2),
], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES), "\n";
