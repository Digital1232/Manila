<?php
defined('MIPS') || exit;
/** Optional: $intro (HTML), $link (bool, default true), $id, $tint (bool, default true) */
$steps = [
    ['icon' => 'clipboard', 'title' => 'You Apply', 'text' => 'Tell us a little about yourself and we’ll help with the rest. Our convenient online application tool only takes 10 minutes to complete.'],
    ['icon' => 'message', 'title' => 'We Connect', 'text' => 'After you submit your application, an admissions representative will contact you and will help you to complete the process.'],
    ['icon' => 'calendar', 'title' => 'You Get Ready', 'text' => 'Once you’ve completed your application and connected with an admissions representative, you’re ready to create your schedule.'],
];
?>
<section class="section<?= ($tint ?? true) ? ' section-tint' : '' ?>" id="<?= e($id ?? 'how-to-apply') ?>">
  <div class="container">
    <div class="section-head center">
      <p class="eyebrow">Admission process</p>
      <h2>How to Apply?</h2>
      <?php if (!empty($intro)): ?><p class="section-lead"><?= $intro ?></p><?php endif; ?>
    </div>
    <ol class="steps">
      <?php foreach ($steps as $i => $step): ?>
      <li class="step">
        <span class="step-icon"><?= icon($step['icon']) ?></span>
        <span class="step-num">Step <?= $i + 1 ?></span>
        <h3><?= e($step['title']) ?></h3>
        <p><?= e($step['text']) ?></p>
      </li>
      <?php endforeach; ?>
    </ol>
    <?php if ($link ?? true): ?>
    <p class="center section-foot"><a class="btn btn-outline" href="/admission/#requirements">View All Requirements <?= icon('arrow-right') ?></a></p>
    <?php endif; ?>
  </div>
</section>
