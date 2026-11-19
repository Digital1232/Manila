<?php
// Enquiry forms: field definitions, anti-spam checks (signed time token, honeypot, rate limit),
// validation, CSV storage outside the web root and email notification.
defined('MIPS') || exit;

function form_definitions(): array
{
    static $defs = null;
    if ($defs !== null) return $defs;
    $courseOptions = [];
    foreach (courses() as $key => $course) $courseOptions[$key] = $course['full'];

    return $defs = [
        'admission' => [
            'label' => 'Admission enquiry',
            'success' => 'Thank you for applying! Our admissions team will contact you shortly to guide you through the admission process.',
            'fields' => [
                'name' => ['label' => 'Full name', 'type' => 'text', 'required' => 'Please enter your full name.', 'max' => 80, 'autocomplete' => 'name'],
                'phone' => ['label' => 'Mobile number', 'type' => 'tel', 'required' => 'Please enter your mobile number.', 'max' => 20, 'autocomplete' => 'tel'],
                'email' => ['label' => 'Email address', 'type' => 'email', 'required' => false, 'max' => 120, 'autocomplete' => 'email'],
                'course' => ['label' => 'Course', 'type' => 'select', 'required' => 'Please choose a course.', 'options' => $courseOptions],
                'message' => ['label' => 'Message', 'type' => 'textarea', 'required' => false, 'max' => 2000],
            ],
        ],
        'contact' => [
            'label' => 'Contact message',
            'success' => 'Thank you! We have received your message and will get in touch shortly.',
            'fields' => [
                'first_name' => ['label' => 'First name', 'type' => 'text', 'required' => 'Please enter your first name.', 'max' => 60, 'autocomplete' => 'given-name'],
                'last_name' => ['label' => 'Last name', 'type' => 'text', 'required' => false, 'max' => 60, 'autocomplete' => 'family-name'],
                'email' => ['label' => 'Email address', 'type' => 'email', 'required' => 'Please enter your email address.', 'max' => 120, 'autocomplete' => 'email'],
                'phone' => ['label' => 'Mobile number', 'type' => 'tel', 'required' => false, 'max' => 20, 'autocomplete' => 'tel'],
                'subject' => ['label' => 'Subject', 'type' => 'text', 'required' => 'Please enter a subject.', 'max' => 150],
                'message' => ['label' => 'Message', 'type' => 'textarea', 'required' => 'Please enter your message.', 'max' => 3000],
            ],
        ],
    ];
}

/** Secret for signing form tokens: from config, else generated once and kept in private storage. */
function form_secret(): string
{
    static $secret = null;
    if ($secret !== null) return $secret;
    $configured = (string)cfg('form_secret', '');
    if (strlen($configured) >= 32) return $secret = $configured;
    $dir = storage_dir('keys');
    if ($dir) {
        $file = $dir . '/form-secret.key';
        if (is_file($file) && strlen($stored = trim((string)file_get_contents($file))) >= 32) return $secret = $stored;
        $new = bin2hex(random_bytes(32));
        if (@file_put_contents($file, $new, LOCK_EX) !== false) return $secret = $new;
    }
    error_log('[forms] No form secret configured and private storage is not writable');
    return $secret = hash('sha256', __DIR__ . php_uname() . PHP_VERSION);
}

/** Token = issue time + HMAC. Proves the form was loaded from this site and lets us time the submission. */
function form_token(string $formId): string
{
    $ts = (string)time();
    return $ts . '.' . hash_hmac('sha256', $formId . '|' . $ts, form_secret());
}

function form_token_status(string $formId, string $token): string
{
    if (!preg_match('/^(\d{10})\.([a-f0-9]{64})$/', $token, $m)) return 'invalid';
    if (!hash_equals(hash_hmac('sha256', $formId . '|' . $m[1], form_secret()), $m[2])) return 'invalid';
    $age = time() - (int)$m[1];
    if ($age < 2) return 'fast';
    if ($age > 86400) return 'expired';
    return 'ok';
}

function text_length(string $value): int
{
    return function_exists('mb_strlen') ? mb_strlen($value, 'UTF-8') : (int)preg_match_all('/./us', $value);
}

