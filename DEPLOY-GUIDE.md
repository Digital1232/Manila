# Manila Institute website: deployment guide

This guide takes the new custom-coded website from this computer to **manilainstitute.com** on Hostinger.
Nothing on the live server has been changed yet. Steps marked **Approval needed** change the live
website and are only done after you say yes.

---

## 1. What is ready

| Item | Where |
|---|---|
| New website (source) | `E:\Manila\new-site\public_html` |
| Upload package (tested) | `E:\Manila\new-site\deploy\manilainstitute-website-2026-11-18.zip` (3.6 MB) |
| Settings template | `private/config.example.php` (inside the zip) |
| Original WordPress copy (untouched) | `E:\Manila\public_html` and the Backuply archive inside it |

**Pages:** Home, About Us, Courses (with 4 course pages: DNM, DMLT, DOTT, DRIT), Admission, Contact Us,
plus Privacy Policy and Terms & Conditions (linked from the footer and the forms).

**Technology:** plain PHP 8 + hand-written CSS and JavaScript. No WordPress, no theme, no plugins,
no database, no external scripts or fonts. All text and images come from the original site.

**Already tested on this computer**

- Every page at phone (390 px), tablet (768 px) and desktop (1280 px) widths.
- Menu, Courses dropdown, mobile menu, the call / WhatsApp / Apply bar on phones.
- Admission and Contact forms: inline checks, sending with and without JavaScript,
  email message, saved copy (CSV), spam trap, speed check, foreign-site check, 5-per-10-minutes limit.
- All 92 internal links and images, and all `#section` links.
- The zip unpacked and served by Apache with the real `.htaccess` rules (Hostinger uses LiteSpeed,
  which reads the same rules): every page 200, no PHP warnings, gzip on, security headers on.
- Old WordPress addresses: 301 redirects to the matching new page (for example `/how-to-apply/` →
  `/admission/`, `/?page_id=6281` → `/about-us/`, the old misspelled DOTT address → the new one).
  The 17 casino spam posts and WordPress system paths (`/wp-admin/`, `/wp-login.php`, …) answer
  **410 Gone**, so Google drops them.

**Not tested yet (only possible on the server):** real email delivery to Gmail, HTTPS certificate,
Hostinger caching.

---

## 2. Before you start (your actions)

1. **Make a fresh full backup** in hPanel (Files → Backups): generate a new backup of files *and*
   database, then download both to your computer. Keep them; do not rely only on the July backup.
2. **Enquiry emails: no password needed.** The forms send through the Hostinger server's own mail
   (`'transport' => 'mail'`), the same way the old WordPress site sent its form emails (it had no
   SMTP plugin or mail login). Enquiries go to `alexvilpower@gmail.com`.
   - In the staging test, check whether the test email lands in the Gmail **Inbox** or **Spam**.
     If it is in Spam, mark it "Not spam".
   - **Only if test emails do not arrive at all:** switch to `'transport' => 'smtp'` with a mailbox
     login (for example a new `no-reply@manilainstitute.com` mailbox in hPanel → Emails). You then type
     that mailbox password into `private/config.php` on the server yourself; I never see or handle it.
   - Every enquiry is also saved in a CSV file on the server, so nothing is lost while email is checked.
3. **Answer the questions** at the end of this guide (section 9).

---

## 3. Staging test on Hostinger (live site untouched)

Use a separate address so the real site keeps running while you test.

**Option A (recommended): a temporary Hostinger domain.** In hPanel, add a new website with a free
temporary domain (for example `something.hostingersite.com`). It gets its own folder:
`domains/<temporary-domain>/public_html`.

**Option B: a subdomain** such as `staging.manilainstitute.com`. If hPanel puts its folder *inside*
the main `public_html`, use Option A instead, so the private folder never sits inside a public folder.

Then:

1. Open **File Manager** and go to the folder *that contains* the new site's `public_html`
   (for option A: `domains/<temporary-domain>/`). Delete the default `index.html`/`default.php`
   that Hostinger puts in a new empty `public_html`, if any.
2. Upload `manilainstitute-website-2026-11-18.zip` there and **Extract**. You get:
   ```
   domains/<temporary-domain>/
     public_html/      ← the website
     private/          ← settings, saved enquiries, logs (not reachable from the web)
   ```
