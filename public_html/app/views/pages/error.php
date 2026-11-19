<?php
defined('MIPS') || exit;
$code = (int)($page['code'] ?? 404);
$messages = [
    404 => 'The page you are looking for does not exist or may have moved. Our website has been rebuilt, so some old links have changed.',
    405 => 'This page cannot be used that way. Please go back and try again.',
    410 => 'This page has been permanently removed from our website.',
];
?>
<section class="section error-page">
  <div class="container narrow center-block">
    <p class="error-code"><?= $code ?></p>
    <h1><?= e($page['label']) ?></h1>
    <p class="text-lg"><?= e($messages[$code] ?? 'Something went wrong.') ?></p>
    <div class="btn-row center-row">
      <a class="btn btn-primary" href="/">Go to the home page</a>
      <a class="btn btn-outline" href="/courses/">View our courses</a>
    </div>
    <ul class="error-links">
      <li><a href="/about-us/">About Us</a></li>
      <li><a href="/admission/">Admission</a></li>
      <li><a href="/contact-us/">Contact Us</a></li>
    </ul>
  </div>
</section>
