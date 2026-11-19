<?php
// Local development router for PHP's built-in server; mirrors the rules in public_html/.htaccess.
//   php -S localhost:8090 -t public_html dev/router.php
$root = realpath(__DIR__ . '/../public_html');
$path = rawurldecode(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/');

if (preg_match('#(^|/)\.(?!well-known/)#', $path) || preg_match('#^/app(/|$)#i', $path)) {
    http_response_code(403);
    echo 'Forbidden';
    return true;
}
// Dev-only helper (never deployed): shows a page in an iframe of a fixed width, so headless Chrome
// can capture true phone and tablet layouts.   /__dev/frame?w=390&h=16000&url=/about-us/
if ($path === '/__dev/frame') {
    $w = max(320, min(1600, (int)($_GET['w'] ?? 390)));
    $h = max(600, min(20000, (int)($_GET['h'] ?? 16000)));
    $url = (string)($_GET['url'] ?? '/');
    if (!str_starts_with($url, '/') || str_starts_with($url, '//')) $url = '/';
    header('Content-Type: text/html; charset=utf-8');
    echo '<!doctype html><meta charset="utf-8"><style>html,body{margin:0;background:#fff}iframe{display:block;border:0}</style>'
        . '<iframe src="' . htmlspecialchars($url, ENT_QUOTES) . '" width="' . $w . '" height="' . $h . '"></iframe>';
    return true;
}
$file = realpath($root . $path);
if ($path !== '/' && $file && is_file($file) && str_starts_with($file, $root) && !preg_match('/\.(php\d?|phtml|phar)$/i', $file)) {
    if (preg_match('/\.(bak|old|sql|gz|tar|zip|log|ini|env|md)$/i', $file)) {
        http_response_code(403);
        echo 'Forbidden';
        return true;
    }
    $types = ['css' => 'text/css', 'js' => 'application/javascript', 'webp' => 'image/webp', 'png' => 'image/png', 'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg', 'svg' => 'image/svg+xml', 'ico' => 'image/x-icon', 'woff2' => 'font/woff2', 'webmanifest' => 'application/manifest+json',
        'txt' => 'text/plain', 'xml' => 'application/xml', 'json' => 'application/json'];
    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
    header('Content-Type: ' . ($types[$ext] ?? 'application/octet-stream'));
    header('X-Content-Type-Options: nosniff');
    header('Cache-Control: no-cache');
    header('Content-Length: ' . filesize($file));
    readfile($file);
    return true;
}
$_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['SCRIPT_FILENAME'] = $root . '/index.php';
chdir($root);
require $root . '/index.php';
