<?php
// Minimal, dependency-free mail sender.
//   smtp - authenticated SMTP (Hostinger: smtp.hostinger.com, port 465 SSL), most reliable
//   mail - PHP mail() via the hosting server
//   log  - writes the message to private/storage/outbox (local testing, nothing is sent)
defined('MIPS') || exit;

/**
 * Send a plain-text email to the configured recipients.
 * @return array{ok: bool, error: string}
 */
function send_mail(string $subject, string $body, ?string $replyTo = null, ?string $replyName = null): array
{
    $m = cfg('mail');
    $to = array_values(array_filter((array)$m['recipients'], fn($a) => filter_var($a, FILTER_VALIDATE_EMAIL)));
    if (!$to) return ['ok' => false, 'error' => 'No valid recipients configured'];
    $from = (string)$m['from_email'];
    $message = build_message($from, (string)$m['from_name'], $to, $subject, $body, $replyTo, $replyName);

    try {
        switch ($m['transport']) {
            case 'smtp':
                smtp_send($m['smtp'], $from, $to, $message['raw']);
                break;
            case 'log':
                $dir = storage_dir('outbox');
                if (!$dir) throw new RuntimeException('Outbox directory not writable');
                file_put_contents($dir . '/' . date('Ymd-His') . '-' . bin2hex(random_bytes(3)) . '.eml', $message['raw']);
                break;
            default:
                $ok = mail(implode(', ', $to), $message['subject'], $message['body'], $message['headers'], '-f' . $from);
                if (!$ok) throw new RuntimeException('mail() returned false');
        }
    } catch (Throwable $ex) {
        error_log('[mail] ' . $ex->getMessage());
        return ['ok' => false, 'error' => $ex->getMessage()];
    }
    return ['ok' => true, 'error' => ''];
}

function header_safe(string $value): string
{
    return trim(str_replace(["\r", "\n", "\0"], ' ', $value));
}

function encode_header_text(string $text): string
{
    $text = header_safe($text);
    return preg_match('/[^\x20-\x7E]/', $text) ? '=?UTF-8?B?' . base64_encode($text) . '?=' : $text;
}

function build_message(string $from, string $fromName, array $to, string $subject, string $body, ?string $replyTo, ?string $replyName): array
{
    $host = parse_url((string)cfg('site_url'), PHP_URL_HOST) ?: 'manilainstitute.com';
    $headers = [
        'Date: ' . date('r'),
        'From: ' . encode_header_text($fromName) . ' <' . header_safe($from) . '>',
        'Message-ID: <' . bin2hex(random_bytes(12)) . '@' . $host . '>',
        'MIME-Version: 1.0',
        'Content-Type: text/plain; charset=UTF-8',
        'Content-Transfer-Encoding: base64',
        'X-Mailer: MIPS-Website',
    ];
    if ($replyTo && filter_var($replyTo, FILTER_VALIDATE_EMAIL)) {
        $headers[] = 'Reply-To: ' . ($replyName ? encode_header_text($replyName) . ' ' : '') . '<' . header_safe($replyTo) . '>';
    }
    $encodedSubject = encode_header_text($subject);
    $encodedBody = rtrim(chunk_split(base64_encode(str_replace(["\r\n", "\r"], "\n", $body)), 76, "\r\n"));
    $raw = implode("\r\n", array_merge($headers, ['To: ' . implode(', ', $to), 'Subject: ' . $encodedSubject])) . "\r\n\r\n" . $encodedBody . "\r\n";
    return ['subject' => $encodedSubject, 'body' => $encodedBody, 'headers' => implode("\r\n", $headers), 'raw' => $raw];
}

/** Send a prepared RFC 5322 message over authenticated SMTP (implicit SSL or STARTTLS). */
function smtp_send(array $c, string $from, array $to, string $raw): void
{
    $secure = strtolower((string)($c['secure'] ?? 'ssl'));
    $host = (string)$c['host'];
    $ctx = stream_context_create(['ssl' => ['verify_peer' => true, 'verify_peer_name' => true, 'peer_name' => $host, 'SNI_enabled' => true]]);
    $fp = @stream_socket_client(($secure === 'ssl' ? 'ssl://' : 'tcp://') . $host . ':' . (int)$c['port'], $errno, $errstr, (float)($c['timeout'] ?? 15), STREAM_CLIENT_CONNECT, $ctx);
    if (!$fp) throw new RuntimeException("SMTP connect failed: $errstr ($errno)");
    stream_set_timeout($fp, (int)($c['timeout'] ?? 15));

    $read = function () use ($fp): array {
        $data = '';
        while (($line = fgets($fp, 1024)) !== false) {
            $data .= $line;
            if (strlen($line) < 4 || $line[3] === ' ') break;
        }
        return [(int)substr($data, 0, 3), trim($data)];
    };
    $cmd = function (string $command, array $expect) use ($fp, $read): string {
        fwrite($fp, $command . "\r\n");
        [$code, $text] = $read();
        if (!in_array($code, $expect, true)) {
            $shown = str_starts_with($command, 'AUTH') || strlen($command) > 60 ? strtok($command, ' ') : $command;
            throw new RuntimeException("SMTP '$shown' failed: $text");
        }
        return $text;
    };

    try {
        [$code, $text] = $read();
        if ($code !== 220) throw new RuntimeException("SMTP greeting failed: $text");
        $ehlo = 'EHLO ' . (parse_url((string)cfg('site_url'), PHP_URL_HOST) ?: 'localhost');
        $cmd($ehlo, [250]);
        if ($secure === 'tls') {
            $cmd('STARTTLS', [220]);
            if (!stream_socket_enable_crypto($fp, true, STREAM_CRYPTO_METHOD_TLSv1_2_CLIENT | (defined('STREAM_CRYPTO_METHOD_TLSv1_3_CLIENT') ? STREAM_CRYPTO_METHOD_TLSv1_3_CLIENT : 0))) {
                throw new RuntimeException('STARTTLS negotiation failed');
            }
            $cmd($ehlo, [250]);
        }
        if ((string)($c['username'] ?? '') !== '') {
            $cmd('AUTH LOGIN', [334]);
            $cmd(base64_encode((string)$c['username']), [334]);
            $cmd(base64_encode((string)$c['password']), [235]);
        }
        $cmd('MAIL FROM:<' . header_safe($from) . '>', [250]);
        foreach ($to as $rcpt) $cmd('RCPT TO:<' . header_safe($rcpt) . '>', [250, 251]);
        $cmd('DATA', [354]);
        $data = preg_replace('/^\./m', '..', str_replace("\r\n", "\n", $raw));
        $cmd(str_replace("\n", "\r\n", rtrim($data, "\n")) . "\r\n.", [250]);
        $cmd('QUIT', [221]);
    } finally {
        fclose($fp);
    }
}
