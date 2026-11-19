<?php
// Builds optimised site assets (WebP images, favicons, OG image, self-hosted fonts) from the files
// extracted out of the July 2026 backup. Run with: php -d extension=gd dev/build-assets.php
if (!extension_loaded('gd')) { fwrite(STDERR, "GD extension required (php -d extension=gd)\n"); exit(1); }

$src = __DIR__ . '/extracted/wp-content/uploads';
$out = dirname(__DIR__) . '/public_html/assets';

// [source, destination (relative to assets/img), max width, extra smaller widths for srcset]
$jobs = [
    // Brand
    ['2025/09/Manila-Institute-LOgo-copy-2.webp', 'brand/manila-institute-logo.webp', 380, []],
    ['2020/11/Manila-Institute-Logo-White.png', 'brand/manila-institute-logo-white.webp', 380, []],
    // Home
    ['2025/09/Manila-Slider.webp', 'home/hero-students-laboratory.webp', 1600, [800]],
    ['2025/07/Dr-Mani.png', 'team/dr-p-manimozhian.webp', 258, []],
    ['2025/07/Dr-Mathan.png', 'team/dr-m-a-mathan.webp', 258, []],
    ['2025/07/Dr.Nivya_.png', 'team/dr-m-nivya.webp', 258, []],
    ['2025/07/Nursing-students-practicing-maternal-and-patient-care-procedures-in-hospital-training.jpg', 'courses/dnm-nursing-students-clinical-training.webp', 803, [480]],
    ['2025/07/DMLT-Course-Student-Performing-Blood-Test-in-Medical-Lab.jpg', 'courses/dmlt-student-blood-test-medical-lab.webp', 803, [480]],
    ['2025/07/DOTT-Course-Operation-Theatre-Student-Assisting-in-Surgical-Setup.jpg', 'courses/dott-student-surgical-setup.webp', 803, [480]],
    ['2025/07/DRIT-Course-Radiology-Student-Operating-X-ray-Machine.jpg', 'courses/drit-student-x-ray-machine.webp', 803, [480]],
    ['2025/06/Slide-3.jpg', 'home/nivya-hospital-legacy.webp', 1200, [700]],
    ['2025/09/Dr-Nivya-1.jpg', 'home/dr-nivya-m.webp', 550, []],
    ['2025/06/Hospital-Manila-copy-1.jpg', 'home/nivya-hospital-tirunelveli.webp', 803, [480]],
    ['2021/01/Hospital-Based-Training-for-Paramedical-Students.jpg', 'home/hospital-based-training.webp', 600, []],
    ['2025/07/form-copy.png', 'home/apply-now-student.webp', 380, []],
    // About
    ['2025/06/brydon-mccluskey-GvPceVqbxm4-unsplash.jpg', 'about/about-hero.webp', 1600, [800]],
    ['2025/06/About-Manila-Tirunelveli-Institute.jpg', 'about/manila-institute-tirunelveli.webp', 650, []],
    ['2025/07/Mission-Manila-Paramedical-College-Nellai.webp', 'about/mission-manila-paramedical-college.webp', 650, []],
    // Shared course / admission hero banner
    ['2025/06/CareerOpportunitiesDiplomainNursingMidwiferyManila.jpg', 'shared/page-hero-healthcare.webp', 1600, [800]],
    // DNM
    ['2025/06/CareerOpportunitiesDiplomainNursingMidwifery.jpg', 'courses/dnm/career-opportunities-nursing-midwifery.webp', 803, [480]],
    ['2025/12/CareerOpportunitiesDiplomainNursingMidwiferynivya.webp', 'courses/dnm/nursing-care-nivya-hospital.webp', 803, [480]],
    ['2026/01/nursing-1.png', 'courses/dnm/setting-hospital-clinical-care.webp', 992, [500]],
    ['2025/12/nursing-2.jpg', 'courses/dnm/setting-clinical-procedures.webp', 900, [500]],
    ['2025/12/nursing-3.jpg', 'courses/dnm/setting-community-health.webp', 1000, [500]],
    ['2025/12/nursing-4.jpg', 'courses/dnm/setting-administrative-support.webp', 1000, [500]],
    ['2025/10/Why-Choose-Manila-Institute-Course-DNM.webp', 'courses/dnm/why-choose-manila-institute.webp', 804, [480]],
    // DMLT
    ['2026/01/CareerOpportunitiesDiplomainNursing.webp', 'courses/dmlt/respiratory-lab-diagnostics.webp', 803, [480]],
    ['2026/01/1CareerOpportunitiesDiplomainNursing.webp', 'courses/dmlt/why-choose-manila-institute.webp', 522, []],
    ['2026/01/Diagnostic-Laboratory-Services.webp', 'courses/dmlt/diagnostic-laboratory-services.webp', 550, []],
    ['2026/01/Laboratory-Maintenance-Quality-Control.webp', 'courses/dmlt/laboratory-maintenance-quality-control.webp', 550, []],
    ['2026/01/Specialized-Areas-OptionalAdvanced-Training.webp', 'courses/dmlt/specialized-areas-advanced-training.webp', 550, []],
    // DOTT
    ['2025/10/Wound-Care-Trays.webp', 'courses/dott/wound-care-tray.webp', 700, []],
    ['2025/10/Emergency-Trays.webp', 'courses/dott/emergency-tray.webp', 700, []],
    ['2025/10/Suture-Removal-Trays.webp', 'courses/dott/suture-removal-tray.webp', 700, []],
    ['2025/10/A-pleural-tapping-thoracentesis-tray.webp', 'courses/dott/pleural-tapping-thoracocentesis-tray.webp', 700, []],
    ['2025/10/ICD-stands-for-Intercostal-Drainage.webp', 'courses/dott/intercostal-drainage-icd-tray.webp', 700, []],
    ['2025/07/ScopeinPperationTheatreTechnician.webp', 'courses/dott/scope-operation-theatre-technician.webp', 803, [480]],
    ['2025/10/Why-Choose-Manila-Institute-Course-DO.webp', 'courses/dott/why-choose-manila-institute.webp', 804, [480]],
    // DRIT
    ['2025/06/Why-Choose-Manila-Institute-Course-copy.jpg', 'courses/drit/ultrasonography-training.webp', 804, [480]],
    ['2025/12/radiology-monitors.webp', 'courses/drit/radiology-monitors.webp', 800, []],
    ['2026/01/Why-Choose-Manila-Institute-Course-DOT.webp', 'courses/drit/why-choose-manila-institute.webp', 804, [480]],
    // Admission & contact
    ['2025/06/Manila-institute-course-joining-copy.jpg', 'admission/student-course-joining.webp', 800, [480]],
    ['2025/06/Manila-Institute-slider-Nursing-course-admission.jpg', 'admission/application-for-admission-form-preview.webp', 900, [480]],
    ['2025/07/Manila-Slider-10-copy.jpg', 'contact/contact-hero.webp', 1600, [800]],
];

