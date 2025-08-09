<?php
/**
 * Template Name: Contact
 */
get_header();
?>
<main class="container my-5">   
<section class="contact contact--safe">
  <div class="contact__wrap">
    <header class="contact__header">
      <h1 class="contact__title">Get in touch</h1>
      <p class="contact__tagline">Tell me about your project—I'll reply within 1–2 business days.</p>

      <?php
      $status = isset($_GET['contact_status']) ? sanitize_text_field($_GET['contact_status']) : '';
      if ($status === 'ok'): ?>
        <div class="contact__notice contact__notice--success">Thanks! Your message has been sent.</div>
      <?php elseif ($status === 'fail'): ?>
        <div class="contact__notice contact__notice--error">Sorry, something went wrong. Please try again later.</div>
      <?php elseif ($status === 'invalid'):
        $fields = isset($_GET['fields']) ? explode(',', sanitize_text_field($_GET['fields'])) : array();
        ?>
        <div class="contact__notice contact__notice--error">Please fix the highlighted fields and try again.</div>
      <?php elseif ($status === 'security' || $status === 'bot'): ?>
        <div class="contact__notice contact__notice--error">Security check failed. Please try again.</div>
      <?php endif; ?>
    </header>

    <?php
      $invalid = isset($fields) ? $fields : array();
      $has = function($f) use ($invalid) { return in_array($f, $invalid, true) ? ' is-invalid' : ''; };
      $old = array(
        'name'    => isset($_GET['name']) ? esc_attr($_GET['name']) : '',
        'email'   => isset($_GET['email']) ? esc_attr($_GET['email']) : '',
        'subject' => isset($_GET['subject']) ? esc_attr($_GET['subject']) : '',
        'message' => isset($_GET['message']) ? esc_textarea($_GET['message']) : '',
      );
    ?>

    <form class="contact__form" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
  <?php wp_nonce_field('myp_contact_submit', 'myp_contact_nonce'); ?>
  <input type="hidden" name="action" value="contact_form_submit">

  <?php
    // collect sticky values + invalid flags
    $invalid   = isset($_GET['fields']) ? explode(',', sanitize_text_field($_GET['fields'])) : array();
    $old_name  = isset($_GET['name'])    ? esc_attr($_GET['name'])       : '';
    $old_email = isset($_GET['email'])   ? esc_attr($_GET['email'])      : '';
    $old_subj  = isset($_GET['subject']) ? esc_attr($_GET['subject'])    : '';
    $old_msg   = isset($_GET['message']) ? esc_textarea($_GET['message']) : '';

    $name_err  = in_array('name', $invalid, true)    ? ' is-invalid' : '';
    $email_err = in_array('email', $invalid, true)   ? ' is-invalid' : '';
    $msg_err   = in_array('message', $invalid, true) ? ' is-invalid' : '';
    $agree_err = in_array('agree', $invalid, true)   ? ' is-invalid' : '';
  ?>

  <div class="field">
    <label for="cf-name"><span>Name</span></label>
    <input id="cf-name" class="input<?php echo $name_err; ?>" type="text" name="name" placeholder="Your name" value="<?php echo $old_name; ?>" required>
  </div>

  <div class="field">
    <label for="cf-email"><span>Email</span></label>
    <input id="cf-email" class="input<?php echo $email_err; ?>" type="email" name="email" placeholder="you@example.com" value="<?php echo $old_email; ?>" required>
  </div>

  <div class="field">
    <label for="cf-subject"><span>Subject</span></label>
    <input id="cf-subject" class="input" type="text" name="subject" placeholder="Project inquiry" value="<?php echo $old_subj; ?>">
  </div>

  <div class="field">
    <label for="cf-message"><span>Message</span></label>
    <textarea id="cf-message" class="textarea<?php echo $msg_err; ?>" name="message" rows="6" placeholder="What are you building?" required><?php echo $old_msg; ?></textarea>
  </div>

  <label class="checkbox<?php echo $agree_err; ?>">
    <input type="checkbox" name="agree" value="1" required>
    <span>I agree you may contact me about this inquiry.</span>
  </label>

  <!-- Honeypot (keep hidden) -->
  <label class="hp" aria-hidden="true">
    <input type="text" name="website" tabindex="-1" autocomplete="off">
  </label>

  <button class="button contact__submit" type="submit">Send Message</button>
</form>

  </div>
</section>
</main>
<?php get_footer(); ?>
