<?php
defined('MIPS') || exit;
/** @var string $course key @var array $items @var string $image @var string $alt; optional $tint (bool, default true) */
$c = courses()[$course];
?>
<section class="section<?= ($tint ?? true) ? ' section-tint' : '' ?>">
  <div class="container feature-grid">
    <figure class="feature-media">
      <?= img($image, $alt, ['sizes' => '(min-width: 1024px) 520px, 100vw']) ?>
    </figure>
    <div class="feature-copy">
      <p class="eyebrow">Why study <?= e($c['abbr']) ?> with us</p>
      <h2>Why Choose Manila Institute?</h2>
      <ul class="check-list check-list-lg">
        <?php foreach ($items as $item): ?><li><?= icon('check-circle') ?><?= e($item) ?></li><?php endforeach; ?>
      </ul>
      <a class="btn btn-whatsapp" href="<?= e(whatsapp_href('Hello, I would like to know more about the ' . $c['full'] . ' course.')) ?>" rel="noopener" target="_blank"><?= icon('whatsapp') ?> Learn More on WhatsApp</a>
    </div>
  </div>
</section>
