<?php
// Build a static design preview. The production PHP site and mail configuration are unchanged.
declare(strict_types=1);
if (PHP_SAPI !== 'cli') { http_response_code(403); exit; }
putenv('MIPS_PRIVATE_DIR=' . sys_get_temp_dir() . '/manila-preview-build');
define('MIPS', true);
require dirname(__DIR__) . '/public_html/app/bootstrap.php';
$GLOBALS['config']['env'] = 'staging';
$GLOBALS['config']['form_secret'] = bin2hex(random_bytes(32));
$GLOBALS['config']['mail']['transport'] = 'log';
$routes = require APP_DIR . '/routes.php';
$GLOBALS['routes'] = $routes;
$out = dirname(__DIR__) . '/static-preview';
if (!is_dir($out) && !mkdir($out, 0755, true)) throw new RuntimeException('Cannot create preview output');

// Preserve navigation and inline validation; prevent every form from transmitting data.
$script = file_get_contents(PUBLIC_DIR . '/assets/js/site.js');
$needle = "      if (!window.fetch || !window.FormData) return;";
if (substr_count($script, $needle) !== 1) throw new RuntimeException('Form submit guard needs updating');
$script = str_replace($needle, "      e.preventDefault();\n      showStatus('success', 'Preview only: your details have not been sent.');\n      return;\n" . $needle, $script);

foreach ($routes['pages'] as $key => $page) {
    $page += ['key' => $key, 'path' => $key === '' ? '/' : '/' . $key . '/'];
    ob_start();
    render_page($page);
    $html = (string)ob_get_clean();
    $html = preg_replace('/<input\b[^>]*type="hidden"[^>]*>/i', '', $html);
    // Read-only preview forms also stay harmless when JavaScript is disabled.
    $html = preg_replace('/<form\b([^>]*)\bmethod="post"([^>]*)>/', '<form$1method="get"$2>', $html);
    $html = preg_replace('/(<input|<select|<textarea)\b([^>]*?)\sname="[^"]*"/i', '$1$2', $html);
    $html = str_replace('data-form>', 'data-form><p class="note">Design preview only. Form details will not be sent.</p>', $html);
    $dir = $out . ($key === '' ? '' : '/' . $key);
    if (!is_dir($dir) && !mkdir($dir, 0755, true)) throw new RuntimeException('Cannot create page directory');
    if (file_put_contents($dir . '/index.html', $html) === false) throw new RuntimeException('Cannot write page');
}

$assets = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(PUBLIC_DIR . '/assets', FilesystemIterator::SKIP_DOTS));
foreach ($assets as $file) {
    if (!$file->isFile() || $file->getFilename() === '.htaccess') continue;
    $relative = substr($file->getPathname(), strlen(PUBLIC_DIR) + 1);
    $dest = $out . '/' . $relative;
    if (!is_dir(dirname($dest))) mkdir(dirname($dest), 0755, true);
    if (!copy($file->getPathname(), $dest)) throw new RuntimeException('Cannot copy asset');
}
file_put_contents($out . '/assets/js/site.js', $script);
foreach (['favicon.ico', 'site.webmanifest'] as $file) copy(PUBLIC_DIR . '/' . $file, $out . '/' . $file);
file_put_contents($out . '/robots.txt', "User-agent: *\nDisallow: /\n");
echo 'Exported ' . count($routes['pages']) . ' pages to static-preview. Form email sending is disabled.' . PHP_EOL;
