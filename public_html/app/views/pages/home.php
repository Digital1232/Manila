<?php
defined('MIPS') || exit;
// Home page. All copy is from the original home page and its slider (July 2026 backup).
$history = [
    ['1994', 'Beginning', 'Marked the beginning of the hospital, established under the visionary guidance of Dr. P. Manimozhian.'],
    ['2002', 'Introduction', 'Introduced advanced Allergy Specialisation, setting a regional benchmark in immunology care.'],
    ['2006', 'Hospital', 'First hospital in Tirunelveli and South Districts to establish a dedicated Department of Pulmonology, transforming respiratory care in the region.'],
    ['2013', 'PCR – TB Testing', 'Introduced PCR-based TB Testing — delivering results in 1 hour and 30 minutes, enabling faster TB diagnosis and treatment.'],
    ['2018', 'Pulmonology', 'Pulmonology department graduates trained experts into mainstream clinical roles.'],
    ['2023', 'Dr. Nivya', 'Welcomed Dr. Nivya into the leadership team, strengthening hospital operations and academic collaborations.'],
    ['2025', 'Finding TB', 'Launch of “Find TB Before It Spreads” initiative – an advanced screening test that helps detect latent tuberculosis before it affects major organs.'],
];
$why = [
    ['award', 'Experienced & Indian-Certified Faculty', 'Learn from highly qualified professionals with real clinical experience and national certifications.'],
    ['book', 'Industry-Aligned Curriculum', 'Courses designed to meet current hospital and healthcare industry standards.'],
    ['hospital', 'Practical Training in Hospitals', 'Real-time, hands-on experience through our tie-up with Nivya Multispeciality Hospital.'],
    ['briefcase', 'Job-Oriented Diploma Courses', 'Specialized programs like DMLT, DOTT, DRIT, and DNM that lead to immediate career opportunities.'],
    ['wallet', 'Affordable Fee Structure', 'Low-cost education with value-packed training, ideal for both urban and rural students.'],
    ['map-pin', 'Accessible for Rural Students', 'Located in Vannarapettai, Tirunelveli, our campus is easy to reach from nearby towns and villages.'],
    ['users', 'Strong Placement Support', '100% placement guidance with access to hospitals, labs, and clinics across Tamil Nadu.'],
];
$focusAreas = ['Clinical Cardiology', 'Diabetes Management', 'Hypertension', 'Thyroid Disorders', 'Pain Management', 'Comprehensive General Health'];
?>
<section class="hero">
  <?= img('home/hero-students-laboratory.webp', '', ['class' => 'hero-bg', 'priority' => true, 'sizes' => '100vw']) ?>
  <div class="container hero-inner">
    <div class="hero-copy">
      <p class="eyebrow eyebrow-light"><?= e($site['tagline']) ?></p>
      <h1>Welcome to Manila Institute of <span class="hl">Paramedical Science</span></h1>
      <p class="lead">A trusted unit of Nivya Hospitals, empowering students with practical, hospital-based training and career-ready paramedical education in Tirunelveli.</p>
      <div class="btn-row">
        <a class="btn btn-primary btn-lg" href="#apply">Apply Now <?= icon('arrow-right') ?></a>
        <a class="btn btn-light btn-lg" href="/courses/">Explore Courses</a>
      </div>
    </div>
  </div>
</section>

<section class="highlights" aria-label="Key facts">
  <div class="container">
    <ul class="highlight-grid">
      <li><span class="highlight-icon"><?= icon('graduation') ?></span><span><strong>4 Diploma Courses</strong>DNM, DMLT, DOTT &amp; DRIT</span></li>
      <li><span class="highlight-icon"><?= icon('clock') ?></span><span><strong>2 Years</strong>Course duration</span></li>
      <li><span class="highlight-icon"><?= icon('hospital') ?></span><span><strong>Since 1994</strong>Nivya Hospitals legacy</span></li>
      <li><span class="highlight-icon"><?= icon('users') ?></span><span><strong>Placement Guidance</strong>Hospitals, labs &amp; clinics</span></li>
    </ul>
  </div>
