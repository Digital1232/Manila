# Cleanup list — candidates only, nothing has been deleted

Rules agreed for this project:

- Nothing is deleted while the new site is being built or tested.
- Removal starts only **after** the new site is live, tested, and you approve each group below.
- Before deleting anything on the server, download a copy (or confirm your hPanel backup covers it).

Sizes and dates come from the local copy of the site (`E:\Manila\public_html`) and its database.

---

## A. On the Hostinger server (after go-live, suggested wait: 30 days)

After the go-live step, all old WordPress files sit in `domains/manilainstitute.com/old-wordpress-2026-11-18/`,
outside the public folder, so none of them can be opened from the web any more.

| # | What | Why it can go | Note |
|---|---|---|---|
| A1 | WordPress core: `wp-admin/`, `wp-includes/`, `wp-*.php`, `xmlrpc.php`, `index.php`, `.htaccess` | Replaced by the new site | — |
| A2 | Theme `estudiar/` and `estudiar.zip` | Nulled copy of the Vamtam theme; its `functions.php` is missing (only `functions.php_bak` with a licence bypass remains), which caused the critical error | The new site does not use it |
| A3 | Fake themes `post_1753519355`, `custom_file_4_1753716110`, `front_page_template_1753750402`, `custom-file-3-1753767750` | Copies of the free themes PopularFX and Hello Elementor in randomly numbered folders, created 26–29 July 2025 | Typical hiding place for malware |
| A4 | Backdoors and suspicious plugins (table B below) | Planted by the attacker or not part of the site | **Highest priority** |
| A5 | Normal plugins (Elementor, Slider Revolution, Formidable, etc.; table C below) | Only needed by WordPress | Several are paid "Pro" versions of unknown origin |
| A6 | `wp-content/uploads/` | Every image the new site uses is already in `public_html/assets/img` (resized, WebP) | Keep a downloaded copy for your archive |
| A7 | `wp-content/backuply/` (357 MB backup from 3 July 2026: all files + full database dump) | Superseded by your new hPanel backup | Contains the database with password hashes; delete from the server after downloading |
| A8 | WordPress **database** (name is in the old `wp-config.php`) | The new site does not use a database | Holds the fake admin accounts and 17 spam posts; drop it in hPanel → Databases |
| A9 | `mu-plugins/hostinger-h5g-plugin.php`, `hostinger-preview-domain.php` | Genuine Hostinger helper files, useful only for WordPress | Not malicious |
| A10 | `create_autologin_b2a1…e1.php` in the old site root | Hostinger's one-click "WP Admin" login helper; it deletes itself when opened and stops working after 15 minutes | Harmless leftover, not malicious |

### B. Backdoors and suspicious plugins (part of A4)

| Folder (in `wp-content/plugins/`) | What it is |
|---|---|
| `analytics_1753814090` | **Backdoor.** Contains `singIe.php` (capital I) = Tiny File Manager: full file access from a browser. Folder dated 29 July 2025 |
| `PHP_Console_1_2_1` ("WP Console") | **Backdoor.** Runs any PHP code typed into it |
| `wp-file-manager` | File manager plugin; old versions had a well-known remote takeover hole. Not needed |
| `fileorganizer` | Another file manager plugin. Not needed |
| `widget-1785359503` ("Preferred Languages") | Real plugin copied into a numbered folder on 29 July 2026; contains a marker file `styIe.php` (capital I) left by the attacker |
| `slider-1784975230` ("301 Redirects") | Real plugin copied into a numbered folder on 25 July 2026 |
| `plugin-autoupdate` ("WP Helpers") | Unknown author, not a known plugin |
| `helix-beacon-tap`, `helper_b3809663` | Unknown, no plugin header |
| `wp-classic-editor` | **Spam kit**, not an editor: a list of 1,016 medicine names and a map of about 180 countries/languages (`wp-woocommerce.php`, `wp-localization.php`) used to generate fake pharmacy pages for Google |
| `grid-config-lab`, `grid-config-lab-loader`, `manage_security`, `site-health-utilities`, `ultimate-linkflow-control`, `woocommerce_inputs`, `wordpresslic`, `wp-compat`, `wp-link-helper`, `wp-security-helper`, `wp_configuration`, `wp_sucuri`, `wpbasiccaheengine`, `easypost`, `wordfence-spam`, `speed-optimizer` | Empty folders with names that imitate real plugins (leftovers of removed malware) |

