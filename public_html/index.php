<?php
// Front controller: every request that is not a real file comes through here (see .htaccess).
define('MIPS', true);
require __DIR__ . '/app/bootstrap.php';

$routes = require APP_DIR . '/routes.php';
$method = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
$rawPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$key = strtolower(request_path());

send_security_headers();
if (cfg('env') !== 'production') header('X-Robots-Tag: noindex, nofollow');

if (!in_array($method, ['GET', 'HEAD', 'POST'], true)) {
    header('Allow: GET, HEAD, POST');
    render_error(405);
}

// Generated files
if ($key === 'sitemap.xml') render_sitemap($routes['pages']);
if ($key === 'robots.txt') render_robots();

// Old WordPress links such as /?page_id=6281
if ($key === '' && $method !== 'POST') {
    foreach (['page_id', 'p'] as $param) {
        if (isset($_GET[$param])) {
            $id = (int)$_GET[$param];
            isset($routes['legacyIds'][$id]) ? redirect($routes['legacyIds'][$id]) : render_error(404);
        }
    }
}

if (isset($routes['pages'][$key])) {
    $page = $routes['pages'][$key] + ['key' => $key, 'path' => $key === '' ? '/' : '/' . $key . '/'];

    // One URL per page: lowercase with a trailing slash
    if ($method !== 'POST' && $rawPath !== $page['path']) {
        $query = (string)($_SERVER['QUERY_STRING'] ?? '');
        redirect($page['path'] . ($query !== '' ? '?' . $query : ''));
    }

    if ($method === 'POST') {
        $formId = (string)($_POST['form_id'] ?? '');
        if (!in_array($formId, $page['forms'] ?? [], true)) {
            header('Allow: GET, HEAD');
            render_error(405);
        }
        $result = handle_form_submission($formId, $page['path']);
        if (wants_json()) {
            json_response([
                'ok' => $result['ok'],
                'message' => $result['ok'] ? $result['message'] : ($result['errors']['_form'] ?? $result['message']),
                'errors' => (object)array_diff_key($result['errors'], ['_form' => true]),
                'token' => form_token($formId),
            ], $result['ok'] ? 200 : 422);
        }
        if ($result['ok']) redirect($page['path'] . '?sent=' . $formId . '#' . $formId . '-form', 303);
        http_response_code(422);
        $GLOBALS['form_results'][$formId] = $result;
    }

    render_page($page);
    exit;
}

// Permanent redirects from old URLs (also when the old post had a date prefix)
$segments = $key === '' ? [] : explode('/', $key);
$last = (string)end($segments);
if (isset($routes['redirects'][$key])) redirect($routes['redirects'][$key]);
if ($last !== '' && isset($routes['redirects'][$last]) && count($segments) <= 4) redirect($routes['redirects'][$last]);

// Removed for good: spam posts and WordPress system paths
if (array_intersect($segments, $routes['goneSlugs']) || in_array($segments[0] ?? '', $routes['gonePrefixes'], true)) {
    render_error(410);
}

render_error(404);
