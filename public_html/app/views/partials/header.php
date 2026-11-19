<?php
defined('MIPS') || exit;
$site = site();
$nav = $page['nav'] ?? '';
$current = fn(string $key) => $nav === $key ? ' aria-current="page"' : '';
$isActive = fn(string $key) => $nav === $key ? ' is-active' : '';
?>
<div class="topbar">
  <div class="container topbar-inner">
    <p class="topbar-note"><?= icon('hospital') ?> <?= e($site['tagline']) ?>, Tirunelveli</p>
    <ul class="topbar-links">
      <li><a href="<?= e(tel_href($site['phones'][0])) ?>"><?= icon('phone') ?> <?= e($site['phones'][0]) ?></a></li>
      <li><a href="mailto:<?= e($site['email']) ?>"><?= icon('mail') ?> <?= e($site['email']) ?></a></li>
    </ul>
    <ul class="social social-topbar" aria-label="Nivya Hospitals on social media">
      <?php foreach ($site['social'] as $key => $s): ?>
      <li><a href="<?= e($s['url']) ?>" rel="noopener" target="_blank" aria-label="<?= e($s['label']) ?> (opens in a new tab)"><?= icon($key) ?></a></li>
      <?php endforeach; ?>
    </ul>
  </div>
</div>
<header class="site-header" data-header>
  <div class="container header-inner">
    <a class="brand" href="/" aria-label="<?= e($site['name']) ?>, home page">
      <img src="/assets/img/brand/manila-institute-logo.webp" width="380" height="150" alt="<?= e($site['name']) ?>, a unit of Nivya Hospitals">
    </a>
    <button class="nav-toggle" type="button" aria-expanded="false" aria-controls="site-nav" data-nav-toggle>
      <span class="nav-toggle-open"><?= icon('menu') ?></span>
      <span class="nav-toggle-close"><?= icon('close') ?></span>
      <span class="nav-toggle-label">Menu</span>
    </button>
    <nav class="site-nav" id="site-nav" aria-label="Main" data-nav>
      <ul class="nav-list">
        <li class="nav-item<?= $isActive('home') ?>"><a class="nav-link" href="/"<?= $current('home') ?>>Home</a></li>
        <li class="nav-item<?= $isActive('about') ?>"><a class="nav-link" href="/about-us/"<?= $current('about') ?>>About Us</a></li>
        <li class="nav-item has-sub<?= $isActive('courses') ?>" data-sub>
          <a class="nav-link" href="/courses/"<?= ($page['key'] ?? '') === 'courses' ? ' aria-current="page"' : '' ?>>Courses</a>
          <button class="sub-toggle" type="button" aria-expanded="false" aria-controls="sub-courses" data-sub-toggle>
            <?= icon('chevron-down') ?><span class="sr-only">Show the course list</span>
          </button>
          <ul class="sub-menu" id="sub-courses">
            <?php foreach (courses() as $key => $c): ?>
            <li>
              <a href="<?= e(course_url($key)) ?>"<?= ($page['course'] ?? '') === $key ? ' aria-current="page"' : '' ?>>
                <span class="sub-icon"><?= icon($c['icon']) ?></span>
                <span><strong><?= e($c['title']) ?></strong><small><?= e($c['abbr']) ?> · <?= e($c['duration']) ?></small></span>
              </a>
            </li>
            <?php endforeach; ?>
            <li class="sub-all"><a href="/courses/">Compare all courses <?= icon('arrow-right') ?></a></li>
          </ul>
        </li>
        <li class="nav-item<?= $isActive('admission') ?>"><a class="nav-link" href="/admission/"<?= $current('admission') ?>>Admission</a></li>
        <li class="nav-item<?= $isActive('contact') ?>"><a class="nav-link" href="/contact-us/"<?= $current('contact') ?>>Contact Us</a></li>
      </ul>
      <div class="nav-actions">
        <a class="nav-phone" href="<?= e(tel_href($site['phones'][0])) ?>"><?= icon('phone') ?><span><small>Admissions</small><?= e($site['phones'][0]) ?></span></a>
        <a class="btn btn-primary" href="/admission/#admission-form">Apply Now</a>
      </div>
    </nav>
  </div>
</header>
