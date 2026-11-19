<?php
// Dumps the content of the site's real pages from the July 2026 backup DB (imported locally as manila_local)
// into readable outlines, plus brand kit, SEO meta, forms and blog post list. Read-only.
$db = new mysqli('127.0.0.1', 'root', '', 'manila_local');
$db->set_charset('utf8mb4');
$out = $argv[1];

function q($db, $sql) {
    $r = $db->query($sql);
    if (!$r) { fwrite(STDERR, $db->error . "\n"); return []; }
    return $r === true ? [] : $r->fetch_all(MYSQLI_ASSOC);
}

$skipKey = '/^(_(?!background_image)|typography|.*_typography|.*colou?r|.*_size|.*width|.*height|.*margin|.*padding|.*border|.*radius|.*align|.*animation|.*hover|.*shadow|.*position|.*transform|.*motion|.*sticky|.*z_index|.*flex|.*gap|layout|content_width|structure|.*display|.*offset|.*transition|.*mask|.*overflow|.*inline|.*font|.*spacing|.*css|.*view$|.*shape|.*_style$|.*weight|.*decoration|.*line_height|.*letter|.*opacity|.*blend|.*duration|.*delay|.*entrance|html_tag|header_size|.*_unit|.*object_fit|.*ratio|.*_breakpoint|.*_tablet|.*_mobile|.*_widescreen|.*_laptop|.*hide_|.*_overlay|.*_skin|.*_direction|.*_wrap|.*_justify|.*_grow|.*_shrink|.*_order|.*columns|.*_bottom|.*_top|.*_left|.*_right|.*_slideshow|.*_attachment|.*_repeat|.*_xpos|.*_ypos|.*_gradient|.*_angle|.*_stop|.*_location|.*_divider|.*_zoom|.*icon_indent)/i';

$skipVal = ['yes', 'no', 'default', 'custom', 'none', 'inherit', 'solid', 'center', 'left', 'right', 'full', 'auto', 'initial', 'classic',
    'library', 'svg', 'fa-solid', 'fa-brands', 'fa-regular', 'eicons', 'upload', 'traditional', 'slide', 'grow', 'boxed', 'full_width', 'row',
    'column', 'flex', 'self', 'top', 'bottom', 'block', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'div', 'span', 'p', 'small', 'medium', 'large',
    'xl', 'xxl', 'framed', 'stacked', 'circle', 'square', 'rounded', 'cover', 'contain', 'true', 'false', 'on', 'off'];

function collect($arr, $prefix, &$vals, $skipKey, $skipVal) {
    foreach ($arr as $k => $v) {
        $key = $prefix === '' ? (string)$k : $prefix . '.' . $k;
        if (!is_int($k) && preg_match($skipKey, $k) && !in_array($k, ['url', 'alt', 'id', 'value'], true)) continue;
        if (is_array($v)) { collect($v, $key, $vals, $skipKey, $skipVal); continue; }
        if (!is_string($v)) continue;
        $s = trim(preg_replace('/\s+/', ' ', $v));
        if ($s === '' || in_array(strtolower($s), $skipVal, true)) continue;
        if (preg_match('/^[\d.\-]+(px|em|rem|%|vh|vw|s|ms|deg)?$/', $s)) continue;
        if (preg_match('/^#[0-9a-f]{3,8}$/i', $s) || preg_match('/^rgba?\(/', $s)) continue;
        $vals[$key] = $s;
    }
}

function walk($els, $depth, &$lines, $skipKey, $skipVal, &$templates) {
    foreach ($els as $el) {
        $type = ($el['elType'] ?? '') === 'widget' ? ($el['widgetType'] ?? '?') : ($el['elType'] ?? '?');
        $vals = [];
        collect($el['settings'] ?? [], '', $vals, $skipKey, $skipVal);
        if (isset($el['templateID'])) { $vals['templateID'] = $el['templateID']; $templates[] = (int)$el['templateID']; }
        if (isset($el['settings']['template_id'])) $templates[] = (int)$el['settings']['template_id'];
        $ind = str_repeat('  ', $depth);
        $isBox = in_array($type, ['section', 'column', 'container'], true);
        if (!$isBox || $vals) {
            $lines[] = $ind . '- [' . $type . ']';
            foreach ($vals as $k => $v) $lines[] = $ind . '    ' . $k . ': ' . $v;
        }
        if (!empty($el['elements'])) walk($el['elements'], $type === 'column' ? $depth : $depth + 1, $lines, $skipKey, $skipVal, $templates);
    }
}

function dumpPost($db, $id, $dir, $skipKey, $skipVal, &$seen) {
    if (isset($seen[$id])) return;
    $seen[$id] = true;
    $p = q($db, "SELECT ID, post_title, post_name, post_type, post_status FROM wp_posts WHERE ID=" . (int)$id);
    if (!$p) return;
    $p = $p[0];
    $d = q($db, "SELECT meta_value FROM wp_postmeta WHERE post_id=" . (int)$id . " AND meta_key='_elementor_data'");
    $tt = q($db, "SELECT meta_value FROM wp_postmeta WHERE post_id=" . (int)$id . " AND meta_key='_elementor_template_type'");
    $lines = ['# ' . $p['post_title'], '', 'ID ' . $p['ID'] . ' | slug /' . $p['post_name'] . '/ | ' . $p['post_type'] . ' | ' . $p['post_status']
        . ($tt ? ' | template type: ' . $tt[0]['meta_value'] : ''), ''];
    $templates = [];
    $json = $d ? json_decode($d[0]['meta_value'], true) : null;
    if ($json) {
        walk($json, 0, $lines, $skipKey, $skipVal, $templates);
    } else {
        $c = q($db, "SELECT post_content FROM wp_posts WHERE ID=" . (int)$id);
        $lines[] = $c[0]['post_content'] ?? '';
    }
    if (!is_dir($dir)) mkdir($dir, 0777, true);
    file_put_contents($dir . '/' . $id . '-' . ($p['post_name'] ?: 'untitled') . '.md', implode("\n", $lines) . "\n");
    foreach (array_unique($templates) as $t) dumpPost($db, $t, $dir, $skipKey, $skipVal, $seen);
}

