<?php
defined('MIPS') || exit;
/** @var array $page @var array $site @var string $content */
$canonical = abs_url($page['path']);
$ogImage = abs_url('/assets/img/' . ($page['image'] ?? 'og/manila-institute-og.jpg'));
$noindex = !empty($page['noindex']) || cfg('env') !== 'production';
$schema = page_schema($page);
?><!doctype html>
<html lang="en-IN">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<title><?= e($page['title']) ?></title>
<meta name="description" content="<?= e($page['description']) ?>">
<?php if ($noindex): ?>
<meta name="robots" content="noindex, nofollow">
<?php else: ?>
<meta name="robots" content="index, follow, max-image-preview:large">
<link rel="canonical" href="<?= e($canonical) ?>">
<?php endif; ?>
<meta name="theme-color" content="#36348e">
<link rel="preload" href="/assets/fonts/work-sans-latin.woff2" as="font" type="font/woff2" crossorigin>
<link rel="preload" href="/assets/fonts/inter-latin.woff2" as="font" type="font/woff2" crossorigin>
<link rel="stylesheet" href="<?= e(asset('css/site.css')) ?>">
<script src="<?= e(asset('js/site.js')) ?>" defer></script>
<link rel="icon" href="/favicon.ico" sizes="32x32">
<link rel="icon" href="/assets/img/brand/favicon-32.png" type="image/png" sizes="32x32">
<link rel="apple-touch-icon" href="/assets/img/brand/apple-touch-icon.png">
<link rel="manifest" href="/site.webmanifest">
<meta property="og:type" content="website">
<meta property="og:site_name" content="<?= e($site['name']) ?>">
<meta property="og:locale" content="en_IN">
<meta property="og:title" content="<?= e($page['title']) ?>">
<meta property="og:description" content="<?= e($page['description']) ?>">
<meta property="og:url" content="<?= e($canonical) ?>">
<meta property="og:image" content="<?= e($ogImage) ?>">
<meta name="twitter:card" content="summary_large_image">
<?php if ($schema): ?>
<script type="application/ld+json"><?= json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP) ?></script>
<?php endif; ?>
</head>
<body class="page-<?= e($page['view']) ?>">
<a class="skip-link" href="#main">Skip to main content</a>
<?php partial('icons'); ?>
<?php partial('header', ['page' => $page]); ?>
<main id="main" tabindex="-1">
<?= $content ?>
</main>
<?php partial('footer'); ?>
<?php partial('mobile-actions', ['page' => $page]); ?>
</body>
</html>
