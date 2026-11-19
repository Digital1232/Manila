<?php
defined('MIPS') || exit;
// About Us. Copy from the original About page.
partial('page-hero', [
    'crumbs' => $crumbs,
    'eyebrow' => 'About Us',
    'title' => 'Empowering Paramedical Excellence',
    'lead' => 'Manila Institute of Paramedical Science, located in Vannarapettai, Tirunelveli, was established with a vision to bridge the growing demand for qualified paramedical professionals in hospitals, clinics, and diagnostic centers across Tamil Nadu.',
    'image' => 'about/about-hero.webp',
]);
?>
<section class="section">
  <div class="container feature-grid">
    <figure class="feature-media">
      <?= img('about/manila-institute-tirunelveli.webp', 'Manila Institute of Paramedical Science, Tirunelveli', ['sizes' => '(min-width: 1024px) 560px, 100vw']) ?>
    </figure>
    <div class="feature-copy">
      <p class="eyebrow">Who we are</p>
      <h2>At Manila Institute of Paramedical Science</h2>
      <p>We offer industry-focused diploma courses in Nursing, Medical Laboratory Technology, Radiology &amp; Imaging, and Operation Theatre Technology, backed by experienced faculty and hands-on clinical training. With modern lab infrastructure and hospital tie-ups in Tirunelveli, our mission is to deliver practical, job-ready paramedical education that prepares students for real-world healthcare careers.</p>
      <p>We strongly believe that learning is most effective when theory meets practice. That’s why all our diploma programs include <strong>real-time hospital training</strong>, <strong>laboratory sessions</strong>, and <strong>clinical exposure</strong> under expert supervision. Our students are trained to confidently assist in diagnostics, emergency procedures, and patient care operations from day one.</p>
      <p>With a growing demand for <strong>qualified paramedics</strong> in <strong>Tirunelveli</strong>, <strong>Tamil Nadu</strong>, and across India, we ensure our students are not just educated — they are <strong>employable and industry-ready</strong>. Graduates from our institute go on to build careers in <strong>multi-specialty hospitals, private labs, nursing homes</strong>, and even international healthcare institutions.</p>
    </div>
  </div>
</section>

<section class="section section-tint">
  <div class="container narrow">
    <div class="support-block">
      <span class="support-icon"><?= icon('graduation') ?></span>
      <div>
        <p class="eyebrow">Student guidance &amp; careers</p>
        <h2>Choosing the right paramedical college is the first step toward a successful healthcare career.</h2>
        <p>At Manila Institute of Paramedical Science, we offer personalized academic guidance, regular workshops, and career counselling to help students succeed both academically and professionally. We also provide support in building resumes and preparing for job interviews in the medical field.</p>
        <p>Our alumni are a testament to the quality of education we provide — many now work as lab technicians, radiology assistants, operation theatre technologists, and nursing staff in reputed medical facilities. Whether your goal is employment, entrepreneurship, or higher studies, we prepare you for every opportunity in the ever-growing healthcare sector.</p>
        <a class="btn btn-secondary" href="/admission/">Learn More <?= icon('arrow-right') ?></a>
      </div>
    </div>
  </div>
</section>

<section class="section" id="vision-mission">
  <div class="container">
    <div class="section-head center">
      <p class="eyebrow">What drives us</p>
      <h2>Vision &amp; Mission</h2>
    </div>
    <div class="vm-grid">
      <article class="vm-card">
        <?= img('home/nivya-hospital-tirunelveli.webp', 'Nivya Respiratory and Multispeciality Hospitals, Tirunelveli', ['class' => 'vm-img', 'sizes' => '(min-width: 1024px) 560px, 100vw']) ?>
        <div class="vm-body">
          <h3><span class="vm-icon"><?= icon('award') ?></span>Vision</h3>
          <p>To be a globally recognized centre of excellence in paramedical education, inspiring and empowering students to become compassionate, skilled, and ethical healthcare professionals. We envisage a world where healthcare professionals are equipped not only with exceptional knowledge and skills but also with an unwavering dedication to compassion and ethical practice. To ensure better patient care through affordable, accessible services to the community.</p>
        </div>
      </article>
      <article class="vm-card">
        <?= img('about/mission-manila-paramedical-college.webp', 'Aerial view of the Manila Institute and Nivya Hospitals campus, Tirunelveli', ['class' => 'vm-img', 'sizes' => '(min-width: 1024px) 560px, 100vw']) ?>
        <div class="vm-body">
          <h3><span class="vm-icon"><?= icon('heart-pulse') ?></span>Mission</h3>
          <p>The mission of the courses of Paramedical and Health Sciences is to provide meaningful education and students will learn to integrate their knowledge, skills and abilities in a hands-on manner in the professional healthcare setting. We strive to create a supportive and unique learning environment that encourages personal and professional growth, and empowers our graduates to make a positive impact in their communities. We are committed to provide an excellent teaching and hands-on training to ensure that all of our graduates are well-prepared to satisfy all the needs of the healthcare sector.</p>
        </div>
      </article>
    </div>
  </div>
</section>

<?php partial('doctors'); ?>

<?php partial('cta-band', [
    'heading' => 'Are you ready to take the next step toward your <span>future career?</span>',
    'text' => 'Apply now for a diploma course at Manila Institute of Paramedical Science, Tirunelveli.',
]); ?>
