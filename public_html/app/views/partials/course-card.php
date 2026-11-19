<?php
defined('MIPS') || exit;
/** @var string $key course key */
$c = courses()[$key];
?>
<article class="course-card">
  <div class="course-card-media">
    <?= img($c['image'], $c['alt'], ['sizes' => '(min-width: 1200px) 280px, (min-width: 640px) 45vw, 100vw']) ?>
    <span class="course-card-badge"><?= icon($c['icon']) ?><?= e($c['abbr']) ?></span>
  </div>
  <div class="course-card-body">
    <p class="course-card-meta"><?= icon('clock') ?> <?= e($c['duration']) ?> · Diploma</p>
    <h3><a href="<?= e(course_url($key)) ?>" class="stretched-link"><?= e($c['title']) ?></a></h3>
    <p><?= e($c['summary']) ?></p>
    <span class="link-arrow" aria-hidden="true">View course <?= icon('arrow-right') ?></span>
  </div>
</article>
