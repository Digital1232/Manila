<?php
defined('MIPS') || exit;
// Diploma in Radiology and Imaging Technology: copy from the original course page (spelling corrected,
// the repeated "Scope in Imaging and Radiology" heading merged into one section).
$applyUrl = '/admission/?course=drit#admission-form';
$skills = ['Operating radiology and imaging machines', 'Performing <strong>X-rays, Mobile X-rays,</strong> CT scans, and MRI procedures',
    'Patient positioning and radiation safety protocols', 'Image processing and reporting support', 'Understanding anatomy for effective imaging',
    'We incorporate <strong>ECHO Assist Learning</strong> through immersive, high-fidelity simulation experiences'];
$modes = ['B-Mode (2D Ultrasound)', 'M-Mode', 'Color Doppler', 'Power Doppler', 'Spectral Doppler', '3D Ultrasound', '4D Ultrasound',
    'High-Frequency Linear Probe Imaging', 'Transvaginal Ultrasound', 'Transrectal Ultrasound', 'Interventional / Guided Ultrasound', 'Elastography (Advanced)'];
$jobs = ['Radiology / Imaging Technician / Radiographer', 'X-ray / CT / MRI / Ultrasound technician',
    'Diagnostic Centre Technician (in hospitals, clinics, imaging labs)', 'Radiology Assistant in research labs or medical equipment companies (less common)'];
?>
<section class="section">
  <div class="container two-col">
    <div>
      <p class="eyebrow">Academics</p>
      <h2>About the DRIT programme</h2>
      <p class="text-lg">The <strong>Diploma in Radiology and Imaging Technology (DRIT)</strong> at <strong>Manila Institute of Paramedical Science</strong> is a specialized program that trains students in diagnostic imaging techniques like <strong>X-ray, CT Scan, MRI</strong>, and <strong>ultrasound</strong>. This course is ideal for those who want to assist doctors in <strong>diagnosing internal health conditions</strong> through advanced imaging tools.</p>
      <p>The course includes <strong>clinical postings in diagnostic centers and hospitals</strong> across <strong>Tirunelveli</strong>, providing students with real-world exposure to imaging environments.</p>
    </div>
    <article class="card">
      <span class="card-icon"><?= icon('scan') ?></span>
      <h3>Students gain practical skills in:</h3>
      <ul class="check-list">
        <?php foreach ($skills as $s): ?><li><?= icon('check') ?><span><?= $s ?></span></li><?php endforeach; ?>
      </ul>
    </article>
  </div>
</section>

