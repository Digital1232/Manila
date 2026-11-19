<?php
// Prints form widget settings, popup-linked buttons, and Slider Revolution slides (text + images) from the local backup DB. Read-only.
$db = new mysqli('127.0.0.1', 'root', '', 'manila_local');
$db->set_charset('utf8mb4');
function q($db, $sql) { $r = $db->query($sql); return $r && $r !== true ? $r->fetch_all(MYSQLI_ASSOC) : []; }

function find($els, $pageId) {
    foreach ($els as $el) {
        $w = $el['widgetType'] ?? '';
        $s = $el['settings'] ?? [];
        if ($w === 'formidable') echo "page $pageId formidable widget: " . json_encode($s) . "\n";
        if ($w === 'button' && (!empty($s['__dynamic__']) || empty($s['link']['url']))) {
            echo "page $pageId button '" . ($s['text'] ?? '') . "' link=" . json_encode($s['link'] ?? null) . " dynamic=" . json_encode($s['__dynamic__'] ?? null) . "\n";
        }
        if ($w === 'google_maps') echo "page $pageId map: " . json_encode(['address' => $s['address'] ?? null]) . "\n";
        if ($w === 'heading' && ($s['title'] ?? '') === '' ) echo "page $pageId empty heading dynamic=" . json_encode($s['__dynamic__'] ?? null) . "\n";
        if (!empty($el['elements'])) find($el['elements'], $pageId);
    }
}
foreach ([11, 6281, 6283, 988001, 988114, 988170, 6417, 6425, 987880, 7459, 206, 9088] as $id) {
    $d = q($db, "SELECT meta_value FROM wp_postmeta WHERE post_id=$id AND meta_key='_elementor_data'");
    if ($d) find(json_decode($d[0]['meta_value'], true) ?: [], $id);
}

echo "\n== Footer menu items\n";
foreach ([35, 36, 37] as $term) {
    $rows = q($db, "SELECT p.post_title, p.menu_order, MAX(CASE WHEN m.meta_key='_menu_item_object_id' THEN m.meta_value END) oid,
        MAX(CASE WHEN m.meta_key='_menu_item_url' THEN m.meta_value END) url, MAX(CASE WHEN m.meta_key='_menu_item_object' THEN m.meta_value END) obj
        FROM wp_posts p JOIN wp_term_relationships r ON r.object_id=p.ID
        JOIN wp_term_taxonomy tt ON tt.term_taxonomy_id=r.term_taxonomy_id AND tt.term_id=$term
        JOIN wp_postmeta m ON m.post_id=p.ID GROUP BY p.ID ORDER BY p.menu_order");
    foreach ($rows as $r) {
        $t = $r['post_title'] ?: (q($db, "SELECT post_title FROM wp_posts WHERE ID=" . (int)$r['oid'])[0]['post_title'] ?? '');
        echo "menu $term: $t -> {$r['obj']} {$r['oid']} {$r['url']}\n";
    }
}

echo "\n== Slider Revolution\n";
foreach (['wp_revslider_sliders', 'wp_revslider_sliders7'] as $t) {
    foreach (q($db, "SELECT id, title, alias FROM $t") as $s) echo "$t: {$s['id']} | {$s['title']} | {$s['alias']}\n";
}
$slider = q($db, "SELECT id FROM wp_revslider_sliders WHERE alias='FutureSight-Digital-Marketing-Template'");
$sid = $slider[0]['id'] ?? 0;
foreach (['wp_revslider_slides', 'wp_revslider_slides7'] as $t) {
    $col = $t === 'wp_revslider_slides7' ? 'slider_id' : 'slider_id';
    foreach (q($db, "SELECT * FROM $t WHERE $col=" . (int)$sid . " ORDER BY slide_order") as $sl) {
        echo "--- $t slide {$sl['id']} order {$sl['slide_order']}\n";
        $params = json_decode($sl['params'] ?? '{}', true) ?: [];
        $img = $params['image'] ?? ($params['bg']['image'] ?? null);
        if ($img) echo "  bg image: " . (is_array($img) ? json_encode($img) : $img) . "\n";
        if (!empty($params['title'])) echo "  title: {$params['title']}\n";
        $layers = json_decode($sl['layers'] ?? '[]', true) ?: [];
        foreach ($layers as $L) {
            $type = $L['type'] ?? '';
            $text = isset($L['text']) ? trim(preg_replace('/\s+/', ' ', strip_tags(str_replace(['<br>', '<br/>', '<br />'], ' / ', $L['text'])))) : '';
            $src = $L['media']['imageUrl'] ?? ($L['image_url'] ?? ($L['src'] ?? ''));
            $link = $L['actions']['action'][0]['image_link'] ?? ($L['actions']['action'][0]['link'] ?? '');
            $vis = isset($L['visibility']) ? json_encode($L['visibility']) : '';
            if ($text !== '' || $src) echo "  [$type] " . ($text !== '' ? $text : '') . ($src ? " img=$src" : '') . ($link ? " link=$link" : '') . "\n";
        }
    }
}
