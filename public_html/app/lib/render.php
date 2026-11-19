<?php
// Page rendering, error pages, sitemap and robots.txt.
defined('MIPS') || exit;

function breadcrumbs(array $page): array
{
    if (($page['key'] ?? '') === '') return [];
    $routes = $GLOBALS['routes'] ?? [];
    $trail = [['label' => 'Home', 'url' => '/']];
    if (!empty($page['parent']) && isset($routes['pages'][$page['parent']])) {
        $trail[] = ['label' => $routes['pages'][$page['parent']]['label'], 'url' => '/' . $page['parent'] . '/'];
    }
    $trail[] = ['label' => $page['label'], 'url' => $page['path']];
    return $trail;
}

/** Structured data for search engines (JSON-LD). */
function page_schema(array $page): array
{
    $site = site();
    $org = [
        '@type' => 'EducationalOrganization',
        '@id' => abs_url('/#organization'),
        'name' => $site['name'],
        'alternateName' => [$site['short_name'], 'Manila Institute'],
        'url' => abs_url('/'),
        'logo' => abs_url('/assets/img/brand/manila-institute-logo.png'),
        'image' => abs_url('/assets/img/og/manila-institute-og.jpg'),
        'description' => $site['description'],
        'telephone' => preg_replace('/[^\d+]/', '', $site['phones'][0]),
        'email' => $site['email'],
        'address' => [
            '@type' => 'PostalAddress',
            'streetAddress' => $site['address']['street'],
            'addressLocality' => $site['address']['locality'],
            'addressRegion' => $site['address']['state'],
            'postalCode' => $site['address']['postal'],
            'addressCountry' => $site['address']['country'],
        ],
        'parentOrganization' => [
            '@type' => 'MedicalOrganization',
            'name' => $site['parent']['name'],
            'url' => $site['parent']['url'],
            'sameAs' => array_values(array_column($site['social'], 'url')),
        ],
    ];
    $graph = [];
    if (in_array($page['key'] ?? '', ['', 'about-us', 'contact-us'], true)) $graph[] = $org;
    if (isset($page['course'])) {
        $course = courses()[$page['course']];
        $graph[] = [
            '@type' => 'Course',
            'name' => $course['full'],
            'description' => $course['summary'],
            'url' => abs_url($page['path']),
            'educationalCredentialAwarded' => 'Diploma',
            'timeRequired' => 'P2Y',
            'provider' => ['@type' => 'EducationalOrganization', 'name' => $site['name'], 'url' => abs_url('/')],
        ];
    }
    $crumbs = breadcrumbs($page);
    if ($crumbs) {
        $items = [];
        foreach ($crumbs as $i => $crumb) {
            $items[] = ['@type' => 'ListItem', 'position' => $i + 1, 'name' => $crumb['label'], 'item' => abs_url($crumb['url'])];
        }
        $graph[] = ['@type' => 'BreadcrumbList', 'itemListElement' => $items];
    }
    return $graph ? ['@context' => 'https://schema.org', '@graph' => $graph] : [];
}

function render_page(array $page, int $status = 0): void
{
    if ($status) http_response_code($status);
    header('Content-Type: text/html; charset=utf-8');
    header('Cache-Control: no-cache');
    $site = site();
    $course = isset($page['course']) ? courses()[$page['course']] + ['key' => $page['course']] : null;
    $crumbs = breadcrumbs($page);
    ob_start();
    include APP_DIR . '/views/pages/' . $page['view'] . '.php';
    $content = (string)ob_get_clean();
    include APP_DIR . '/views/layout.php';
}

function render_error(int $code): void
{
    $titles = [404 => 'Page not found', 405 => 'Method not allowed', 410 => 'This page has been removed'];
    $page = [
        'key' => '_error', 'path' => '/', 'view' => 'error', 'nav' => '', 'code' => $code, 'noindex' => true,
        'label' => $titles[$code] ?? 'Error',
        'title' => ($titles[$code] ?? 'Error') . ' | Manila Institute of Paramedical Science',
        'description' => 'Manila Institute of Paramedical Science, Tirunelveli.',
    ];
    render_page($page, $code);
    exit;
}

function render_sitemap(array $pages): void
{
    header('Content-Type: application/xml; charset=utf-8');
    header('Cache-Control: public, max-age=3600');
    $out = '<?xml version="1.0" encoding="UTF-8"?>' . "\n" . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
    foreach ($pages as $key => $p) {
        $files = [APP_DIR . '/views/pages/' . $p['view'] . '.php'];
        if (isset($p['course'])) {
            $files[] = APP_DIR . '/views/courses/' . $p['course'] . '.php';
            $files[] = APP_DIR . '/data/courses.php';
        }
        $mtime = max(array_map(fn($f) => is_file($f) ? filemtime($f) : 0, $files));
        $out .= '  <url><loc>' . e(abs_url($key === '' ? '/' : '/' . $key . '/')) . '</loc><lastmod>' . date('Y-m-d', $mtime)
            . '</lastmod><priority>' . e($p['priority'] ?? '0.5') . "</priority></url>\n";
    }
    echo $out . "</urlset>\n";
    exit;
}

