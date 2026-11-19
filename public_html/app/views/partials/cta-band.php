<?php
defined('MIPS') || exit;
/** @var string $heading (HTML) @var string $text (HTML)  Optional: $course (key) */
$courseKey = $course ?? null;
$waText = $courseKey ? 'Hello, I would like to apply for the ' . courses()[$courseKey]['full'] . ' course.' : 'Hello, I would like to know more about admission at Manila Institute.';
?>
<section class="cta-band">
  <div class="container cta-inner">
    <div class="cta-copy">
      <h2><?= $heading ?></h2>
      <p><?= $text ?></p>
    </div>
    <div class="btn-row">
      <a class="btn btn-primary btn-lg" href="/admission/<?= $courseKey ? '?course=' . e($courseKey) : '' ?>#admission-form">Apply Now <?= icon('arrow-right') ?></a>
      <a class="btn btn-whatsapp btn-lg" href="<?= e(whatsapp_href($waText)) ?>" rel="noopener" target="_blank"><?= icon('whatsapp') ?> WhatsApp Now</a>
    </div>
  </div>
</section>
