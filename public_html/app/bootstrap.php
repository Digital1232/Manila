<?php
// Loads configuration and libraries. Private settings (mail password, form secret) live outside the
// web root in ../private/config.php so they can never be served as files.
declare(strict_types=1);
defined('MIPS') || exit;

define('APP_DIR', __DIR__);
define('PUBLIC_DIR', dirname(__DIR__));
define('PRIVATE_DIR', getenv('MIPS_PRIVATE_DIR') ?: dirname(__DIR__, 2) . '/private');

$GLOBALS['config'] = [
    'env' => 'production',
    'site_url' => 'https://manilainstitute.com',
    'form_secret' => '',
    'mail' => [
        'transport' => 'mail', // smtp | mail | log
        'from_email' => 'no-reply@manilainstitute.com',
        'from_name' => 'Manila Institute Website',
        'recipients' => ['alexvilpower@gmail.com'],
        'smtp' => ['host' => 'smtp.hostinger.com', 'port' => 465, 'secure' => 'ssl', 'username' => '', 'password' => '', 'timeout' => 15],
    ],
];
if (is_file(PRIVATE_DIR . '/config.php')) {
    $local = (array)require PRIVATE_DIR . '/config.php';
    $GLOBALS['config'] = array_replace_recursive($GLOBALS['config'], $local);
    // Lists are replaced as a whole, not merged index by index
    if (isset($local['mail']['recipients'])) $GLOBALS['config']['mail']['recipients'] = $local['mail']['recipients'];
}

error_reporting(E_ALL);
ini_set('display_errors', ($GLOBALS['config']['env'] ?? '') === 'development' ? '1' : '0');
ini_set('log_errors', '1');
date_default_timezone_set('Asia/Kolkata');

require APP_DIR . '/lib/helpers.php';
require APP_DIR . '/lib/mailer.php';
require APP_DIR . '/lib/forms.php';
require APP_DIR . '/lib/render.php';

if ($logDir = storage_dir('logs')) ini_set('error_log', $logDir . '/php-error.log');