Because of the pharmacy spam kit and the casino posts, check Google Search Console after launch for
spam pages under manilainstitute.com. The new site answers 404 or 410 for all of them; the
Removals tool in Search Console can speed up their removal from Google.

### C. Normal plugins (part of A5)

| Folder | Plugin | Note |
|---|---|---|
| `elementor`, `elementor-pro` | Elementor page builder (+ Pro) | Built the old pages |
| `vamtam-elementor-integration`, `vamtam-importers-e` | Companions of the Estudiar theme | — |
| `revslider` + 5 `revslider-*-addon` | Slider Revolution | Old home-page slider |
| `formidable`, `formidable-pro`, `contact-form-7` | Form plugins | Old forms; replaced by the new forms |
| `all-in-one-seo-pack`, `siteseo` | Two SEO plugins | Titles, descriptions and sitemap are now built into the new site |
| `redirection` | Redirects | The needed redirects were rebuilt in the new site |
| `google-site-kit`, `official-facebook-pixel` | Google Site Kit, Meta Pixel | Tracking; not carried over (see "Tracking" in section 9 of the guide) |
| `insert-headers-and-footers` | WPCode Lite | Can inject code into every page |
| `learnpress` | LearnPress (online courses) | Not used by any page |
| `duplicate-page` | Duplicate Page | Admin helper |
| `image-optimization`, `imagify`, `litespeed-cache` | Image optimisers, cache | Not needed: images were optimised during the rebuild |
| `pojo-accessibility` | Ally accessibility widget | The new site is built to be accessible without it |
| `all-in-one-wp-migration`, `backuply`, `backuply-pro` | Backup / migration tools | `backuply` made the backup in A7 |

"Pro" plugins (Elementor Pro, Formidable Pro, Backuply Pro, Slider Revolution) are paid products;
with a nulled theme on the site, these copies may be nulled too.

### D. WordPress accounts and content (inside the database, A8)

| What | Detail |
|---|---|
| 10 × `newsauth` (administrator) | All with the same login name, registered 2021-06-14 22:04:53 — inserted straight into the database, not through WordPress |
| `adminbackup` (administrator) | Registered 2025-07-26 08:11 UTC, 31 minutes before the first fake theme folder |
| `admin` (administrator) | Registered 2025-06-20; probably the real admin account |
| 17 posts | Casino spam in Russian, German, Turkish and other languages; the new site answers 410 Gone for their addresses |

---

## E. On this computer (`E:\Manila`)

| # | What | Why it exists |
|---|---|---|
| E1 | `E:\Manila\public_html` | Local copy of the old site; `wp-config.php` was edited to run the local preview |
| E2 | `E:\Manila\quarantine` | Suspicious plugins and Hostinger helper files moved out of the local copy (not out of the live server) |
| E3 | `E:\Manila\local-preview` | Database export and logs used for the local WordPress preview |
| E4 | Database `manila_local` in XAMPP MariaDB | Local import of the WordPress database |
| E5 | `E:\Manila\new-site\dev\extracted` | Original images copied out of the backup while building |
| E6 | `E:\Manila\new-site\private\storage` | Test enquiries and test emails from local testing (not in the upload zip) |
| E7 | "manila-local" entry in `E:\Manila\.claude\launch.json` | Starts the old WordPress preview |

**Keep:** `E:\Manila\new-site` (the new website's source and the upload zip) and your downloaded hPanel backups.