$seen = [];
$pages = [11, 6281, 6283, 988001, 988114, 988170, 6417, 6425, 16161, 989059, 6426, 30];
foreach ($pages as $id) dumpPost($db, $id, $out . '/pages', $skipKey, $skipVal, $seen);

// Header / footer / popup templates and the conditions they apply to
$rows = q($db, "SELECT p.ID, p.post_title, p.post_status, t.meta_value type, c.meta_value cond FROM wp_posts p
    JOIN wp_postmeta t ON t.post_id=p.ID AND t.meta_key='_elementor_template_type'
    LEFT JOIN wp_postmeta c ON c.post_id=p.ID AND c.meta_key='_elementor_conditions'
    WHERE p.post_type='elementor_library' ORDER BY t.meta_value, p.ID");
$tl = [];
foreach ($rows as $r) {
    $cond = $r['cond'] ? unserialize($r['cond'], ['allowed_classes' => false]) : null;
    $tl[] = $r['ID'] . ' | ' . $r['type'] . ' | ' . $r['post_status'] . ' | ' . $r['post_title'] . ' | conditions: ' . ($cond ? json_encode($cond) : '-');
    if ($r['post_status'] === 'publish' && $cond && in_array($r['type'], ['header', 'footer', 'popup'], true)) {
        dumpPost($db, (int)$r['ID'], $out . '/templates', $skipKey, $skipVal, $seen);
    }
}
file_put_contents($out . '/templates-index.txt', implode("\n", $tl) . "\n");

// Brand: Elementor kit (global colours & fonts)
$kitId = (int)(q($db, "SELECT option_value FROM wp_options WHERE option_name='elementor_active_kit'")[0]['option_value'] ?? 9);
$kit = q($db, "SELECT meta_value FROM wp_postmeta WHERE post_id=$kitId AND meta_key='_elementor_page_settings'");
$k = $kit ? unserialize($kit[0]['meta_value'], ['allowed_classes' => false]) : [];
$brand = ['kit_id' => $kitId];
foreach ($k as $key => $v) {
    if (preg_match('/colors|typography|site_|body_|link_|button_|h[1-6]_/', $key)) $brand[$key] = $v;
}
file_put_contents($out . '/brand-kit.json', json_encode($brand, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));

// SEO meta from AIOSEO / SiteSEO / Yoast
$seo = [];
$hasAio = q($db, "SHOW TABLES LIKE 'wp_aioseo_posts'");
foreach ($pages as $id) {
    $row = ['id' => $id];
    if ($hasAio) {
        $a = q($db, "SELECT title, description, keyphrases, og_title, og_description FROM wp_aioseo_posts WHERE post_id=$id");
        if ($a) $row['aioseo'] = $a[0];
    }
    foreach (q($db, "SELECT meta_key, meta_value FROM wp_postmeta WHERE post_id=$id AND (meta_key LIKE '_siteseo%' OR meta_key LIKE '_aioseo%' OR meta_key LIKE '_yoast_wpseo_%')") as $m) {
        $row[$m['meta_key']] = $m['meta_value'];
    }
    $seo[] = $row;
}
file_put_contents($out . '/seo-meta.json', json_encode($seo, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));

// Forms: Formidable forms, fields, email actions; Contact Form 7
$forms = ['formidable_forms' => q($db, "SELECT id, form_key, name, status, parent_form_id FROM wp_frm_forms ORDER BY id")];
$forms['formidable_fields'] = q($db, "SELECT id, form_id, name, type, required, field_order, options, default_value, description FROM wp_frm_fields ORDER BY form_id, field_order");
$forms['formidable_actions'] = q($db, "SELECT ID, post_title, post_excerpt action_type, menu_order form_id, post_status, post_content FROM wp_posts WHERE post_type='frm_form_actions'");
foreach (q($db, "SELECT ID, post_title FROM wp_posts WHERE post_type='wpcf7_contact_form'") as $cf) {
    $m = q($db, "SELECT meta_key, meta_value FROM wp_postmeta WHERE post_id={$cf['ID']} AND meta_key IN ('_form','_mail','_mail_2')");
    $forms['cf7'][] = ['form' => $cf, 'meta' => $m];
}
file_put_contents($out . '/forms.json', json_encode($forms, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));

// Blog posts (listed only, for redirects)
$posts = q($db, "SELECT ID, post_name, post_title, post_date FROM wp_posts WHERE post_type='post' AND post_status='publish' ORDER BY post_date");
file_put_contents($out . '/blog-posts.json', json_encode($posts, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
echo "done\n";