3. In `private/`, copy `config.example.php` to `config.php` and edit it:
   - `'env' => 'staging'` (keeps Google out of the test copy)
   - `'site_url' => 'https://<temporary-domain>'`
   - leave the mail settings as they are (`'transport' => 'mail'`, no password).
4. hPanel → Advanced → **PHP Configuration**: PHP **8.2** (anything 8.0 or newer works).
5. Test with the checklist in section 5. Send one admission and one contact enquiry and check that
   the email arrives at `alexvilpower@gmail.com` (look in Spam the first time).

---

## 4. Go live — **Approval needed**

Do this only after staging works and you have said yes. The old WordPress files are **moved, not deleted**.

1. Make another fresh backup if days have passed since step 2.1.
2. File Manager → `domains/manilainstitute.com/`:
   - Create a folder named `old-wordpress-2026-11-18` (next to `public_html`, not inside it).
   - Open `public_html`, turn on **Show hidden files**, select **everything** (including `.htaccess`
     and any `.user.ini`) and **Move** it into `old-wordpress-2026-11-18`.
     `public_html` must now be empty. This also takes the hacker's files (see `CLEANUP-LIST.md`)
     off the web. If a file refuses to move, note its name and tell me before doing anything else.
3. Upload the zip into `domains/manilainstitute.com/` and **Extract** → this fills `public_html/` and
   creates `private/`.
4. Create `private/config.php` from `config.example.php` with `'env' => 'production'` and
   `'site_url' => 'https://manilainstitute.com'`. Mail settings stay as in staging (no password,
   unless staging showed that SMTP is needed).
5. PHP version 8.2 for manilainstitute.com (hPanel → Advanced → PHP Configuration).
6. hPanel → Security → **SSL**: make sure the certificate is active. The site already forces
   `https://` and removes `www.`.
7. Clear caches: hPanel → **LiteSpeed / Cache Manager → Purge all**, and the **CDN** cache if it is on.
   Old WordPress pages may otherwise be shown for a while.
8. Run the checklist below on `https://manilainstitute.com`.

**The WordPress database is left as it is.** The new site does not use it. Keep it until the
cleanup is approved.

### If something goes wrong (rollback)

Move the new files out of `public_html` into a folder such as `new-site-failed`, then move the
contents of `old-wordpress-2026-11-18` back. Or restore the hPanel backup from step 2.1.
Remember the old site was already broken (critical error), so rollback only restores that state.

---

## 5. Test checklist (staging and live)

- [ ] Home, About Us, Courses, the 4 course pages, Admission, Contact Us, Privacy Policy, Terms open, no errors.
- [ ] Menu links, Courses dropdown, footer links, "Apply Now" buttons go to the right place.
- [ ] Phone: the Menu button opens and closes, and the bottom Call / WhatsApp / Apply bar works.
- [ ] Admission form: submit empty → red messages; submit real test data → thank-you message → email arrives.
- [ ] Contact form: same test.
- [ ] `https://manilainstitute.com/wp-admin/` → "This page has been removed" (410).
- [ ] `http://www.manilainstitute.com/about` → ends at `https://manilainstitute.com/about-us/`.
- [ ] `https://manilainstitute.com/sitemap.xml` lists the 11 pages with `https://manilainstitute.com/...`.
- [ ] `https://manilainstitute.com/robots.txt` shows `Allow: /` on live (on staging it must say `Disallow: /`).
- [ ] Map on Contact Us loads; "Get directions" opens Google Maps.

---

## 6. After launch

- **Google Search Console:** submit `https://manilainstitute.com/sitemap.xml`. The 410 pages
  (spam posts, wp-admin) will disappear from Google over the following weeks. Also look for casino
  or pharmacy spam pages under the domain (the hacked site may have served them) and use the
  **Removals** tool if any still show up in search.
- **Enquiries:** every enquiry is emailed *and* saved in
  `private/storage/submissions/admission-YYYY-MM.csv` / `contact-YYYY-MM.csv` (opens in Excel), so
  nothing is lost if an email fails. Phone numbers start with `'` in the CSV; that is a safety measure.
