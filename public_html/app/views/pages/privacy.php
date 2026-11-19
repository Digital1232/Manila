<?php
defined('MIPS') || exit;
// Privacy Policy: text from the original page (contact links corrected).
partial('page-hero', ['crumbs' => $crumbs, 'eyebrow' => 'Legal', 'title' => 'Privacy Policy']);
?>
<section class="section">
  <div class="container prose">
    <p class="text-lg">At Manila Institute of Paramedical Science (“we”, “our”, “us”), we are committed to protecting your privacy and ensuring your personal information is handled securely and responsibly.</p>
    <p>This Privacy Policy explains how we collect, use, and safeguard your information when you visit our website.</p>

    <h2>1. Information We Collect</h2>
    <p>We may collect the following types of information:</p>
    <h3>a) Personal Information</h3>
    <ul>
      <li>Name</li>
      <li>Phone Number</li>
      <li>Email Address</li>
      <li>Address / Location</li>
      <li>Course Inquiry Details</li>
    </ul>
    <h3>b) Non-Personal Information</h3>
    <ul>
      <li>IP address</li>
      <li>Browser type</li>
      <li>Device information</li>
      <li>Pages visited on our website</li>
    </ul>
    <p>Educational websites typically collect such data through forms, analytics, and interactions.</p>

    <h2>2. How We Collect Information</h2>
    <p>We collect information through:</p>
    <ul>
      <li>Website forms (Enquiry / Admission forms)</li>
      <li>Contact submissions</li>
      <li>Cookies and analytics tools</li>
      <li>Direct communication (calls, emails, WhatsApp)</li>
    </ul>

    <h2>3. How We Use Your Information</h2>
    <p>We use your information to:</p>
    <ul>
      <li>Respond to inquiries</li>
      <li>Provide course details and admission support</li>
      <li>Improve website experience</li>
      <li>Send updates, offers, or important notifications</li>
      <li>Maintain internal records</li>
    </ul>

    <h2>4. Data Protection &amp; Security</h2>
    <p>We implement appropriate security measures to protect your data from unauthorized access, misuse, or disclosure.</p>
    <p>We follow standard practices aligned with Indian data protection norms.</p>

    <h2>5. Sharing of Information</h2>
    <p>We <strong>do not sell or rent your personal data</strong>.</p>
    <p>We may share your data only:</p>
    <ul>
      <li>With internal staff for admission processing</li>
      <li>If required by law or government authorities</li>
    </ul>

    <h2>6. Cookies Policy</h2>
    <p>Our website may use cookies to:</p>
    <ul>
      <li>Improve user experience</li>
      <li>Track website performance</li>
      <li>Understand visitor behavior</li>
    </ul>
    <p>You can disable cookies through your browser settings.</p>

    <h2>7. Contact Us</h2>
    <p>For any queries:</p>
    <div class="contact-box">
      <strong><?= e($site['name']) ?></strong>
      <p><?= icon('mail') ?> Email: <a href="mailto:<?= e($site['email']) ?>"><?= e($site['email']) ?></a></p>
      <p><?= icon('phone') ?> Phone: <a href="<?= e(tel_href($site['phones'][0])) ?>"><?= e($site['phones'][0]) ?></a></p>
      <p><?= icon('map-pin') ?> <?= e($site['address']['line1']) ?>, <?= e($site['address']['line2']) ?>, <?= e($site['address']['region']) ?></p>
    </div>
  </div>
</section>