function load($path) {
    $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
    $im = match ($ext) {
        'jpg', 'jpeg' => imagecreatefromjpeg($path),
        'png' => imagecreatefrompng($path),
        'webp' => imagecreatefromwebp($path),
        default => false,
    };
    if (!$im) throw new RuntimeException("cannot load $path");
    if (!imageistruecolor($im)) imagepalettetotruecolor($im);
    imagealphablending($im, false);
    imagesavealpha($im, true);
    return $im;
}

function resized($im, $w) {
    $ow = imagesx($im); $oh = imagesy($im);
    if ($ow <= $w) return $im;
    $h = (int)round($oh * $w / $ow);
    $dst = imagecreatetruecolor($w, $h);
    imagealphablending($dst, false);
    imagesavealpha($dst, true);
    imagefill($dst, 0, 0, imagecolorallocatealpha($dst, 0, 0, 0, 127));
    imagecopyresampled($dst, $im, 0, 0, 0, 0, $w, $h, $ow, $oh);
    return $dst;
}

function save($im, $dest, $q = 80) {
    if (!is_dir(dirname($dest))) mkdir(dirname($dest), 0777, true);
    imagewebp($im, $dest, $q);
    return sprintf("%dx%d %dKB", imagesx($im), imagesy($im), filesize($dest) / 1024);
}

