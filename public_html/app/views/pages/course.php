<?php
defined('MIPS') || exit;
/** Shared frame for the four course pages; the course-specific sections live in views/courses/{key}.php */
$key = $course['key'];
$careerWord = ['dnm' => 'Nursing', 'dmlt' => 'Laboratory', 'dott' => 'Operation Theatre', 'drit' => 'Radiology'][$key];
$waText = 'Hello, I would like to know more about the ' . $course['full'] . ' course.';
$applyUrl = '/admission/?course=' . $key . '#admission-form';
?>
<section class="course-hero">
  <div class="container course-hero-grid">
    <div class="course-hero-copy">
      <?php partial('breadcrumbs', ['crumbs' => $crumbs]); ?>
      <p class="eyebrow"><?= icon($course['icon']) ?> <?= e($course['abbr']) ?> · Diploma course</p>
      <h1><?= e($course['full']) ?></h1>
      <p class="lead"><?= e($course['summary']) ?></p>
      <ul class="course-facts">
        <li><?= icon('clock') ?><span><small>Duration</small><?= e($course['duration']) ?></span></li>
        <li><?= icon('hospital') ?><span><small>Training</small>Hospital-based</span></li>
        <li><?= icon('map-pin') ?><span><small>Campus</small>Tirunelveli</span></li>
      </ul>
      <div class="btn-row">
        <a class="btn btn-primary btn-lg" href="<?= e($applyUrl) ?>">Apply Now <?= icon('arrow-right') ?></a>
        <a class="btn btn-whatsapp btn-lg" href="<?= e(whatsapp_href($waText)) ?>" rel="noopener" target="_blank"><?= icon('whatsapp') ?> WhatsApp Now</a>
      </div>
    </div>
    <figure class="course-hero-media">
      <?= img($course['image'], $course['alt'], ['priority' => true, 'sizes' => '(min-width: 1024px) 480px, 100vw']) ?>
    </figure>
  </div>
</section>

<?php
// Each course file sets $whyTint for its last section; the steps take the other background so tints never stack
$whyTint = true;
include APP_DIR . '/views/courses/' . $key . '.php';
partial('apply-steps', ['tint' => !$whyTint]);
?>

<?php partial('cta-band', [
    'heading' => 'Ready to begin your <span>' . e($careerWord) . ' Career?</span>',
    'text' => 'Apply now for the <strong>' . e($course['full']) . '</strong> at Manila Institute of Paramedical Science, Tirunelveli.',
    'course' => $key,
]); ?>
