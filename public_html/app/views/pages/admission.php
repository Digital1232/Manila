<?php
defined('MIPS') || exit;
// Admission (the original "How to Apply" page). Requirements and documents exactly as published.
$requirements = [
    'Minimum age 15 years',
    'The course is open to Male &amp; Female candidates',
    '+2 pass / fail (45%) from a recognized Board / University',
    'Sound health',
];
$documents = ['10th, +1 and +2 mark sheets', 'Transfer certificate', 'Conduct certificate', 'Community certificate', 'Nativity certificate',
    'Passport size photos (10)', 'Aadhar card colour Xerox'];
$waText = 'Hello, I would like to know more about admission at Manila Institute.';
partial('page-hero', [
    'crumbs' => $crumbs,
    'eyebrow' => 'Admission',
    'title' => 'How to Apply',
    'lead' => 'Getting started with your paramedical career is simple at <strong>Manila Institute of Paramedical Science</strong>. Just follow the steps below to apply for any of our diploma programs.',
    'image' => 'shared/page-hero-healthcare.webp',
    'actions' => '<a class="btn btn-primary btn-lg" href="#admission-form">Apply Now ' . icon('arrow-right') . '</a>'
        . '<a class="btn btn-whatsapp btn-lg" href="' . e(whatsapp_href($waText)) . '" rel="noopener" target="_blank">' . icon('whatsapp') . ' WhatsApp Now</a>',
]);
partial('apply-steps', ['link' => false, 'id' => 'steps']);
?>
<section class="section" id="requirements">
  <div class="container req-grid">
    <div class="req-main">
      <p class="eyebrow">Eligibility</p>
      <h2>Graduate Diploma Requirements</h2>
      <ul class="check-list check-list-lg">
        <?php foreach ($requirements as $r): ?><li><?= icon('check-circle') ?><span><?= $r ?></span></li><?php endforeach; ?>
      </ul>
      <h3 class="h-small mt-md">List of required documents</h3>
      <ul class="doc-list">
        <?php foreach ($documents as $d): ?><li><?= icon('file') ?><?= e($d) ?></li><?php endforeach; ?>
      </ul>
      <p class="note"><?= icon('info') ?><span>All documents to be taken as colour photocopies and handed over to the admin.</span></p>
    </div>
    <aside class="req-side">
      <div class="card programmes-card">
        <h2 class="h-card">Programmes Offered</h2>
        <ul class="programme-list">
          <?php foreach (['drit', 'dmlt', 'dott', 'dnm'] as $key): $c = courses()[$key]; ?>
          <li>
            <a href="<?= e(course_url($key)) ?>">
              <span class="programme-icon"><?= icon($c['icon']) ?></span>
              <span class="programme-name"><?= e($c['full']) ?></span>
              <span class="programme-duration"><?= e($c['duration']) ?></span>
            </a>
          </li>
          <?php endforeach; ?>
        </ul>
      </div>
      <figure class="form-download">
        <a href="/assets/img/admission/application-for-admission-form.jpg" target="_blank" rel="noopener">
          <?= img('admission/application-for-admission-form-preview.webp', 'Application for Admission form of Manila Institute of Paramedical Science', ['sizes' => '(min-width: 1024px) 360px, 100vw']) ?>
        </a>
        <figcaption>
          <strong>Application for Admission form</strong>
          <a class="link-arrow" href="/assets/img/admission/application-for-admission-form.jpg" download="Manila-Institute-Application-Form.jpg"><?= icon('download') ?> Download to print</a>
        </figcaption>
      </figure>
    </aside>
  </div>
</section>

<section class="section section-dark apply" id="apply">
  <div class="container apply-grid">
    <div class="apply-copy">
      <p class="eyebrow eyebrow-light">Enquire now</p>
      <h2>Are you ready to take the next step toward your future career?</h2>
      <p class="lead">Fill out the form to apply for your desired diploma course. Our team will get in touch with you shortly to guide you through the admission process.</p>
      <ul class="quick-contact">
        <li><a href="<?= e(tel_href($site['phones'][0])) ?>"><span class="qc-icon"><?= icon('phone') ?></span><span><small>Call admissions</small><?= e($site['phones'][0]) ?></span></a></li>
        <li><a href="<?= e(whatsapp_href($waText)) ?>" rel="noopener" target="_blank"><span class="qc-icon qc-whatsapp"><?= icon('whatsapp') ?></span><span><small>Chat with us</small>WhatsApp</span></a></li>
      </ul>
      <figure class="admission-feature admission-feature-photo">
        <?= img('admission/student-course-joining.webp', 'Student holding her admission folder at Manila Institute', ['class' => 'admission-feature-image', 'sizes' => '160px']) ?>
        <figcaption>
          <span class="admission-feature-label">Here to guide you</span>
          <h3>Start your admission journey</h3>
          <p>Need help choosing a course? Our team can guide you through the next steps.</p>
        </figcaption>
      </figure>
    </div>
    <div class="form-card">
      <h3 class="form-title">Admission enquiry</h3>
      <?php partial('form-admission', ['action' => '/admission/']); ?>
    </div>
  </div>
</section>
