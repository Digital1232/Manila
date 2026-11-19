<?php
// Copy this file to config.php in the same folder (outside public_html) and fill in the values.
// This file is never served to visitors.
return [
    'env' => 'production',                 // 'production' on the live site, 'staging' on a test copy (keeps Google out)
    'site_url' => 'https://manilainstitute.com',
    'form_secret' => '',                    // long random text; leave empty to auto-generate one in private/storage/keys

    'mail' => [
        // mail = sent by the Hostinger server itself, no password needed (same way the old WordPress site sent its form emails).
        // Only if test emails do not arrive at all: change to 'smtp' and fill in the smtp block below.
        'transport' => 'mail',              // mail (no password) | smtp (mailbox login) | log (writes emails to private/storage/outbox)
        'from_email' => 'no-reply@manilainstitute.com',   // sender address shown on the enquiry emails
        'from_name' => 'Manila Institute Website',
        'recipients' => ['alexvilpower@gmail.com'],  // receives both admission enquiries and contact messages

        // Used only when transport is 'smtp'. Leave as it is otherwise.
        'smtp' => [
            'host' => 'smtp.hostinger.com',
            'port' => 465,
            'secure' => 'ssl',              // ssl for port 465, tls for port 587
            'username' => 'no-reply@manilainstitute.com',
            'password' => '',               // the mailbox password (enter it on the server only)
            'timeout' => 15,
        ],
    ],
];
