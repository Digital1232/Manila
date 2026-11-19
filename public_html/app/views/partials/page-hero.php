<?php
defined('MIPS') || exit;
/** @var string $title @var array $crumbs  Optional: $eyebrow, $lead, $image, $actions (HTML) */
$image = $image ?? '';
?>
<section class="page-hero<?= $image === '' ? ' page-hero-plain' : '' ?>">
  <?php if ($image !== ''): ?>
  <?= img($image, '', ['class' => 'page-hero-bg', 'priority' => true, 'sizes' => '100vw']) ?>
  <?php endif; ?>
  <div class="container page-hero-inner">
    <?php partial('breadcrumbs', ['crumbs' => $crumbs]); ?>
    <?php if (!empty($eyebrow)): ?><p class="eyebrow eyebrow-light"><?= e($eyebrow) ?></p><?php endif; ?>
    <h1><?= $title ?></h1>
    <?php if (!empty($lead)): ?><p class="lead"><?= $lead ?></p><?php endif; ?>
    <?php if (!empty($actions)): ?><div class="btn-row"><?= $actions ?></div><?php endif; ?>
  </div>
</section>