</section>

<section class="section" id="programs">
  <div class="container">
    <div class="section-head split">
      <div>
        <p class="eyebrow">Diploma courses</p>
        <h2>Our Academic Programs</h2>
      </div>
      <p class="section-lead">Specialized programs like DMLT, DOTT, DRIT, and DNM that lead to immediate career opportunities, with practical training through our tie-up with Nivya Multispeciality Hospital.</p>
    </div>
    <div class="course-grid">
      <?php foreach (array_keys(courses()) as $key) partial('course-card', ['key' => $key]); ?>
    </div>
    <p class="center section-foot"><a class="btn btn-outline" href="/courses/">Compare all courses <?= icon('arrow-right') ?></a></p>
  </div>
</section>

<section class="section section-tint" id="legacy">
  <div class="container legacy-grid">
    <figure class="legacy-media">
      <?= img('home/nivya-hospital-legacy.webp', 'Dr. P. Manimozhian, founder of Nivya Respiratory Centre', ['sizes' => '(min-width: 1024px) 560px, 100vw']) ?>
      <figcaption class="since-badge"><span>Since</span><strong>1994</strong></figcaption>
    </figure>
    <div class="legacy-copy">
      <p class="eyebrow">Our legacy</p>
      <h2>Nivya Respiratory Centre started its journey in 1994</h2>
      <p class="legacy-founder">Founded by Dr. P. Manimozhian M.D. (Chest Medicine), DTCD, Dip in Allergy (UK), FCCP (USA).</p>
      <blockquote class="pull-quote">
        <?= icon('quote') ?>
        <p>Not All Heroes Wear Capes — Some Wear White Coats.</p>
      </blockquote>
      <p>Every single day, there are individuals who wake up with one unwavering mission: to heal. They don’t know who they’ll help or the stories behind each face—but they show up with the same compassion, dedication, and heart.</p>
      <p>At Nivya Respiratory and Multispeciality Hospital, we are proud to be led by such a hero — Dr. P. Manimozhian, a pioneer in pulmonary care in the southernmost part of India.</p>
    </div>
  </div>
  <div class="container legacy-cards">
    <article class="info-card">
      <h3>Our Legacy Begins: Dr. P. Manimozhian’s Vision</h3>
      <p>Founded in 1994, Nivya Respiratory Centre was the brainchild of Dr. P. Manimozhian M.D. (Chest Medicine), DTCD, Dip in Allergy (UK), FCCP (USA). With a clear mission to provide dedicated and specialized pulmonary care to the people of Southern India, he laid the foundation for a centre that would later evolve into a benchmark for respiratory medicine.</p>
      <p>In May 2002, Dr. Manimozhian furthered his specialization in Allergy care at the National Respiratory Training Centre, Warwick, UK, adding a global perspective to our local healthcare commitment.</p>
    </article>
    <article class="info-card">
      <h3>A Milestone in Respiratory Health: Nivya Respiratory &amp; Multispeciality Hospital</h3>
      <p>As demand grew, so did our scope. Dr. Manimozhian expanded the outpatient services and established the Nivya Respiratory and Multispeciality Hospital in Tirunelveli, offering world-class pulmonology services with state-of-the-art infrastructure.</p>
      <a class="link-arrow" href="<?= e($site['parent']['url']) ?>" rel="noopener" target="_blank">Visit Nivya Hospitals <?= icon('external') ?></a>
    </article>
    <figure class="info-card-media">
      <?= img('home/nivya-hospital-tirunelveli.webp', 'Entrance of Nivya Respiratory and Multispeciality Hospitals, Tirunelveli', ['sizes' => '(min-width: 1024px) 360px, 100vw']) ?>
    </figure>
  </div>
</section>