function render_robots(): void
{
    header('Content-Type: text/plain; charset=utf-8');
    if (cfg('env') === 'production') {
        echo "User-agent: *\nAllow: /\n\nSitemap: " . abs_url('/sitemap.xml') . "\n";
    } else {
        echo "# Staging copy: keep search engines out\nUser-agent: *\nDisallow: /\n";
    }
    exit;
}

/** Hidden inputs every form needs: form id, signed time token and the honeypot trap. */
function form_hidden(string $formId): string
{
    return '<input type="hidden" name="form_id" value="' . e($formId) . '">'
        . '<input type="hidden" name="_token" value="' . e(form_token($formId)) . '" data-token>'
        . '<div class="hp-field" aria-hidden="true"><label for="' . e($formId) . '-website">Leave this field empty</label>'
        . '<input type="text" id="' . e($formId) . '-website" name="website" tabindex="-1" autocomplete="off"></div>';
}

/** One labelled form control with its error message. $opts: class, placeholder, selected, rows. */
function form_field(string $formId, string $name, array $state, array $opts = []): string
{
    $field = form_definitions()[$formId]['fields'][$name];
    $id = $formId . '-' . str_replace('_', '-', $name);
    $error = $state['errors'][$name] ?? '';
    $value = (string)($state['values'][$name] ?? '');
    $attrs = ['id' => $id, 'name' => $name];
    if ($field['required']) {
        $attrs['required'] = 'required';
        $attrs['data-required'] = $field['required'];
    }
    if (isset($field['max'])) $attrs['maxlength'] = (string)$field['max'];
    if (!empty($field['autocomplete'])) $attrs['autocomplete'] = $field['autocomplete'];
    if (!empty($opts['placeholder'])) $attrs['placeholder'] = $opts['placeholder'];
    if ($error !== '') {
        $attrs['aria-invalid'] = 'true';
        $attrs['aria-describedby'] = $id . '-error';
    }
    $attrString = function (array $a): string {
        $s = '';
        foreach ($a as $k => $v) $s .= ' ' . $k . '="' . e($v) . '"';
        return $s;
    };

    switch ($field['type']) {
        case 'select':
            $selected = $value !== '' ? $value : (string)($opts['selected'] ?? '');
            $control = '<div class="select-wrap"><select' . $attrString($attrs) . '><option value="">Select a course</option>';
            foreach ($field['options'] as $optValue => $optLabel) {
                $control .= '<option value="' . e($optValue) . '"' . ($optValue === $selected ? ' selected' : '') . '>' . e($optLabel) . '</option>';
            }
            $control .= '</select>' . icon('chevron-down', 'icon select-icon') . '</div>';
            break;
        case 'textarea':
            $control = '<textarea' . $attrString($attrs + ['rows' => (string)($opts['rows'] ?? 4)]) . '>' . e($value) . '</textarea>';
            break;
        default:
            $extra = ['type' => $field['type'], 'value' => $value];
            if ($field['type'] === 'tel') $extra['inputmode'] = 'tel';
            if ($field['type'] === 'email') $extra['inputmode'] = 'email';
            $control = '<input' . $attrString($extra + $attrs) . '>';
    }

    $label = '<label for="' . e($id) . '">' . e($field['label'])
        . ($field['required'] ? ' <span class="req" aria-hidden="true">*</span>' : ' <span class="optional">(optional)</span>') . '</label>';
    $errorHtml = $error !== '' ? '<p class="field-error" id="' . e($id) . '-error">' . e($error) . '</p>' : '';
    return '<div class="field' . (!empty($opts['class']) ? ' ' . e($opts['class']) : '') . ($error !== '' ? ' has-error' : '') . '" data-field="' . e($name) . '">'
        . $label . $control . $errorHtml . '</div>';
}

/** Success or error banner shown above a form. */
function form_status(array $state): string
{
    if ($state['sent']) {
        return '<div class="alert alert-success" role="status">' . icon('check-circle') . '<p>' . e($state['message']) . '</p></div>';
    }
    $msg = $state['errors']['_form'] ?? $state['message'];
    return $msg !== '' ? '<div class="alert alert-error" role="alert">' . icon('alert') . '<p>' . e($msg) . '</p></div>' : '';
}
