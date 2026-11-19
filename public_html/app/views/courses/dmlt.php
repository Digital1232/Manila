<?php
defined('MIPS') || exit;
// Diploma in Medical Laboratory Technology: copy from the original course page (spelling corrected).
$applyUrl = '/admission/?course=dmlt#admission-form';
$tests = ['Pulmonary Function Testing (PFT) – to diagnose, stage, and monitor lung diseases', 'Impulse Oscillometry (IOS)',
    'FeNO Test Machine – for airway inflammation', '6-Minute Walk Test – for exercise tolerance and lung function',
    'Spirometry Machine – for measuring airflow and lung capacity'];
$modules = ['LFT', 'CAD Marker', 'Infection Marker', 'Microbiology and Pathology', 'Mycology', 'Clinical Biochemistry'];
$duties = ['Collecting samples of blood and other substances', 'Performing lab tests on samples and analyzing results',
    'Ensuring quality control of samples', 'Adhering to a laboratory’s standards and policies', 'Preparing samples and processing them as needed',
    'Operating lab equipment, such as microscopes and cell counters', 'Logging test data into patients’ medical records'];
$roles = ['Medical Laboratory Technician / Technologist', 'Pathology Lab Assistant / Technician', 'Blood Bank Technician', 'Clinical Laboratory Technologist',
    'Phlebotomist (collecting blood / fluid samples)', 'Histopathology / Cytology Technician (tissue/cell analysis)', 'Quality Control / Lab-management Staff',
    'Research Lab Assistant (in hospitals / diagnostic labs / research institutes)'];
$areas = [
    ['Diagnostic Laboratory Services', 'Diploma holders can perform routine laboratory tests to assist in diagnosing diseases. This includes:', ['Hematology', 'Clinical Biochemistry', 'Microbiology', 'Immunology/Serology', 'Urinalysis and Body Fluids', 'Parasitology']],
    ['Sample Collection &amp; Handling', '', ['Collecting blood, urine, swabs, and other specimens following proper protocols.', 'Ensuring safe handling, storage, and transportation of biological samples.', 'Maintaining proper labeling and documentation.']],
    ['Laboratory Maintenance &amp; Quality Control', '', ['Calibrating, maintaining, and troubleshooting laboratory instruments.', 'Ensuring cleanliness and sterilization of equipment and lab environment.', 'Implementing quality control procedures to maintain test accuracy.']],
    ['Record Keeping &amp; Reporting', '', ['Maintaining patient records, lab reports, and test results.', 'Communicating lab results accurately to doctors or healthcare teams.']],
    ['Specialized Areas (Optional/Advanced Training)', 'Some diploma holders can work in:', ['Blood Bank Technology', 'Histopathology/Cytology', 'Molecular Diagnostics (basic level)']],
    ['Employment Opportunities', 'DMLT holders can work in:', ['Hospitals, clinics, and diagnostic labs.', 'Blood banks and transfusion services.', 'Research laboratories and pharmaceutical companies.', 'Government health departments and public health labs.', 'Private pathology labs and wellness centers.']],
];
$gallery = [
    ['courses/dmlt/diagnostic-laboratory-services.webp', 'Laboratory technician running diagnostic tests', 'Diagnostic Laboratory Services'],
    ['courses/dmlt/laboratory-maintenance-quality-control.webp', 'Laboratory instruments being checked for quality control', 'Laboratory Maintenance & Quality Control'],
    ['courses/dmlt/specialized-areas-advanced-training.webp', 'Student working in a specialized laboratory area', 'Specialized Areas & Advanced Training'],
];
?>
<section class="section">
  <div class="container feature-grid">
    <figure class="feature-media feature-media-tall">
      <?= img('courses/dmlt/respiratory-lab-diagnostics.webp', 'Respiratory lab diagnostics at Nivya Hospitals', ['sizes' => '(min-width: 1024px) 460px, 100vw']) ?>
    </figure>
    <div class="feature-copy">
      <p class="eyebrow">Academics</p>
      <h2>About the DMLT programme</h2>
      <p class="text-lg">The Diploma in Medical Laboratory Technology is a career-focused paramedical program that prepares students for technical roles in medical laboratories. The course emphasizes clinical lab procedures, diagnostic testing, and the safe handling of samples, making it ideal for students interested in the investigative side of healthcare.</p>
      <h3 class="h-small">Our respiratory lab</h3>
      <p>A respiratory lab is a specialized area dedicated to diagnosing and managing lung and breathing disorders. Major conditions evaluated include: Bronchial Asthma, COPD, Interstitial Lung Disease, Bronchiectasis, Post-TB &amp; Post-COVID lung diseases, Pulmonary Hypertension, Lung and Thoracic Cancers, Sleep-disordered Breathing (including Sleep Apnea), and Lung Infections (such as tuberculosis, bacterial, and fungal infections).</p>
      <p>The lab provides a range of advanced diagnostic tests, including:</p>
      <ul class="check-list">
        <?php foreach ($tests as $t): ?><li><?= icon('check') ?><?= e($t) ?></li><?php endforeach; ?>
      </ul>
    </div>
  </div>