<section class="section" id="dr-nivya">
  <div class="container feature-grid">
    <figure class="feature-media">
      <?= img('home/dr-nivya-m.webp', 'Dr. Nivya M, MD (General Medicine)', ['sizes' => '(min-width: 1024px) 520px, 100vw']) ?>
    </figure>
    <div class="feature-copy">
      <p class="eyebrow">Expanding horizons with</p>
      <h2>Dr. Nivya M</h2>
      <p class="h-sub">A New Era in Multispeciality Care</p>
      <p>Bringing fresh energy and multidisciplinary care to our institution, Dr. Nivya M, MD (General Medicine), FCD (Diabetology), FCC (Clinical Cardiology), joined our journey on October 27 and has since transformed our facility into a dynamic multispeciality hub.</p>
      <h3 class="h-small">Specialized Focus Areas</h3>
      <ul class="check-list cols-2">
        <?php foreach ($focusAreas as $area): ?><li><?= icon('check') ?><?= e($area) ?></li><?php endforeach; ?>
      </ul>
      <p>Dr. Nivya’s vision of integrated, patient-centric care has driven us to adopt advanced diagnostic equipment, modern treatment protocols, and holistic healthcare delivery. Her presence ensures that we cater to a diverse range of medical needs, across all age groups and health backgrounds.</p>
      <p class="motto">We Heal With Heart. We Lead With Vision.</p>
    </div>
  </div>
</section>

<section class="section section-dark" id="history">
  <div class="container">
    <div class="section-head center">
      <p class="eyebrow eyebrow-light">Since 1994</p>
      <h2>Our History</h2>
    </div>
    <ol class="timeline">
      <?php foreach ($history as [$year, $title, $text]): ?>
      <li class="timeline-item">
        <span class="timeline-year"><?= e($year) ?></span>
        <div class="timeline-body">
          <h3><?= e($title) ?></h3>
          <p><?= e($text) ?></p>
        </div>
      </li>
      <?php endforeach; ?>
    </ol>
  </div>
</section>

<section class="section" id="why-us">
  <div class="container why-grid">
    <figure class="why-media">
      <?= img('home/hospital-based-training.webp', 'Students receiving hands-on medical training at Nivya Hospital, Tirunelveli', ['sizes' => '(min-width: 1024px) 480px, 100vw']) ?>
      <figcaption>Hospital-Based Training for Paramedical Students</figcaption>
    </figure>
    <div class="why-copy">
      <p class="eyebrow">Why Manila Institute</p>
      <h2>Why Choose Us?</h2>
      <ul class="why-list">
        <?php foreach ($why as [$ic, $title, $text]): ?>
        <li>
          <span class="why-icon"><?= icon($ic) ?></span>
          <div><h3><?= e($title) ?></h3><p><?= e($text) ?></p></div>
        </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
</section>

<?php partial('doctors'); ?>

<section class="section section-dark apply" id="apply">
  <div class="container apply-grid">
    <div class="apply-copy">
      <p class="eyebrow eyebrow-light">Admissions</p>
      <h2>Apply Now</h2>
      <p class="lead">Fill out the form to apply for your desired diploma course. Our team will get in touch with you shortly to guide you through the admission process.</p>
      <ul class="quick-contact">
        <li><a href="<?= e(tel_href($site['phones'][0])) ?>"><span class="qc-icon"><?= icon('phone') ?></span><span><small>Call admissions</small><?= e($site['phones'][0]) ?></span></a></li>
        <li><a href="<?= e(whatsapp_href('Hello, I would like to know more about admission at Manila Institute.')) ?>" rel="noopener" target="_blank"><span class="qc-icon qc-whatsapp"><?= icon('whatsapp') ?></span><span><small>Chat with us</small>WhatsApp</span></a></li>
      </ul>
      <figure class="admission-feature">
        <?= img('home/apply-now-student.webp', '', ['class' => 'admission-feature-image', 'sizes' => '160px']) ?>
        <figcaption>
          <span class="admission-feature-label">Your next step</span>
          <h3>Build your future in healthcare</h3>
          <p>Explore our diploma courses and speak with our admissions team.</p>
        </figcaption>
      </figure>
    </div>
    <div class="form-card">
      <h3 class="form-title">Admission enquiry</h3>
      <?php partial('form-admission', ['action' => '/']); ?>
    </div>
  </div>
</section>
