<?php
defined('MIPS') || exit;
// Contact Us. Copy and details from the original Contact page and site footer.
$mapEmbed = 'https://maps.google.com/maps?q=' . rawurlencode($site['map_query']) . '&output=embed';
partial('page-hero', [
    'crumbs' => $crumbs,
    'eyebrow' => 'Contact Us',
    'title' => 'Manila Institute of Paramedical Science <span class="hero-sub">A Unit of Nivya Hospitals</span>',
    'lead' => 'Take the first step toward a rewarding career in healthcare with confidence. Whether you have questions about our courses, admission process, or campus facilities, our team at Manila Institute of Paramedical Science is always ready to guide you.',
    'image' => 'contact/contact-hero.webp',
]);
?>
<section class="section">
  <div class="container contact-grid">
    <div class="contact-info">
      <article class="contact-card">
        <span class="contact-icon"><?= icon('map-pin') ?></span>
        <div>
          <h2 class="h-card">Visit us</h2>
          <p><?= e($site['address']['line1']) ?><br><?= e($site['address']['line2']) ?><br><?= e($site['address']['region']) ?></p>
          <a class="link-arrow" href="<?= e($site['map_url']) ?>" rel="noopener" target="_blank">Get directions <?= icon('external') ?></a>
        </div>
      </article>
      <article class="contact-card">
        <span class="contact-icon"><?= icon('phone') ?></span>
        <div>
          <h2 class="h-card">Call us</h2>
          <ul class="phone-list">
            <?php foreach ($site['phones'] as $p): ?><li><a href="<?= e(tel_href($p)) ?>"><?= e($p) ?></a></li><?php endforeach; ?>
          </ul>
        </div>
      </article>
      <article class="contact-card">
        <span class="contact-icon"><?= icon('mail') ?></span>
        <div>
          <h2 class="h-card">Email us</h2>
          <p><a href="mailto:<?= e($site['email']) ?>"><?= e($site['email']) ?></a></p>
        </div>
      </article>
      <article class="contact-card contact-card-whatsapp">
        <span class="contact-icon"><?= icon('whatsapp') ?></span>
        <div>
          <h2 class="h-card">WhatsApp</h2>
          <p>Chat with our admissions team on WhatsApp.</p>
          <a class="btn btn-whatsapp btn-sm" href="<?= e(whatsapp_href('Hello, I have a question for Manila Institute.')) ?>" rel="noopener" target="_blank"><?= icon('whatsapp') ?> Chat now</a>
        </div>
      </article>
    </div>
    <div class="form-card form-card-light">
      <h2>Have a question or want to request a call back?</h2>
      <p class="form-intro">Fill out the form below and we’ll get in touch shortly.</p>
      <?php partial('form-contact', ['action' => '/contact-us/']); ?>
    </div>
  </div>
</section>

<section class="map-section" aria-label="Location map">
  <iframe class="map-frame" src="<?= e($mapEmbed) ?>" title="Map showing <?= e($site['parent']['name']) ?>, Vannarapettai, Tirunelveli" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
</section>