</section>

<section class="section section-tint">
  <div class="container two-col">
    <div>
      <p class="eyebrow">Scope</p>
      <h2>Scope in Medical Lab Technician (MLT) Course</h2>
      <p>Medical Laboratory Technicians are health professionals who deal with diagnosing, treating and preventing diseases by performing clinical laboratory tests. It combines classroom lectures, practical laboratory sessions, internships, and assessments. Core modules generally include:</p>
      <ul class="chip-list">
        <?php foreach ($modules as $m): ?><li><?= e($m) ?></li><?php endforeach; ?>
      </ul>
      <p class="section-foot"><a class="btn btn-primary" href="<?= e($applyUrl) ?>">Join Course <?= icon('arrow-right') ?></a></p>
    </div>
    <article class="card">
      <span class="card-icon"><?= icon('flask') ?></span>
      <h3>Medical laboratory technician responsibilities</h3>
      <p>Laboratory technicians have a wide range of responsibilities that might vary depending on their particular laboratory setting. These day-to-day tasks may include the following:</p>
      <ul class="check-list">
        <?php foreach ($duties as $d): ?><li><?= icon('check') ?><?= e($d) ?></li><?php endforeach; ?>
      </ul>
    </article>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="section-head center">
      <p class="eyebrow">Careers</p>
      <h2>Career Opportunities &amp; Roles After DMLT</h2>
      <p class="section-lead">After completing DMLT, you can work in a variety of roles in healthcare, diagnostics and allied fields. Some common job roles and workplaces:</p>
    </div>
    <div class="roles-box">
      <h3 class="h-small">Possible Job Roles</h3>
      <ul class="check-list cols-2">
        <?php foreach ($roles as $r): ?><li><?= icon('briefcase') ?><?= e($r) ?></li><?php endforeach; ?>
      </ul>
    </div>
    <ol class="card-grid cols-3 numbered-cards mt-lg">
      <?php foreach ($areas as $i => [$title, $intro, $items]): ?>
      <li class="card">
        <span class="card-num"><?= $i + 1 ?></span>
        <h3><?= $title ?></h3>
        <?php if ($intro !== ''): ?><p><?= e($intro) ?></p><?php endif; ?>
        <ul class="bullet-list">
          <?php foreach ($items as $item): ?><li><?= e($item) ?></li><?php endforeach; ?>
        </ul>
      </li>
      <?php endforeach; ?>
    </ol>
    <div class="gallery cols-3 mt-lg">
      <?php foreach ($gallery as [$image, $alt, $caption]): ?>
      <figure>
        <?= img($image, $alt, ['sizes' => '(min-width: 1024px) 380px, (min-width: 640px) 33vw, 100vw']) ?>
        <figcaption><?= e($caption) ?></figcaption>
      </figure>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php partial('course-why', [
    'course' => 'dmlt',
    'image' => 'courses/dmlt/why-choose-manila-institute.webp',
    'alt' => 'Medical laboratory technology student at Manila Institute',
    'items' => ['Located in Tirunelveli, with hospital-linked lab training', 'Modern lab infrastructure & certified faculty',
        'Internship opportunities in real diagnostic labs', 'Affordable fee structure with strong job placement',
        'One of the top DMLT course providers in Tamil Nadu'],
]); ?>