$manifest = [];
foreach ($jobs as [$from, $to, $maxW, $extra]) {
    $im = load("$src/$from");
    $main = resized($im, $maxW);
    $dest = "$out/img/$to";
    echo str_pad($to, 70) . save($main, $dest) . "\n";
    $manifest[$to] = ['w' => imagesx($main), 'h' => imagesy($main), 'srcset' => []];
    foreach ($extra as $w) {
        $small = resized($im, $w);
        $sd = preg_replace('/\.webp$/', "-{$w}w.webp", $dest);
        echo str_pad('  ' . basename($sd), 70) . save($small, $sd) . "\n";
        $manifest[$to]['srcset'][$w] = preg_replace('/\.webp$/', "-{$w}w.webp", $to);
    }
}

// PNG logo (for structured data / email) and the original scanned application form for printing
$logo = load("$src/2025/09/Manila-Institute-LOgo-copy-2.webp");
imagepng($logo, "$out/img/brand/manila-institute-logo.png", 9);
copy("$src/2025/06/Manila-Institute-slider-Nursing-course-admission.jpg", "$out/img/admission/application-for-admission-form.jpg");

// Favicons from the MIPS emblem
$fav = load("$src/2025/06/cropped-Fav-Icon.jpg");
foreach ([32 => 'favicon-32.png', 180 => 'apple-touch-icon.png', 192 => 'icon-192.png', 512 => 'icon-512.png'] as $size => $name) {
    $d = imagecreatetruecolor($size, $size);
    imagecopyresampled($d, $fav, 0, 0, 0, 0, $size, $size, imagesx($fav), imagesy($fav));
    imagepng($d, "$out/img/brand/$name", 9);
}
// favicon.ico containing 16px and 32px PNG images
$ico = pack('vvv', 0, 1, 2); $offset = 6 + 16 * 2; $images = '';
foreach ([16, 32] as $size) {
    $d = imagecreatetruecolor($size, $size);
    imagecopyresampled($d, $fav, 0, 0, 0, 0, $size, $size, imagesx($fav), imagesy($fav));
    ob_start(); imagepng($d, null, 9); $png = ob_get_clean();
    $ico .= pack('CCCCvvVV', $size, $size, 0, 0, 1, 32, strlen($png), $offset);
    $offset += strlen($png); $images .= $png;
}
file_put_contents(dirname($out) . '/favicon.ico', $ico . $images);

// Open Graph image 1200x630, centre-cropped from the hero photo
$hero = load("$src/2025/09/Manila-Slider.webp");
$og = imagecreatetruecolor(1200, 630);
$sw = imagesx($hero); $sh = imagesy($hero); $ratio = 1200 / 630;
$cw = min($sw, (int)($sh * $ratio)); $ch = (int)($cw / $ratio);
imagecopyresampled($og, $hero, 0, 0, (int)(($sw - $cw) / 2), (int)(($sh - $ch) / 2), 1200, 630, $cw, $ch);
if (!is_dir("$out/img/og")) mkdir("$out/img/og", 0777, true);
imagejpeg($og, "$out/img/og/manila-institute-og.jpg", 82);

// Self-hosted fonts: latin, normal style variable files for Inter and Work Sans
if (!is_dir("$out/fonts")) mkdir("$out/fonts", 0777, true);
foreach (['inter' => 'inter-latin.woff2', 'worksans' => 'work-sans-latin.woff2'] as $family => $name) {
    $css = file_get_contents("$src/elementor/google-fonts/css/$family.css");
    preg_match_all('#/\* latin \*/\s*@font-face\s*\{(.*?)\}#s', $css, $m);
    foreach ($m[1] as $block) {
        if (str_contains($block, 'font-style: normal') && preg_match('#fonts/([a-z0-9_\-]+\.woff2)#', $block, $f)) {
            copy("$src/elementor/google-fonts/fonts/{$f[1]}", "$out/fonts/$name");
            echo "font $family -> $name ({$f[1]}, " . round(filesize("$out/fonts/$name") / 1024) . "KB)\n";
            break;
        }
    }
}
file_put_contents(__DIR__ . '/image-manifest.json', json_encode($manifest, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
echo "done\n";