/** Normalise user input: valid UTF-8 only, no control characters, tidy whitespace. */
function clean_input($value, bool $multiline = false): string
{
    if (!is_string($value) || preg_match('//u', $value) !== 1) return '';
    $value = str_replace(["\r\n", "\r"], "\n", $value);
    if ($multiline) {
        $value = preg_replace('/[\x00-\x08\x0B-\x1F\x7F]/u', '', $value);
        $value = preg_replace("/[ \t]+\n/", "\n", $value);
        $value = preg_replace("/\n{3,}/", "\n\n", $value);
    } else {
        $value = preg_replace('/[\x00-\x1F\x7F]+/u', ' ', $value);
        $value = preg_replace('/\s+/u', ' ', $value);
    }
    return trim((string)$value);
}

/** @return array{0: array<string,string>, 1: array<string,string>} [values, errors] */
function validate_form(string $formId, array $input): array
{
    $values = [];
    $errors = [];
    foreach (form_definitions()[$formId]['fields'] as $name => $field) {
        $value = clean_input($input[$name] ?? '', $field['type'] === 'textarea');
        $values[$name] = $value;
        if ($value === '') {
            if ($field['required']) $errors[$name] = $field['required'];
            continue;
        }
        if (isset($field['max']) && text_length($value) > $field['max']) {
            $errors[$name] = 'Please keep this under ' . $field['max'] . ' characters.';
            continue;
        }
        switch ($field['type']) {
            case 'email':
                if (!filter_var($value, FILTER_VALIDATE_EMAIL)) $errors[$name] = 'Please enter a valid email address, for example name@gmail.com.';
                break;
            case 'tel':
                $digits = strlen(preg_replace('/\D/', '', $value));
                if (!preg_match('/^[0-9+()\-. ]+$/', $value) || $digits < 10 || $digits > 13) {
                    $errors[$name] = 'Please enter a valid mobile number (10 digits, with or without +91).';
                }
                break;
            case 'select':
                if (!isset($field['options'][$value])) $errors[$name] = 'Please choose a course from the list.';
                break;
        }
    }
    if (!$errors && preg_match_all('#https?://|www\.#i', implode(' ', $values)) > 2) {
        $errors['_form'] = 'Please remove the web links from your message and try again.';
    }
    return [$values, $errors];
}

/** File-based limit per visitor IP: at most $max accepted submissions per $window seconds. */
function rate_limited(string $bucket, int $max = 5, int $window = 600): bool
{
    $dir = storage_dir('ratelimit');
    if (!$dir) return false;
    if (random_int(1, 50) === 1) {
        foreach (glob($dir . '/*.json') ?: [] as $old) {
            if (filemtime($old) < time() - 86400) @unlink($old);
        }
    }
    $fp = @fopen($dir . '/' . hash_hmac('sha256', $bucket . '|' . client_ip(), form_secret()) . '.json', 'c+');
    if (!$fp) return false;
    flock($fp, LOCK_EX);
    $now = time();
    $hits = array_values(array_filter((array)json_decode((string)stream_get_contents($fp), true), fn($t) => is_int($t) && $t > $now - $window));
    $limited = count($hits) >= $max;
    if (!$limited) {
        $hits[] = $now;
        ftruncate($fp, 0);
        rewind($fp);
        fwrite($fp, json_encode($hits));
    }
    flock($fp, LOCK_UN);
    fclose($fp);
    return $limited;
}

/** Spreadsheet apps execute cells that start with these characters; prefix them so they stay plain text. */
function csv_safe(string $value): string
{
    return preg_match('/^[=+\-@\t\r]/', $value) ? "'" . $value : $value;
}

/** Keep a copy of every enquiry (one CSV per form per month) so nothing is lost if email fails. */
function store_submission(string $formId, array $values, string $pageUrl): bool
{
    $dir = storage_dir('submissions');
    if (!$dir) return false;
    $file = $dir . '/' . $formId . '-' . date('Y-m') . '.csv';
    $isNew = !is_file($file);
    $fp = @fopen($file, 'a');
    if (!$fp) return false;
    flock($fp, LOCK_EX);
    $fields = form_definitions()[$formId]['fields'];
    if ($isNew) {
        fwrite($fp, "\xEF\xBB\xBF");
        fputcsv($fp, array_merge(['Received'], array_column($fields, 'label'), ['Page', 'IP address']), ',', '"', '');
    }
    $row = [date('Y-m-d H:i:s')];
    foreach (array_keys($fields) as $name) $row[] = csv_safe($values[$name] ?? '');
    $row[] = $pageUrl;
    $row[] = client_ip();
    $ok = fputcsv($fp, $row, ',', '"', '') !== false;
    flock($fp, LOCK_UN);
    fclose($fp);
    return $ok;
}

