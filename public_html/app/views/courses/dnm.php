<?php
defined('MIPS') || exit;
// Diploma in Nursing & Midwifery: copy from the original course page (spelling corrected).
$applyUrl = '/admission/?course=dnm#admission-form';
$roles = ['Personal care', 'Vital signs monitoring', 'Mobility assistance', 'Observation and reporting', 'Assisting with procedures',
    'Patient advocacy', 'Maintaining cleanliness', 'Communication', 'Record keeping', 'Infection control', 'Team collaboration',
    'Education and comfort', 'Emergency response'];
$trained = [
    ['heart-pulse', 'Patient Care', ['Monitoring vital signs (temperature, pulse, respiration, blood pressure)', 'Assisting with activities of daily living (feeding, bathing, mobility)', 'Administering medications as per doctor’s prescription', 'Caring for patients with chronic, acute, or terminal conditions']],
    ['stethoscope', 'Clinical Procedures', ['Wound dressing, catheterization, and IV line management', 'Assisting in minor procedures and surgeries', 'Basic emergency care (first aid, CPR)']],
    ['activity', 'Health Assessment', ['Conducting routine patient assessments', 'Recording and reporting patient progress', 'Recognizing early signs of complications and notifying medical staff']],
];
$settings = [
    ['courses/dnm/nursing-patient-monitoring.webp', 'Nurse monitoring a patient on a hospital ward', 'Hospital / Clinical Care', ['Monitoring vital signs and patient condition', 'Administering medications as prescribed', 'Wound care, catheterization, IV management', 'Assisting in minor procedures and surgeries', 'Basic emergency care (first aid, CPR)', 'Maintaining patient records and reporting to doctors']],
    ['courses/dnm/nursing-team-meeting.webp', 'Nursing team discussing patient care', 'Community Health / Primary Care', ['Participating in public health campaigns', 'Monitoring community health indicators and reporting outbreaks', 'Maintaining patient and clinic records']],
    ['courses/dnm/nursing-records-desk.webp', 'Nurse updating patient records at the nursing station', 'Administrative / Support', ['Supervising junior nursing staff or assistants', 'Organizing health programs and workshops', 'Assisting in quality assurance and infection control protocols']],
];
?>
<section class="section">
  <div class="container feature-grid">
    <figure class="feature-media feature-media-tall">
      <?= img('courses/dnm/career-opportunities-nursing-midwifery.webp', 'Nursing student caring for a patient during hospital training', ['sizes' => '(min-width: 1024px) 460px, 100vw']) ?>
    </figure>
    <div class="feature-copy">
      <p class="eyebrow">Academics</p>
      <h2>About the DNM programme</h2>
      <p class="text-lg">Comprehensive nursing program designed to train students in patient care, maternal health, and midwifery practices. This course equips students with the essential knowledge and hands-on skills needed to provide safe and effective nursing support in hospitals, clinics, maternity homes, and community health centres.</p>
      <h3 class="h-small">Training in our inpatient ward</h3>
      <p>An inpatient ward in our hospital provides specialized care for patients with respiratory conditions who require hospitalization. These wards are staffed with pulmonologists, physicians, duty RMOs, nurses, and other healthcare professionals, offering 24/7 care, monitoring, and treatment for various lung and respiratory ailments.</p>
      <p>They are equipped with oxygen delivery systems and other specialized medical equipment for respiratory and medical support. ICU-range facilities are available in a normal ward setup, with round-the-clock monitoring and management of patients’ cardio-respiratory status.</p>
      <p>The focus is on managing conditions like pneumonia, asthma, COPD, complex chest infections, and other medical emergencies. Dedicated units are available for patients requiring intensive care and life support, including heart monitors to manage critical cases. Infumax syringe infusion pumps, mobile X-ray machines, and CMS8000 patient monitors are also utilized.</p>
    </div>
  </div>
</section>

