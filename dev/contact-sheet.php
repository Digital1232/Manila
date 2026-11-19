<?php
// Makes labelled thumbnail grids of the optimised images so they can be reviewed at a glance.
$base = dirname(__DIR__) . '/public_html/assets/img/';
$sets = [
  'sheet-1' => ['home/nivya-hospital-legacy.webp','home/dr-nivya-m.webp','home/nivya-hospital-tirunelveli.webp','home/hospital-based-training.webp','home/apply-now-student.webp','about/about-hero.webp','about/manila-institute-tirunelveli.webp','about/mission-manila-paramedical-college.webp','courses/dmlt-student-blood-test-medical-lab.webp','courses/dott-student-surgical-setup.webp','courses/drit-student-x-ray-machine.webp','contact/contact-hero.webp','team/dr-p-manimozhian.webp','team/dr-m-a-mathan.webp','team/dr-m-nivya.webp','brand/manila-institute-logo-white.webp'],
  'sheet-2' => ['courses/dnm/career-opportunities-nursing-midwifery.webp','courses/dnm/nursing-care-nivya-hospital.webp','courses/dnm/setting-hospital-clinical-care.webp','courses/dnm/setting-clinical-procedures.webp','courses/dnm/setting-community-health.webp','courses/dnm/setting-administrative-support.webp','courses/dnm/why-choose-manila-institute.webp','courses/dmlt/respiratory-lab-diagnostics.webp','courses/dmlt/why-choose-manila-institute.webp','courses/dmlt/diagnostic-laboratory-services.webp','courses/dmlt/laboratory-maintenance-quality-control.webp','courses/dmlt/specialized-areas-advanced-training.webp','courses/dott/scope-operation-theatre-technician.webp','courses/dott/why-choose-manila-institute.webp','courses/drit/ultrasonography-training.webp','courses/drit/why-choose-manila-institute.webp'],
  'sheet-3' => ['courses/dott/wound-care-tray.webp','courses/dott/emergency-tray.webp','courses/dott/suture-removal-tray.webp','courses/dott/pleural-tapping-thoracocentesis-tray.webp','courses/dott/intercostal-drainage-icd-tray.webp','courses/drit/radiology-monitors.webp','admission/student-course-joining.webp','shared/page-hero-healthcare.webp'],
];
foreach ($sets as $name => $files) {
  $cols = 4; $cw = 300; $chh = 240; $rows = (int)ceil(count($files) / $cols);
  $sheet = imagecreatetruecolor($cols * $cw, $rows * ($chh + 18));
  imagefill($sheet, 0, 0, imagecolorallocate($sheet, 120, 120, 120));
  $white = imagecolorallocate($sheet, 255, 255, 255);
  foreach ($files as $i => $f) {
    $im = imagecreatefromwebp($base . $f);
    $w = imagesx($im); $h = imagesy($im); $s = min(($cw - 6) / $w, $chh / $h);
    $x = ($i % $cols) * $cw + (int)(($cw - $w * $s) / 2); $y = intdiv($i, $cols) * ($chh + 18);
    imagecopyresampled($sheet, $im, $x, $y, 0, 0, (int)($w * $s), (int)($h * $s), $w, $h);
    imagestring($sheet, 2, ($i % $cols) * $cw + 4, $y + $chh + 2, ($i + 1) . ' ' . basename(dirname($f)) . '/' . substr(basename($f, '.webp'), 0, 34), $white);
  }
  imagejpeg($sheet, __DIR__ . "/$name.jpg", 80);
}
echo "ok\n";
