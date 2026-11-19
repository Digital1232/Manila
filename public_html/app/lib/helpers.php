<?php
// Small, dependency-free helpers shared by the router and templates.
defined('MIPS') || exit;

/** Read a config value using dot notation, e.g. cfg('mail.transport'). */
function cfg(string $key, $default = null)
{
    $value = $GLOBALS['config'] ?? [];
    foreach (explode('.', $key) as $part) {
        if (!is_array($value) || !array_key_exists($part, $value)) return $default;
        $value = $value[$part];
    }
    return $value;
}

/** Escape text for HTML output. */
function e($value): string
{
    return htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function site(): array
{
    static $site = null;
    return $site ??= require APP_DIR . '/data/site.php';
}

function courses(): array
{
    static $courses = null;
    return $courses ??= require APP_DIR . '/data/courses.php';
}

function course_url(string $key): string
{
    return '/courses/' . courses()[$key]['slug'] . '/';
}

/** Absolute URL on the canonical domain, used for canonical links, sitemap and structured data. */
function abs_url(string $path = '/'): string
{
    return rtrim((string)cfg('site_url', 'https://manilainstitute.com'), '/') . $path;
}

/** Asset URL with a cache-busting version derived from the file's modification time. */
function asset(string $path): string
{
    $file = PUBLIC_DIR . '/assets/' . $path;
    return '/assets/' . $path . (is_file($file) ? '?v=' . base_convert((string)filemtime($file), 10, 36) : '');
}

/**
 * Responsive <img>: adds width/height (prevents layout shift), srcset from "-{width}w.webp" variants,
 * lazy loading by default. $opts: class, sizes, eager (bool), priority (bool).
 */
function img(string $path, string $alt, array $opts = []): string
{
    $file = PUBLIC_DIR . '/assets/img/' . $path;
    $size = is_file($file) ? @getimagesize($file) : false;
    $attrs = ['src' => '/assets/img/' . $path, 'alt' => $alt];
    if ($size) {
        $attrs['width'] = (string)$size[0];
        $attrs['height'] = (string)$size[1];
        $variants = glob(preg_replace('/\.webp$/', '-*w.webp', $file)) ?: [];
        if ($variants) {
            $set = [];
            foreach ($variants as $v) {
                if (preg_match('/-(\d+)w\.webp$/', $v, $m)) $set[(int)$m[1]] = '/assets/img/' . dirname($path) . '/' . basename($v) . ' ' . $m[1] . 'w';
            }
            ksort($set);
            $set[$size[0]] = '/assets/img/' . $path . ' ' . $size[0] . 'w';
            $attrs['srcset'] = implode(', ', $set);
            $attrs['sizes'] = $opts['sizes'] ?? '(min-width: 1200px) 600px, 100vw';
        }
    }
    if (!empty($opts['class'])) $attrs['class'] = $opts['class'];
    if (!empty($opts['priority'])) {
        $attrs['fetchpriority'] = 'high';
        $attrs['decoding'] = 'async';
    } elseif (empty($opts['eager'])) {
        $attrs['loading'] = 'lazy';
        $attrs['decoding'] = 'async';
    }
    $html = '<img';
    foreach ($attrs as $k => $v) $html .= ' ' . $k . '="' . e($v) . '"';
    return $html . '>';
}

/** Inline SVG icon from the sprite in the layout. */
function icon(string $name, string $class = 'icon'): string
{
    return '<svg class="' . e($class) . '" aria-hidden="true" focusable="false"><use href="#i-' . e($name) . '"></use></svg>';
}

function tel_href(string $phone): string
{
    return 'tel:' . preg_replace('/[^\d+]/', '', $phone);
}

function whatsapp_href(string $text = ''): string
{
    return 'https://wa.me/' . site()['whatsapp'] . ($text !== '' ? '?text=' . rawurlencode($text) : '');
}

/** Render a partial template with the given variables. */
function partial(string $name, array $vars = []): void
{
    extract($vars, EXTR_SKIP);
    include APP_DIR . '/views/partials/' . $name . '.php';
}

function is_https(): bool
{
    return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https')
        || (($_SERVER['SERVER_PORT'] ?? '') === '443');
}

function send_security_headers(): void
{
    header_remove('X-Powered-By');
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: SAMEORIGIN');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header('Permissions-Policy: camera=(), microphone=(), geolocation=(), payment=(), usb=(), interest-cohort=()');
    header("Content-Security-Policy: default-src 'self'; img-src 'self' data:; style-src 'self'; script-src 'self'; font-src 'self'; "
        . "connect-src 'self'; frame-src https://www.google.com https://maps.google.com; form-action 'self'; base-uri 'self'; "
        . "frame-ancestors 'self'; object-src 'none'" . (is_https() ? '; upgrade-insecure-requests' : ''));
    if (is_https()) header('Strict-Transport-Security: max-age=31536000');
}

/** Current request path without leading/trailing slashes, e.g. "courses/diploma-in-...". */
function request_path(): string
{
    $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
    $path = rawurldecode($path);
    $path = preg_replace('#/+#', '/', $path);
    return trim($path, '/');
}

function redirect(string $to, int $code = 301): void
{
    header('Location: ' . $to, true, $code);
    header('Cache-Control: no-cache');
    exit;
}

function json_response(array $data, int $code = 200): void
{
    http_response_code($code);
    header('Content-Type: application/json; charset=utf-8');
    header('Cache-Control: no-store');
    echo json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    exit;
}

function wants_json(): bool
{
    return str_contains($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json');
}

function client_ip(): string
{
    return (string)($_SERVER['REMOTE_ADDR'] ?? '0.0.0.0');
}

function private_path(string $sub = ''): string
{
    return PRIVATE_DIR . ($sub !== '' ? '/' . ltrim($sub, '/') : '');
}

/** Make sure a directory inside private storage exists; returns its path or null if not writable. */
function storage_dir(string $sub): ?string
{
    $dir = private_path('storage/' . $sub);
    if (!is_dir($dir) && !@mkdir($dir, 0750, true) && !is_dir($dir)) return null;
    return is_writable($dir) ? $dir : null;
}
