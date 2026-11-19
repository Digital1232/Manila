<?php
defined('MIPS') || exit;
// Courses overview. Descriptions, skills and careers from the original "Our Academic Programs" section.
partial('page-hero', [
    'crumbs' => $crumbs,
    'eyebrow' => 'Courses',
    'title' => 'Our Academic Programs',
    'lead' => 'We offer industry-focused diploma courses in Nursing, Medical Laboratory Technology, Radiology &amp; Imaging, and Operation Theatre Technology, backed by experienced faculty and hands-on clinical training.',
    'image' => 'shared/page-hero-healthcare.webp',
]);
?>
<nav class="course-jump" aria-label="Courses on this page">
  <div class="container">
    <ul>
      <?php foreach (courses() as $key => $c): ?>
      <li><a href="#<?= e($key) ?>"><?= icon($c['icon']) ?><span><strong><?= e($c['abbr']) ?></strong><?= e(preg_replace('/^Diploma in /', '', $c['title'])) ?></span></a></li>
      <?php endforeach; ?>
    </ul>
  </div>
</nav>

<section class="section">
  <div class="container program-list">
    <?php foreach (courses() as $key => $c): ?>
    <article class="program-row" id="<?= e($key) ?>">
      <figure class="program-media">
        <?= img($c['image'], $c['alt'], ['sizes' => '(min-width: 1024px) 460px, 100vw']) ?>
      </figure>
      <div class="program-copy">
        <p class="eyebrow"><?= e($c['abbr']) ?> · <?= e($c['duration']) ?></p>
        <h2><?= e($c['full']) ?></h2>
        <p><?= e($c['summary']) ?></p>
        <div class="program-cols">
          <div>
            <h3 class="h-small">Key Skills Covered</h3>
            <ul class="check-list">
              <?php foreach ($c['skills'] as $skill): ?><li><?= icon('check') ?><?= e($skill) ?></li><?php endforeach; ?>
            </ul>
          </div>
          <div>
            <h3 class="h-small">Career Opportunities</h3>
            <p><?= e($c['careers']) ?></p>
          </div>
        </div>
        <div class="btn-row">
          <a class="btn btn-secondary" href="<?= e(course_url($key)) ?>">Course details <?= icon('arrow-right') ?></a>
          <a class="btn btn-outline" href="/admission/?course=<?= e($key) ?>#admission-form">Apply for <?= e($c['abbr']) ?></a>
        </div>
      </div>
    </article>
    <?php endforeach; ?>
  </div>
</section>

<?php partial('apply-steps'); ?>

<?php partial('cta-band', [
    'heading' => 'Are you ready to take the next step toward your <span>future career?</span>',
    'text' => 'Apply now for a diploma course at Manila Institute of Paramedical Science, Tirunelveli.',
]); ?>
