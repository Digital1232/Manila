<?php
defined('MIPS') || exit;
/** @var string $action */
$state = form_state('contact');
?>
<form class="form" id="contact-form" method="post" action="<?= e($action) ?>#contact-form" data-form>
  <?= form_hidden('contact') ?>
  <div class="form-status" data-form-status><?= form_status($state) ?></div>
  <div class="form-grid">
    <?= form_field('contact', 'first_name', $state, ['placeholder' => 'First name']) ?>
    <?= form_field('contact', 'last_name', $state, ['placeholder' => 'Last name']) ?>
    <?= form_field('contact', 'email', $state, ['placeholder' => 'you@example.com']) ?>
    <?= form_field('contact', 'phone', $state, ['placeholder' => 'e.g. 98765 43210']) ?>
    <?= form_field('contact', 'subject', $state, ['class' => 'span-2', 'placeholder' => 'What is your question about?']) ?>
    <?= form_field('contact', 'message', $state, ['class' => 'span-2', 'rows' => 5, 'placeholder' => 'Type your message']) ?>
  </div>
  <button class="btn btn-primary btn-block" type="submit" data-submit>
    <span data-submit-label>Send Message</span><?= icon('send') ?>
  </button>
  <p class="form-note">By submitting, you agree to our <a href="/privacy-policy/">Privacy Policy</a>.</p>
</form>
