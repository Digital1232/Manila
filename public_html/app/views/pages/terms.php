<?php
defined('MIPS') || exit;
// Terms & Conditions: text from the original page.
partial('page-hero', ['crumbs' => $crumbs, 'eyebrow' => 'Legal', 'title' => 'Terms &amp; Conditions']);
?>
<section class="section">
  <div class="container prose">
    <p class="text-lg">Welcome to the official website of <strong>Manila Institute of Paramedical Science</strong> (“we”, “our”, “us”). By accessing or using this website, you agree to be bound by the following Terms &amp; Conditions.</p>

    <h2>1. Website Usage</h2>
    <p>This website is intended to:</p>
    <ul>
      <li>Provide information about courses, admissions, and institute services</li>
      <li>Enable users to submit enquiries and contact requests</li>
    </ul>
    <p>You agree to use this website only for lawful purposes and in a manner that does not violate any applicable laws or regulations.</p>

    <h2>2. Eligibility</h2>
    <p>By using this website, you confirm that:</p>
    <ul>
      <li>You are at least 18 years old <strong>or</strong> accessing under parental/guardian supervision</li>
      <li>The information you provide is accurate and complete</li>
    </ul>

    <h2>3. Course &amp; Admission Information</h2>
    <ul>
      <li>All course details, fees, duration, and eligibility criteria are subject to change without prior notice</li>
      <li>Submission of an enquiry form <strong>does not guarantee admission</strong></li>
      <li>Admission is subject to institute rules, seat availability, and eligibility verification</li>
    </ul>

    <h2>4. Intellectual Property Rights</h2>
    <p>All content on this website, including:</p>
    <ul>
      <li>Text</li>
      <li>Images</li>
      <li>Logos</li>
      <li>Graphics</li>
      <li>Design elements</li>
    </ul>
    <p>are the property of <strong>Manila Institute of Paramedical Science</strong>.</p>
    <p>You may NOT:</p>
    <ul>
      <li>Copy, reproduce, or redistribute content</li>
      <li>Use any material for commercial purposes</li>
    </ul>
    <p>without prior written permission.</p>

    <h2>5. User Conduct</h2>
    <p>You agree NOT to:</p>
    <ul>
      <li>Submit false or misleading information</li>
      <li>Attempt unauthorized access to the website/server</li>
      <li>Disrupt website functionality</li>
      <li>Use the website for fraudulent or illegal activities</li>
    </ul>

    <h2>6. Third-Party Links</h2>
    <p>This website may include links to third-party websites.</p>
    <p>We:</p>
    <ul>
      <li>Do NOT control these websites</li>
      <li>Are NOT responsible for their content, policies, or practices</li>
    </ul>

    <h2>7. Modifications to Terms</h2>
    <p>We reserve the right to:</p>
    <ul>
      <li>Update or modify these Terms at any time</li>
    </ul>
    <p>Changes will be effective immediately upon posting. Continued use of the website means acceptance of updated terms.</p>

    <h2>8. Contact Information</h2>
    <p>For any queries:</p>
    <div class="contact-box">
      <strong><?= e($site['name']) ?></strong>
      <p><?= icon('mail') ?> Email: <a href="mailto:<?= e($site['email']) ?>"><?= e($site['email']) ?></a></p>
      <p><?= icon('phone') ?> Phone: <a href="<?= e(tel_href($site['phones'][0])) ?>"><?= e($site['phones'][0]) ?></a></p>
    </div>
  </div>
</section>
