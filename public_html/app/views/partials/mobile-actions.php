<?php
defined('MIPS') || exit;
$site = site();
$courseKey = $page['course'] ?? null;
$waText = $courseKey ? 'Hello, I would like to know more about the ' . courses()[$courseKey]['full'] . ' course.' : 'Hello, I would like to know more about the courses at Manila Institute.';
$applyUrl = '/admission/' . ($courseKey ? '?course=' . $courseKey : '') . '#admission-form';
?>
<nav class="mobile-actions" aria-label="Quick contact">
  <a href="<?= e(tel_href($site['phones'][0])) ?>"><?= icon('phone') ?><span>Call</span></a>
  <a href="<?= e(whatsapp_href($waText)) ?>" rel="noopener" target="_blank"><?= icon('whatsapp') ?><span>WhatsApp</span></a>
  <a class="is-primary" href="<?= e($applyUrl) ?>"><?= icon('send') ?><span>Apply Now</span></a>
</nav>
