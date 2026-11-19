# Manila Institute website

Custom PHP website for Manila Institute of Paramedical Science, Tirunelveli.

## Project contents

- `public_html/`: website pages, form handlers, images, fonts, CSS and JavaScript.
- `private/config.example.php`: deployment configuration template, outside the web root.
- `dev/`: local router, content extraction and asset preparation utilities, source images.
- `source-content/`: reference content extracted from the previous website.
- `deploy/`: upload-ready website ZIP.
- `DEPLOY-GUIDE.md`: Hostinger staging, launch, testing and rollback instructions.
- `CLEANUP-LIST.md`: findings and cleanup guidance for the previous WordPress site.

## Local preview

Requires PHP 8 or newer. From this project directory:

1. Copy `private/config.example.php` to `private/config.php`.
2. Set `env` to `development`, `site_url` to `http://localhost:8090`, and mail `transport` to `log`.
3. Start the local server:

```sh
php -S localhost:8090 -t public_html dev/router.php
```

Open http://localhost:8090/. Local log transport writes test email messages to
`private/storage/outbox/`; it does not send email.

## Form email routing

Both admission enquiries (Home and Admission pages) and Contact messages use
the same `mail.recipients` setting in `private/config.php`.

The current test recipient is `alexvilpower@gmail.com`. After testing on the
hosting server, change the recipient in that one file to
`manilainstitute2026@gmail.com` to restore the original destination.

On Hostinger, use `transport => 'mail'` as shown in the configuration template.
Verify actual delivery for both forms after deployment. Local routing checks
do not establish Gmail inbox delivery.

## Configuration and data

Live/local configuration and generated storage are excluded from Git. Keep
`private/` beside `public_html/`, outside the public document root. Never
commit passwords, form secrets, enquiry CSV files, email outbox files or logs.

The compromised old WordPress installation, database dumps and quarantine
files from the parent workspace are not part of this project.

## Recent verification

- Eleven pages checked at widths 320, 390, 768, 1024 and 1280 pixels.
- Narrow-screen admission, contact and legal-page overflow corrected.
- Mobile menu, course dropdown, form validation and location map inspected.
- Both form notification types checked locally for recipient routing and all
  expected email fields.

See `DEPLOY-GUIDE.md` before uploading to Hostinger.
