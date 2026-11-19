<?php
defined('MIPS') || exit;
// Diploma in Operation Theatre Technology: copy from the original course page (spelling corrected).
$applyUrl = '/admission/?course=dott#admission-form';
$trays = [
    ['courses/dott/wound-care-tray.webp', 'Wound Care Trays', 'Designed for the management of minor wounds and injuries, wound care trays typically contain sterile gauze, adhesive bandages, antiseptic wipes, and other supplies needed for cleaning and dressing wounds.', []],
    ['courses/dott/emergency-tray.webp', 'Emergency Trays', 'Emergency trays are equipped with essential medical supplies and equipment needed for emergency medical interventions, such as cardiopulmonary resuscitation (CPR) or airway management. They often include items like oxygen masks, airway adjuncts, syringes, and medications.', []],
    ['courses/dott/suture-removal-tray.webp', 'Suture Removal Trays', 'These trays are used for the aseptic removal of sutures or stitches following a surgical procedure or wound closure. They typically include sterile scissors, forceps, gauze, and antiseptic solution for cleaning the wound site.', []],
    ['courses/dott/pleural-tapping-thoracocentesis-tray.webp', 'Pleural Tapping (Thoracocentesis) Tray', 'A pleural tapping (thoracocentesis) tray contains instruments for drawing fluid from the chest, including an antiseptic solution, sterile gloves, drapes, syringes with needles for local anesthetic, a thoracentesis needle or catheter, a three-way stopcock, a large syringe for fluid withdrawal, and collection containers.', []],
    ['courses/dott/intercostal-drainage-icd-tray.webp', 'ICD (Intercostal Drainage) Tray', 'ICD stands for Intercostal Drainage, which refers to the insertion of a flexible tube through the chest wall into the pleural space to drain fluid, blood, or air. This procedure is also known as a chest tube insertion or thoracostomy. The tray typically includes:',
        ['Kidney tray – 1', 'Curved artery forceps – 2', 'Straight artery forceps – 2', 'BP handle, size 3 or 4 – 1', 'Curved scissors – 1', 'Straight scissors – 1', 'Sponge holder – 1', 'Allis forceps – 2', 'Needle holder – 1', 'Toothed forceps – 1', 'Non-toothed forceps – 1', 'Bowl – 1', 'ICD tube – 1', 'ICD bag – 1', '100 ml NS – 1', 'Spirit', 'Suture', 'Gauze – 1 or 2 packs']],
];
$careers = ['Operation Theatre Technician (OT Technician)', 'Surgical Assistant', 'Anaesthesia Assistant', 'OT Coordinator in multispecialty hospitals', 'Emergency Care Technician'];
?>
<section class="section">
  <div class="container">
    <div class="two-col">
      <div>
        <p class="eyebrow">Academics</p>
        <h2>About the DOTT programme</h2>
        <p class="text-lg">The <strong>Diploma in Operation Theatre Technology (DOTT)</strong> at <strong>Manila Institute of Paramedical Science</strong> is a hands-on paramedical program that trains students in managing and supporting <strong>surgical procedures</strong> within an operation theatre. The course prepares students to work alongside surgeons, anesthetists, and nurses, ensuring a sterile, safe, and well-equipped surgical environment.</p>
      </div>
      <div>
        <h3 class="h-small">Inside the operating theatre</h3>
        <p>An operating theatre (or operating room) is a specialized hospital space designed for performing surgical procedures in a safe, sterile, and controlled environment. It is equipped with advanced medical instruments, surgical lighting, and specialized ventilation systems to ensure patient and staff safety.</p>
        <p>During surgery, the entire area is kept strictly sterile. All medical staff wear sterile gowns, gloves, and masks, and the patient is prepared using antiseptic solutions and sterile drapes. Surgical tools are autoclaved, sterilized, and arranged in categorized trays such as:</p>
      </div>
    </div>
    <div class="tray-grid mt-lg">
      <?php foreach ($trays as [$image, $title, $text, $items]): ?>
      <article class="card card-media<?= $items ? ' tray-wide' : '' ?>">
        <?= img($image, $title . ' laid out for use', ['sizes' => '(min-width: 1024px) 380px, (min-width: 640px) 50vw, 100vw']) ?>
        <div class="card-body">
          <h3><?= e($title) ?></h3>
          <p><?= e($text) ?></p>
          <?php if ($items): ?>
          <ul class="bullet-list cols-2"><?php foreach ($items as $item): ?><li><?= e($item) ?></li><?php endforeach; ?></ul>
          <?php endif; ?>
        </div>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section section-tint">
  <div class="container feature-grid">
    <figure class="feature-media feature-media-tall">
      <?= img('courses/dott/scope-operation-theatre-technician.webp', 'Scope in Operation Theatre Technician', ['sizes' => '(min-width: 1024px) 460px, 100vw']) ?>
    </figure>
    <div class="feature-copy">
      <p class="eyebrow">Equipment</p>
      <h2>Key equipment used</h2>
      <ul class="check-list">
        <li><?= icon('check') ?>Real-time monitoring systems (waveform display, vital tracking, trend analysis)</li>
        <li><?= icon('check') ?>Venky suction apparatus</li>
        <li><?= icon('check') ?>Electric C-arm operating table &amp; C-arm machine for imaging support</li>
      </ul>
      <h2 class="mt-lg">Career Opportunities After DOTT</h2>
      <p>After completing the <strong>DOTT course</strong>, students can pursue roles such as:</p>
      <ul class="check-list cols-2">
        <?php foreach ($careers as $c): ?><li><?= icon('briefcase') ?><?= e($c) ?></li><?php endforeach; ?>
      </ul>
      <p class="section-foot"><a class="btn btn-primary" href="<?= e($applyUrl) ?>">Join Course <?= icon('arrow-right') ?></a></p>
    </div>
  </div>
</section>

<?php $whyTint = false; // the section above is tinted
partial('course-why', [
    'course' => 'dott',
    'tint' => $whyTint,
    'image' => 'courses/dott/why-choose-manila-institute.webp',
    'alt' => 'Operation theatre technology students at Manila Institute',
    'items' => ['Practical OT training in live hospital environments', 'Certified faculty with surgical support experience',
        'Clean, modern labs and instrument simulation', 'Affordable course fees and placement assistance', 'Leading paramedical college in Tirunelveli'],
]); ?>
