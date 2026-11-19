<?php
defined('MIPS') || exit;
$site = site();
?>
<footer class="site-footer">
  <div class="container footer-grid">
    <div class="footer-brand">
      <a href="/" class="footer-logo" aria-label="<?= e($site['name']) ?>, home page">
        <img src="/assets/img/brand/manila-institute-logo-white.webp" width="380" height="150" alt="<?= e($site['name']) ?>" loading="lazy" decoding="async">
      </a>
      <p><?= e($site['description']) ?></p>
      <ul class="social" aria-label="Nivya Hospitals on social media">
        <?php foreach ($site['social'] as $key => $s): ?>
        <li><a href="<?= e($s['url']) ?>" rel="noopener" target="_blank" aria-label="<?= e($s['label']) ?> (opens in a new tab)"><?= icon($key) ?></a></li>
        <?php endforeach; ?>
      </ul>
    </div>
    <nav class="footer-col" aria-label="Footer">
      <h2 class="footer-title">Main navigation</h2>
      <ul class="footer-links">
        <li><a href="/">Home</a></li>
        <li><a href="/about-us/">About Us</a></li>
        <li><a href="/courses/">Courses</a></li>
        <li><a href="/admission/">Admission</a></li>
        <li><a href="/contact-us/">Contact Us</a></li>
      </ul>
    </nav>
    <div class="footer-col">
      <h2 class="footer-title">Courses</h2>
      <ul class="footer-links">
        <?php foreach (courses() as $key => $c): ?>
        <li><a href="<?= e(course_url($key)) ?>"><?= e($c['full']) ?></a></li>
        <?php endforeach; ?>
      </ul>
    </div>
    <div class="footer-col">
      <h2 class="footer-title">Contact</h2>
      <ul class="footer-contact">
        <li><?= icon('map-pin') ?><a href="<?= e($site['map_url']) ?>" rel="noopener" target="_blank"><?= e($site['address']['line1']) ?>, <?= e($site['address']['line2']) ?></a></li>
        <li><?= icon('phone') ?><span class="footer-phones"><?php foreach ($site['phones'] as $p): ?><a href="<?= e(tel_href($p)) ?>"><?= e($p) ?></a><?php endforeach; ?></span></li>
        <li><?= icon('mail') ?><a href="mailto:<?= e($site['email']) ?>"><?= e($site['email']) ?></a></li>
      </ul>
    </div>
  </div>
  <div class="footer-bottom">
    <div class="container footer-bottom-inner">
      <p>© <?= date('Y') ?> <?= e($site['name']) ?>. A unit of <a href="<?= e($site['parent']['url']) ?>" rel="noopener" target="_blank"><?= e($site['parent']['name']) ?></a>. All rights reserved.</p>
      <ul class="footer-legal">
        <li><a href="/privacy-policy/">Privacy Policy</a></li>
        <li><a href="/terms-conditions/">Terms &amp; Conditions</a></li>
      </ul>
    </div>
  </div>
</footer>
