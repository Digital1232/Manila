<?php
defined('MIPS') || exit;
/** @var string $action page path the form posts to; optional $course preselects a course */
$state = form_state('admission');
$preselect = $course ?? '';
if ($preselect === '' && isset($_GET['course']) && is_string($_GET['course']) && isset(courses()[$_GET['course']])) {
    $preselect = $_GET['course'];
}
?>
<form class="form" id="admission-form" method="post" action="<?= e($action) ?>#admission-form" data-form>
  <?= form_hidden('admission') ?>
  <div class="form-status" data-form-status><?= form_status($state) ?></div>
  <div class="form-grid">
    <?= form_field('admission', 'name', $state, ['class' => 'span-2', 'placeholder' => 'Your full name']) ?>
    <?= form_field('admission', 'phone', $state, ['placeholder' => 'e.g. 98765 43210']) ?>
    <?= form_field('admission', 'email', $state, ['placeholder' => 'you@example.com']) ?>
    <?= form_field('admission', 'course', $state, ['class' => 'span-2', 'selected' => $preselect]) ?>
    <?= form_field('admission', 'message', $state, ['class' => 'span-2', 'rows' => 3, 'placeholder' => 'Anything you would like to ask (optional)']) ?>
  </div>
  <button class="btn btn-primary btn-block" type="submit" data-submit>
    <span data-submit-label>Submit Application</span><?= icon('arrow-right') ?>
  </button>
  <p class="form-note">By submitting, you agree to our <a href="/privacy-policy/">Privacy Policy</a>. We will only use your details to help with your admission.</p>
</form>
