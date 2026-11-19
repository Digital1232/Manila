<?php
defined('MIPS') || exit;
// "Our Specialist Doctors" (second slide of the original home page slider)
$doctors = [
    ['name' => 'Dr. P. Manimozhian', 'image' => 'team/dr-p-manimozhian.webp', 'quals' => 'MD (Chest Medicine), DTCD, Dip in Allergy (UK), FCCP (USA)', 'role' => 'Interventional Pulmonologist'],
    ['name' => 'Dr. M.A. Mathan', 'image' => 'team/dr-m-a-mathan.webp', 'quals' => 'MBBS, MEM (Emergency & Critical Care Medicine)', 'role' => ''],
    ['name' => 'Dr. M. Nivya', 'image' => 'team/dr-m-nivya.webp', 'quals' => 'MD (General Medicine), FCD (Diabetology), FCC (Clinical Cardiology)', 'role' => ''],
];
?>
<section class="section" id="doctors">
  <div class="container">
    <div class="section-head center">
      <p class="eyebrow">Nivya Hospitals</p>
      <h2>Our Specialist Doctors</h2>
      <p class="section-lead">Experienced, compassionate, and dedicated professionals guiding students and delivering quality healthcare through Nivya Hospitals.</p>
    </div>
    <ul class="doctor-grid">
      <?php foreach ($doctors as $d): ?>
      <li class="doctor-card">
        <?= img($d['image'], 'Portrait of ' . $d['name']) ?>
        <h3><?= e($d['name']) ?></h3>
        <p class="doctor-quals"><?= e($d['quals']) ?></p>
        <?php if ($d['role'] !== ''): ?><p class="doctor-role"><?= e($d['role']) ?></p><?php endif; ?>
      </li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>