- **Errors:** `private/storage/logs/php-error.log` (should stay empty).
- After about 30 days without problems, review `CLEANUP-LIST.md` and approve the removal of the old files.

---

## 7. Security actions (the old site was hacked)

The site files contain backdoors: a hidden file manager disguised as `singIe.php` (capital I instead
of l) and a "WP Console" plugin that runs any PHP code typed into it. There is also a pharmacy-spam
kit (1,016 medicine names) disguised as `wp-classic-editor`. Fake plugin and theme folders
were added in two waves (late July 2025 and late July 2026). The WordPress database has 10
administrator accounts all called `newsauth` (inserted directly into the database on 2021-06-14) and an
administrator `adminbackup` created on 2025-07-26 at 08:11 UTC, 31 minutes before the first fake theme
folder appeared. Details are in `CLEANUP-LIST.md`.

Moving WordPress out of `public_html` stops all of this from being reached through the web, but the
attacker may also know the account passwords. Please, after go-live:

1. Change the **hPanel / Hostinger account password** and turn on two-factor login.
2. Change **FTP** passwords, and delete FTP accounts you do not recognise (hPanel → Files → FTP Accounts).
3. Change the **database** password (hPanel → Databases). The new site does not use it.
4. Change passwords of the domain's **email** accounts.
5. Check **Cron Jobs** (hPanel → Advanced) and **SSH keys** for entries you did not create; remove them.
6. Run Hostinger's **Malware Scanner** (hPanel → Security) on the account.
7. Do not re-enable or reinstall the old WordPress, the nulled Estudiar theme, or its plugins.

---

## 8. Updating the website later

| To change… | Edit this file |
|---|---|
| Phone numbers, email, address, map, social links | `public_html/app/data/site.php` |
| Course names, summaries, skills, careers, duration | `public_html/app/data/courses.php` |
| Detailed course page text | `public_html/app/views/courses/dnm.php` (`dmlt`, `dott`, `drit`) |
| Home / About / Admission / Contact text | `public_html/app/views/pages/*.php` |
| Who receives enquiries, mail settings | `private/config.php` (server only) |
| Old address redirects | `public_html/app/routes.php` |
| Colours, spacing, layout | `public_html/assets/css/site.css` |

**Preview on this computer:** open the project in Claude Code and start the `manila-new` preview, or run:

```bash
C:/xampp/php/php.exe -S localhost:8090 -t E:/Manila/new-site/public_html E:/Manila/new-site/dev/router.php
```

and open `http://localhost:8090`. Locally, emails are written to `private/storage/outbox` instead of being sent.

---

## 9. Questions for you

**Still needed:**

1. **Does the website look right?** Check it in the preview (`http://localhost:8090`) and say OK,
   or tell me what to change.
2. **Nursing course name:** its course page says *Diploma in Nursing & Midwifery (DNM)*, but the old
   Admission page listed "Diploma in nursing assistant". The new site uses *Nursing & Midwifery (DNM)*.
   Which name is correct?
3. ~~Enquiry emails~~ **Answered:** both forms go only to `alexvilpower@gmail.com`, sent
   without a password (Hostinger's own mail).

**Already decided from your instructions and the old site (no answer needed):**

- **Logo:** the logo from the current site is used (September 2025 version), not a new one.
- **Course duration:** 2 Years for all four courses, as listed on the old Admission page.
- **Pages:** only Home, About Us, Courses (+ 4 course pages), Admission, Contact Us, plus Privacy
  Policy and Terms. The blog is not carried over: its 2 genuine articles redirect to Courses and
  About Us, and the 17 spam posts are removed (410).
- **Tracking:** the old site loaded Google Site Kit and Facebook Pixel; the new site has no tracking
  or cookies. They can be added later if you send the IDs.
- **Wording:** spelling and punctuation were corrected without changing facts (for example
  "Thetre" → "Theatre" in the DOTT page address). "100% Placement" in the home highlights now reads
  "Placement Guidance", matching the original sentence "100% placement guidance".
- **Forms:** Admission asks for name, mobile and course (email optional). Contact asks for first name,
  email, subject and message (last name and mobile optional).