function notify_submission(string $formId, array $values, string $pageUrl): array
{
    $def = form_definitions()[$formId];
    if ($formId === 'admission') {
        $course = courses()[$values['course']] ?? null;
        $subject = 'Admission enquiry: ' . $values['name'] . ($course ? ' – ' . $course['abbr'] : '');
        $replyName = $values['name'];
        $intro = 'New admission enquiry from the website.';
    } else {
        $subject = 'Website message: ' . $values['subject'];
        $replyName = trim($values['first_name'] . ' ' . $values['last_name']);
        $intro = 'New message from the website contact form.';
    }
    $lines = [$intro, ''];
    foreach ($def['fields'] as $name => $field) {
        $value = $values[$name] ?? '';
        if ($field['type'] === 'select') $value = $field['options'][$value] ?? $value;
        if ($field['type'] === 'textarea') {
            $lines[] = $field['label'] . ':';
            $lines[] = $value !== '' ? $value : '-';
        } else {
            $lines[] = str_pad($field['label'] . ':', 16) . ($value !== '' ? $value : '-');
        }
    }
    $lines[] = '';
    $lines[] = 'Received: ' . date('j M Y, g:i a') . ' (IST)';
    $lines[] = 'Page: ' . $pageUrl;
    $lines[] = '';
    $lines[] = !empty($values['email']) ? 'Reply to this email to answer ' . $replyName . ' directly.' : 'No email address given – please call back on the number above.';
    return send_mail($subject, implode("\n", $lines), $values['email'] ?: null, $replyName);
}

/**
 * Process a POSTed form.
 * @return array{ok: bool, values: array, errors: array, message: string}
 */
function handle_form_submission(string $formId, string $pagePath): array
{
    $def = form_definitions()[$formId];
    $result = ['ok' => false, 'values' => [], 'errors' => [], 'message' => ''];
    $phone = site()['phones'][0];

    // Honeypot field is invisible to people; bots that fill it get a normal-looking success.
    if (trim((string)($_POST['website'] ?? '')) !== '') {
        error_log('[forms] honeypot triggered on ' . $formId);
        return ['ok' => true, 'values' => [], 'errors' => [], 'message' => $def['success']];
    }

    [$values, $errors] = validate_form($formId, $_POST);
    $result['values'] = $values;

    $origin = (string)($_SERVER['HTTP_ORIGIN'] ?? '');
    $host = strtolower((string)preg_replace('/:\d+$/', '', (string)($_SERVER['HTTP_HOST'] ?? '')));
    if ($origin !== '' && strtolower((string)parse_url($origin, PHP_URL_HOST)) !== $host) {
        $result['errors']['_form'] = 'Your message could not be sent from this page. Please open manilainstitute.com and try again.';
        return $result;
    }

    $token = form_token_status($formId, (string)($_POST['_token'] ?? ''));
    if ($token === 'fast') {
        $result['errors']['_form'] = 'That was quick! Please check your details and press the button again.';
        return $result;
    }
    if ($token !== 'ok') {
        $result['errors']['_form'] = 'This page was open for a long time. Please press the button again to send your details.';
        return $result;
    }
    if ($errors) {
        $result['errors'] = $errors;
        $result['message'] = isset($errors['_form']) ? '' : 'Please correct the highlighted fields and try again.';
        return $result;
    }
    if (rate_limited('form')) {
        $result['errors']['_form'] = 'You have sent several messages in a short time. Please wait a few minutes, or call us on ' . $phone . '.';
        return $result;
    }

    $pageUrl = abs_url($pagePath);
    $saved = store_submission($formId, $values, $pageUrl);
    $mail = notify_submission($formId, $values, $pageUrl);
    if (!$saved && !$mail['ok']) {
        $result['errors']['_form'] = 'Sorry, we could not send your details just now. Please call us on ' . $phone . ' or message us on WhatsApp.';
        return $result;
    }
    if (!$mail['ok']) error_log('[forms] stored ' . $formId . ' submission but email failed: ' . $mail['error']);

    return ['ok' => true, 'values' => [], 'errors' => [], 'message' => $def['success']];
}

/** State for rendering a form: values and errors after a failed POST, or the success message after redirect. */
function form_state(string $formId): array
{
    $result = $GLOBALS['form_results'][$formId] ?? null;
    $sent = ($_GET['sent'] ?? '') === $formId;
    return [
        'values' => $result['values'] ?? [],
        'errors' => $result['errors'] ?? [],
        'sent' => $sent,
        'message' => $sent ? form_definitions()[$formId]['success'] : ($result['message'] ?? ''),
    ];
}