<section class="section section-tint">
  <div class="container feature-grid">
    <figure class="feature-media">
      <?= img('courses/drit/ultrasonography-training.webp', 'Radiology student practising ultrasonography', ['sizes' => '(min-width: 1024px) 520px, 100vw']) ?>
    </figure>
    <div class="feature-copy">
      <p class="eyebrow">Ultrasound</p>
      <h2>Ultrasonography (USG) in Radiology &amp; Imaging Technology</h2>
      <h3 class="h-small">What is USG?</h3>
      <p>Ultrasonography (USG), also called ultrasound or sonography, is a non-invasive imaging technique that uses high-frequency sound waves to create real-time images of internal body structures. Unlike X-rays and CT scans, ultrasound does <em>not</em> use ionising radiation — making it a safe, repeatable modality.</p>
      <h3 class="h-small">Ultrasound (USG): Description &amp; Types</h3>
      <p>Ultrasonography (USG) is a safe, non-invasive imaging technique that uses high-frequency sound waves to produce real-time images of internal organs, tissues, and blood flow. It is widely used in medical diagnostics due to its accuracy, portability, and lack of radiation exposure. In the DRIT programme, students gain hands-on training in operating different ultrasound modes used across abdominal, obstetric, vascular, musculoskeletal, and soft-tissue imaging.</p>
      <h4 class="h-xsmall">Types of USG Modes</h4>
      <ul class="chip-list">
        <?php foreach ($modes as $m): ?><li><?= e($m) ?></li><?php endforeach; ?>
      </ul>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="two-col two-col-top">
      <div>
        <p class="eyebrow">Scope</p>
        <h2>Scope in Imaging and Radiology</h2>
        <p>Students enrolled in this diploma gain comprehensive knowledge and practical skills in various imaging techniques such as X-ray, ultrasound, computed tomography (CT), magnetic resonance imaging (MRI), and more.</p>
        <p>They learn to operate advanced imaging equipment, ensure patient safety during procedures, and interpret diagnostic images accurately. This diploma opens doors to a rewarding career in the rapidly evolving field of medical imaging, where professionals play a crucial role in diagnosing and treating medical conditions.</p>
        <p>Radiology is the branch of medicine that uses imaging techniques to diagnose and sometimes treat diseases. Imaging helps doctors see inside the body without surgery. Common types of medical imaging include:</p>
        <ol class="number-list">
          <li>X-rays</li>
          <li>Ultrasound (including echocardiography)</li>
          <li>CT scans (Computed Tomography)</li>
          <li>MRI (Magnetic Resonance Imaging)</li>
          <li>Nuclear medicine scans (e.g., PET scans)</li>
        </ol>
        <p class="section-foot"><a class="btn btn-primary" href="<?= e($applyUrl) ?>">Join Course <?= icon('arrow-right') ?></a></p>
      </div>
      <figure class="feature-media">
        <?= img('courses/drit/radiology-monitors.webp', 'Radiology imaging monitors in the diagnostic room', ['sizes' => '(min-width: 1024px) 560px, 100vw']) ?>
      </figure>
    </div>
    <div class="card-grid cols-2 mt-lg">
      <article class="card">
        <span class="card-icon"><?= icon('scan') ?></span>
        <h3>X-ray</h3>
        <p><strong>How it works:</strong> Uses electromagnetic radiation to create images of bones and certain tissues. Dense structures like bones absorb more X-rays and appear white, while softer tissues appear gray, and air appears black.</p>
        <p><strong>Uses:</strong></p>
        <ul class="bullet-list">
          <li>Detect bone fractures</li>
          <li>Check for infections (like pneumonia)</li>
          <li>Detect tumors</li>
          <li>Evaluate joint abnormalities</li>
        </ul>
        <dl class="pros-cons">
          <div><dt>Advantages</dt><dd>Quick, widely available, inexpensive</dd></div>
          <div><dt>Limitations</dt><dd>Limited detail for soft tissues, involves small radiation exposure</dd></div>
        </dl>
      </article>
      <article class="card">
        <span class="card-icon"><?= icon('heart-pulse') ?></span>
        <h3>Echocardiography (Echo Scan)</h3>
        <p><strong>Type:</strong> Ultrasound imaging specifically for the heart.</p>
        <p><strong>How it works:</strong> Uses high-frequency sound waves to create images of the heart in real time.</p>
        <p><strong>Uses:</strong></p>
        <ul class="bullet-list">
          <li>Evaluate heart structure: chambers, valves, and walls</li>
          <li>Measure heart function (how well the heart pumps)</li>
          <li>Detect congenital heart defects or heart disease</li>
          <li>Assess blood flow with Doppler echocardiography</li>
        </ul>
        <dl class="pros-cons">
          <div><dt>Advantages</dt><dd>Non-invasive, no radiation, real-time imaging</dd></div>
          <div><dt>Types of echo</dt><dd>Transthoracic echocardiogram (TTE): standard external scan. Transesophageal echocardiogram (TEE): probe goes down the esophagus for detailed images. Stress echo: evaluates heart function under stress.</dd></div>
        </dl>
      </article>
    </div>
  </div>
</section>

<section class="section section-tint">
  <div class="container narrow center-block">
    <p class="eyebrow">Careers</p>
    <h2>After you finish, you may get job opportunities as</h2>
    <ol class="job-list">
      <?php foreach ($jobs as $i => $j): ?><li><span class="job-num"><?= $i + 1 ?></span><?= e($j) ?></li><?php endforeach; ?>
    </ol>
    <p class="section-foot"><a class="btn btn-primary" href="<?= e($applyUrl) ?>">Join Course <?= icon('arrow-right') ?></a></p>
  </div>
</section>

<?php $whyTint = false; // the section above is tinted
partial('course-why', [
    'course' => 'drit',
    'tint' => $whyTint,
    'image' => 'courses/drit/why-choose-manila-institute.webp',
    'alt' => 'Radiology student positioning a patient for an X-ray',
    'items' => ['Located in Tirunelveli with direct hospital and diagnostic center tie-ups', 'State-of-the-art imaging lab and modern equipment',
        'Experienced faculty with clinical radiology background', 'High demand career with strong placement support', 'Recognized as a top paramedical college in Tamil Nadu'],
]); ?>
