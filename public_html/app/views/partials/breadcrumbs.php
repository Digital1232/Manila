<?php
defined('MIPS') || exit;
/** @var array $crumbs list of ['label' => ..., 'url' => ...] */
if (empty($crumbs)) return;
$lastIndex = count($crumbs) - 1;
?>
<nav class="breadcrumbs" aria-label="Breadcrumb">
  <ol>
    <?php foreach ($crumbs as $i => $crumb): ?>
    <li><?php if ($i === $lastIndex): ?><span aria-current="page"><?= e($crumb['label']) ?></span><?php else: ?><a href="<?= e($crumb['url']) ?>"><?= e($crumb['label']) ?></a><?= icon('chevron-right') ?><?php endif; ?></li>
    <?php endforeach; ?>
  </ol>
</nav>
