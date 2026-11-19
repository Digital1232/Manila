<?php
// URL map: pages (with SEO metadata), permanent redirects from the old WordPress URLs,
// and removed URLs (spam posts, WordPress system paths) that answer "410 Gone".
defined('MIPS') || exit;

$pages = [
    '' => [
        'view' => 'home', 'nav' => 'home', 'label' => 'Home', 'forms' => ['admission'], 'priority' => '1.0',
        'title' => 'Manila Institute of Paramedical Science, Tirunelveli | A Unit of Nivya Hospitals',
        'description' => 'Paramedical diploma courses in Tirunelveli: Nursing & Midwifery, Medical Laboratory, Operation Theatre and Radiology & Imaging, with hospital-based training at Nivya Hospitals.',
        'image' => 'og/manila-institute-og.jpg',
    ],
    'about-us' => [
        'view' => 'about', 'nav' => 'about', 'label' => 'About Us', 'priority' => '0.8',
        'title' => 'About Us | Manila Institute of Paramedical Science, Tirunelveli',
        'description' => 'Manila Institute of Paramedical Science in Vannarapettai, Tirunelveli offers job-ready paramedical diplomas with hands-on hospital training. Read our vision and mission.',
        'image' => 'about/about-hero.webp',
    ],
    'courses' => [
        'view' => 'courses', 'nav' => 'courses', 'label' => 'Courses', 'priority' => '0.9',
        'title' => 'Paramedical Diploma Courses in Tirunelveli | Manila Institute',
        'description' => 'Two-year paramedical diplomas in Nursing & Midwifery (DNM), Medical Laboratory Technology (DMLT), Operation Theatre Technology (DOTT) and Radiology & Imaging (DRIT).',
        'image' => 'shared/page-hero-healthcare.webp',
    ],
    'admission' => [
        'view' => 'admission', 'nav' => 'admission', 'label' => 'Admission', 'forms' => ['admission'], 'priority' => '0.9',
        'title' => 'Admission & How to Apply | Manila Institute of Paramedical Science',
        'description' => 'How to apply to Manila Institute of Paramedical Science, Tirunelveli: eligibility, required documents, programmes offered and the online admission enquiry form.',
        'image' => 'admission/student-course-joining.webp',
    ],
    'contact-us' => [
        'view' => 'contact', 'nav' => 'contact', 'label' => 'Contact Us', 'forms' => ['contact'], 'priority' => '0.7',
        'title' => 'Contact Us | Manila Institute of Paramedical Science, Tirunelveli',
        'description' => 'Contact Manila Institute of Paramedical Science, 110/F/5 Barani Nagar, Vannarapettai, Tirunelveli. Call +91 85089 18887 or send us a message.',
        'image' => 'contact/contact-hero.webp',
    ],
    'privacy-policy' => [
        'view' => 'privacy', 'nav' => '', 'label' => 'Privacy Policy', 'priority' => '0.3',
        'title' => 'Privacy Policy | Manila Institute of Paramedical Science',
        'description' => 'How Manila Institute of Paramedical Science collects, uses and protects the personal information you share through this website.',
    ],
    'terms-conditions' => [
        'view' => 'terms', 'nav' => '', 'label' => 'Terms & Conditions', 'priority' => '0.3',
        'title' => 'Terms & Conditions | Manila Institute of Paramedical Science',
        'description' => 'Terms and conditions for using the Manila Institute of Paramedical Science website.',
    ],
];

foreach (courses() as $key => $course) {
    $pages['courses/' . $course['slug']] = [
        'view' => 'course', 'course' => $key, 'nav' => 'courses', 'parent' => 'courses',
        'label' => $course['full'], 'priority' => '0.9',
        'title' => $course['meta_title'] . ' | Manila Institute',
        'description' => $course['meta_description'],
        'image' => $course['image'],
    ];
}

$redirects = [
    'home' => '/',
    'index.php' => '/',
    'about' => '/about-us/',
    'contact' => '/contact-us/',
    'course' => '/courses/',
    'admissions' => '/admission/',
    'how-to-apply' => '/admission/',
    'apply-form' => '/admission/',
    'apply-now' => '/admission/',
    'request-info' => '/contact-us/',
    'schedule-a-tour' => '/contact-us/',
    'support-guidance' => '/terms-conditions/',
    'blog' => '/',
    'which-paramedical-diploma-is-right-for-you-dmlt-vs-dott-vs-drit-vs-dnm' => '/courses/',
    'what-is-paramedical-science-a-complete-guide-for-beginners-2' => '/about-us/',
    'diploma-in-nursing-midwifery-dnm' => course_url('dnm'),
    'diploma-in-medical-laboratory-technology-dmlt' => course_url('dmlt'),
    'diploma-in-operation-thetre-technology-dott' => course_url('dott'),
    'diploma-in-operation-theatre-technology-dott' => course_url('dott'),
    'diploma-in-radiology-and-imaging-technology-drit' => course_url('drit'),
];

// Old WordPress ?page_id= / ?p= links
$legacyIds = [
    11 => '/', 6281 => '/about-us/', 6417 => '/admission/', 6425 => '/contact-us/', 30 => '/', 6426 => '/terms-conditions/',
    16161 => '/privacy-policy/', 989059 => '/terms-conditions/', 6283 => course_url('dnm'), 988001 => course_url('dmlt'),
    988114 => course_url('dott'), 988170 => course_url('drit'), 1491 => '/courses/', 10927 => '/about-us/',
];

// Spam posts injected into the old site, removed for good
$goneSlugs = [
    'promokody-cat-casino-opyt-igrokov-i-otzyvy', 'kak-vyigrat-v-loterei-pinap-kazino-sovety-i-strategii',
    'issleduem-udobstvo-interfeisa-pin-up-dizain-i-funktsionalnost', '12-best-online-casinos-australia-for-real-cash-gaming-in-2025',
    'official-site-for-sports-betting-and-casino', 'die-grossen-gewinne-des-book-of-ra-slots-im-besten-online-casino-entdecken',
    'regisztracios-link-es-45-000-huf-bonusz', '2026da-sahip-olunacak-amerikadaki-en-iyi-10-gercek-parali-internet-online-casino-sitesi',
    '2026da-sahip-olunacak-amerikadaki-en-iyi-10-gercek-parali-internet-online-casino-sitesi-2',
    'mejores-applications-de-apuestas-deportivas-en-mexico-2026-guia-y-ranking', 'plinko-demo-gioca-gratis-senza-registrazione-e-divertiti',
    'site-officiel-1win-ni-togo-le-meilleur-casino-et-terme-conseille-en-ligne', 'navigating-the-glory-login-dashboard-effectively',
    'glucksrad-anpassbares-werkzeug-fur-zufallige-auswahl', 'peuromosyeon-kodeu', 'glucksrad-online-verlosungstool',
    'casino-en-ligne-autorise-en-france-autentico-et-legal',
];

// WordPress system paths that no longer exist
$gonePrefixes = ['wp-admin', 'wp-content', 'wp-includes', 'wp-json', 'wp-login.php', 'xmlrpc.php', 'wp-cron.php',
    'wp-signup.php', 'wp-trackback.php', 'feed', 'comments', 'author', 'category', 'tag', 'elementor-hf', 'e-landing-page'];

return compact('pages', 'redirects', 'legacyIds', 'goneSlugs', 'gonePrefixes');
