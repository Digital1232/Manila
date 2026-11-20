# Hostinger upload package

Package: `deploy/manilainstitute-hostinger-ready-2026-11-19.zip`

This package includes the complete PHP website and a ready-to-use
`private/config.php`. Configuration is production mode, canonical URL
`https://manilainstitute.com`, PHP server mail transport, and recipient
`alexvilpower@gmail.com` for both admission enquiries and contact messages.
No SMTP password, existing form secret, enquiries or local logs are included.

## Upload location

Use the domain folder that contains `public_html`, normally
`domains/manilainstitute.com/`. Extract the ZIP there. The result must be:

- `public_html/index.php`
- `public_html/app/`
- `public_html/assets/`
- `private/config.php`

The two folders must be siblings. Do not put `private` inside `public_html`.

## Before replacing the old website

Create and download a fresh full hosting backup, including the old website
files and database. Preserve the old `public_html` contents in a separate
folder outside the public document root, rather than mixing them with this
website. Keep any existing private configuration and enquiry storage in that
backup too. Upload to the verified domain only.

Use PHP 8.2 or newer and confirm the domain has a valid HTTPS certificate.
Extract into the prepared location and clear the hosting/CDN cache.
No WordPress installation or database import is required for this website.

## Verify after upload

1. Open Home, About Us, Courses, all four course pages, Admission and Contact.
2. Check phone/tablet menu, course dropdown, images and Apply buttons.
3. Submit one clearly labelled test admission and one test contact message.
4. Check `alexvilpower@gmail.com`, including Spam, for both complete messages.
5. Confirm Privacy Policy, Terms & Conditions and the location map load.

Actual live inbox delivery and server compatibility are not established by
building the ZIP. If mail does not arrive, check the server mail logs and
configure SMTP in `private/config.php` if the host requires it.

After the tests, restore the original form recipient by editing this one line
in the live `private/config.php`:

```php
'recipients' => ['manilainstitute2026@gmail.com'],
```

That single setting applies to both forms.