<section class="section section-tint">
  <div class="container">
    <div class="feature-grid feature-grid-top reverse">
      <figure class="feature-media">
        <?= img('courses/dnm/patient-transfer-corridor.webp', 'Nursing staff transferring a patient along a hospital corridor', ['sizes' => '(min-width: 1024px) 520px, 100vw']) ?>
      </figure>
      <div class="feature-copy">
        <p class="eyebrow">Scope</p>
        <h2>Scope in Diploma in Nursing &amp; Midwifery (DNM) Course</h2>
        <p>Nurse Aide, also known as Nursing Assistant (NA), plays a crucial role in a hospital setting. Their responsibilities involve providing direct patient care under the supervision of Registered Nurses (RNs). Nursing assistants provide basic care and help patients with activities of daily living. Orderlies transport patients and clean treatment areas. Here are some of the key roles and responsibilities of a Nurse Aide in a hospital:</p>
      </div>
    </div>
    <ul class="check-list cols-3 roles-list">
      <?php foreach ($roles as $role): ?><li><?= icon('check') ?><?= e($role) ?></li><?php endforeach; ?>
    </ul>
    <p class="section-foot"><a class="btn btn-primary" href="<?= e($applyUrl) ?>">Join Course <?= icon('arrow-right') ?></a></p>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="section-head center">
      <p class="eyebrow">What you will learn</p>
      <h2>A diploma nurse is trained to provide basic and intermediate nursing care in various healthcare settings</h2>
    </div>
    <div class="trained-grid">
      <figure class="trained-media">
        <?= img('courses/dnm/nursing-care-nivya-hospital.webp', 'Nursing student assisting a patient at Nivya Hospitals', ['sizes' => '(min-width: 1024px) 380px, 100vw']) ?>
      </figure>
      <?php foreach ($trained as [$ic, $title, $items]): ?>
      <article class="card">
        <span class="card-icon"><?= icon($ic) ?></span>
        <h3><?= e($title) ?></h3>
        <ul class="bullet-list">
          <?php foreach ($items as $item): ?><li><?= e($item) ?></li><?php endforeach; ?>
        </ul>
      </article>
      <?php endforeach; ?>
    </div>
    <div class="card-grid cols-3 mt-lg">
      <article class="card card-plain">
        <h3>Community Health Nursing</h3>
        <p>Diploma nurses often work in community and primary health care:</p>
        <ul class="bullet-list">
          <li>Conducting health awareness campaigns (vaccination drives, hygiene, nutrition)</li>
          <li>Monitoring public health indicators (maternal and child health, communicable diseases)</li>
          <li>Participating in home visits for health promotion and disease prevention</li>
        </ul>
      </article>
      <article class="card card-plain">
        <h3>Administrative &amp; Support Roles</h3>
        <p>Depending on the institution, diploma nurses may also:</p>
        <ul class="bullet-list">
          <li>Maintain patient records and reports</li>
          <li>Supervise junior nursing staff or assistants</li>
          <li>Assist in organizing health programs or clinics</li>
        </ul>
      </article>
      <article class="card card-plain card-note">
        <h3>Limitations</h3>
        <p>While diploma nurses are highly skilled, they usually:</p>
        <ul class="bullet-list">
          <li>Cannot prescribe medications independently</li>
          <li>Cannot perform major surgical procedures</li>
          <li>Must work under the supervision of registered nurses or doctors for complex medical decisions</li>
        </ul>
      </article>
    </div>
    <p class="statement">A Diploma in Nursing and Midwifery prepares graduates to provide comprehensive nursing and midwifery care, both in hospitals and community settings, while supporting physicians and senior nurses in patient management, health promotion, and preventive care.</p>
  </div>
</section>

<section class="section section-tint">
  <div class="container">
    <div class="section-head center">
      <p class="eyebrow">Where you will work</p>
      <h2>Setting / Scope of Services</h2>
    </div>
    <div class="card-grid cols-3">
      <?php foreach ($settings as [$image, $alt, $title, $items]): ?>
      <article class="card card-media">
        <?= img($image, $alt, ['sizes' => '(min-width: 1024px) 380px, (min-width: 640px) 50vw, 100vw']) ?>
        <div class="card-body">
          <h3><?= e($title) ?></h3>
          <ul class="bullet-list">
            <?php foreach ($items as $item): ?><li><?= e($item) ?></li><?php endforeach; ?>
          </ul>
        </div>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php $whyTint = false; // the section above is tinted
partial('course-why', [
    'course' => 'dnm',
    'tint' => $whyTint,
    'image' => 'courses/dnm/why-choose-manila-institute.webp',
    'alt' => 'Nursing students at Manila Institute of Paramedical Science',
    'items' => ['Affordable fee structure with expert faculty', 'Strong placement support in government and private hospitals',
        'Modern lab facilities and real-time patient care exposure', 'Recognized paramedical diploma under professional healthcare standards'],
]); ?>
