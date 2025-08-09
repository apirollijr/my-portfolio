<?php
/**
 * Theme functions for My Portfolio
 */

// =========================
// Theme setup
// =========================
add_action('after_setup_theme', function () {
  add_theme_support('title-tag');
  add_theme_support('post-thumbnails');
  add_theme_support('html5', ['search-form','comment-form','comment-list','gallery','caption','style','script']);
  add_theme_support('custom-logo', ['height'=>80,'width'=>80,'flex-width'=>true,'flex-height'=>true]);

  register_nav_menus([
    'header-menu' => __('Header Menu', 'my-portfolio'),
    'footer-menu' => __('Footer Menu', 'my-portfolio'),
  ]);

  // Hard-cropped image size for the hero (square by default)
  add_image_size('hero_portrait', 840, 840, true);
});

// =========================
// Assets
// =========================
add_action('wp_enqueue_scripts', function () {

  // Google font (Plaster) – remove if you don't want it here
  wp_enqueue_style(
    'my-portfolio-fonts',
    'https://fonts.googleapis.com/css2?family=Plaster&display=swap',
    [],
    null
  );
  
    $base = get_template_directory_uri() . '/assets/css/';
      wp_enqueue_style('my-portfolio-base',   $base . 'base.css',   [], filemtime(get_template_directory() . '/assets/css/base.css'));
      wp_enqueue_style('my-portfolio-layout', $base . 'layout.css', ['my-portfolio-base'], filemtime(get_template_directory() . '/assets/css/layout.css'));
      wp_enqueue_style('my-portfolio-module', $base . 'module.css', ['my-portfolio-layout'], filemtime(get_template_directory() . '/assets/css/module.css'));
      wp_enqueue_style('my-portfolio-state',  $base . 'state.css',  ['my-portfolio-module'], filemtime(get_template_directory() . '/assets/css/state.css'));
      wp_enqueue_style('my-portfolio-theme',  $base . 'theme.css',  ['my-portfolio-state'], filemtime(get_template_directory() . '/assets/css/theme.css'));

      // Mobile nav toggle
      wp_enqueue_script(
        'my-portfolio-nav',
        get_template_directory_uri() . '/assets/js/nav.js',
        [],
        filemtime(get_template_directory() . '/assets/js/nav.js'),
        true
      );
    });

// =========================
// HOMEPAGE HERO – Customizer
// =========================
function myp_customize_register_hero($wp_customize) {
  // Section
  $wp_customize->add_section('hero_section', [
    'title'       => __('Homepage Hero', 'my-portfolio'),
    'priority'    => 30,
    'description' => __('Edit the hero content shown on the homepage.', 'my-portfolio')
  ]);

  // Headline
  $wp_customize->add_setting('hero_headline', [
    'default'           => 'Hi, I’m Anthony — I build fast, clean websites.',
    'sanitize_callback' => 'wp_kses_post',
    'transport'         => 'postMessage'
  ]);
  $wp_customize->add_control('hero_headline', [
    'label'   => __('Headline', 'my-portfolio'),
    'type'    => 'textarea',
    'section' => 'hero_section'
  ]);

  // Subheadline
  $wp_customize->add_setting('hero_subheadline', [
    'default'           => 'WordPress & full‑stack projects with React, Express, and SQL. Let’s ship something great.',
    'sanitize_callback' => 'wp_kses_post',
    'transport'         => 'postMessage'
  ]);
  $wp_customize->add_control('hero_subheadline', [
    'label'   => __('Subheadline', 'my-portfolio'),
    'type'    => 'textarea',
    'section' => 'hero_section'
  ]);

  // Button text
  $wp_customize->add_setting('hero_button_text', [
    'default'           => 'Contact Me',
    'sanitize_callback' => 'sanitize_text_field',
    'transport'         => 'postMessage'
  ]);
  $wp_customize->add_control('hero_button_text', [
    'label'   => __('Button Text', 'my-portfolio'),
    'type'    => 'text',
    'section' => 'hero_section'
  ]);

  // Button URL (default to /contact/)
  $wp_customize->add_setting('hero_button_url', [
    'default'           => home_url('/contact/'),
    'sanitize_callback' => 'esc_url_raw'
  ]);
  $wp_customize->add_control('hero_button_url', [
    'label'   => __('Button Link (URL)', 'my-portfolio'),
    'type'    => 'url',
    'section' => 'hero_section'
  ]);

  // Cropped Image (with WP crop UI)
  $wp_customize->add_setting('hero_image_id', [
    'default'           => 0,
    'sanitize_callback' => 'absint',
  ]);
  $wp_customize->add_control(new WP_Customize_Cropped_Image_Control(
    $wp_customize,
    'hero_image_id',
    [
      'label'       => __('Selfie / Hero Image', 'my-portfolio'),
      'section'     => 'hero_section',
      'flex_width'  => true,
      'flex_height' => true,
      'width'       => 840,
      'height'      => 840,
      'description' => __('Upload an image and crop it to fit the hero.', 'my-portfolio'),
    ]
  ));
}
add_action('customize_register', 'myp_customize_register_hero');

// Live preview for hero (optional; safe if file missing)
function myp_customize_preview_js() {
  wp_enqueue_script(
    'hero-customizer-preview',
    get_template_directory_uri() . '/assets/js/hero-customizer-preview.js',
    ['customize-preview','jquery'],
    null,
    true
  );
}
add_action('customize_preview_init', 'myp_customize_preview_js');

// =========================
// CONTACT FORM HANDLER
// =========================
function myp_handle_contact_form() {
  // 1) Verify nonce
  if ( ! isset($_POST['myp_contact_nonce']) || ! wp_verify_nonce($_POST['myp_contact_nonce'], 'myp_contact_submit') ) {
    wp_safe_redirect( add_query_arg('contact_status', 'security', wp_get_referer() ?: home_url()) );
    exit;
  }

  // 2) Honeypot (should be empty)
  if ( ! empty($_POST['website']) ) {
    wp_safe_redirect( add_query_arg('contact_status', 'bot', wp_get_referer() ?: home_url()) );
    exit;
  }

  // 3) Sanitize
  $name    = isset($_POST['name'])    ? sanitize_text_field($_POST['name'])    : '';
  $email   = isset($_POST['email'])   ? sanitize_email($_POST['email'])        : '';
  $subject = isset($_POST['subject']) ? sanitize_text_field($_POST['subject']) : 'New message';
  $message = isset($_POST['message']) ? wp_kses_post(trim($_POST['message']))  : '';
  $agree   = isset($_POST['agree'])   ? (bool) $_POST['agree']                 : false;

  $errors = [];
  if ($name === '') $errors[] = 'name';
  if (!is_email($email)) $errors[] = 'email';
  if ($message === '' || strlen(wp_strip_all_tags($message)) < 10) $errors[] = 'message';
  if (!$agree) $errors[] = 'agree';

  if (!empty($errors)) {
    $args = [
      'contact_status' => 'invalid',
      'fields'         => implode(',', $errors),
      'name'           => rawurlencode($name),
      'email'          => rawurlencode($email),
      'subject'        => rawurlencode($subject),
      'message'        => rawurlencode(wp_strip_all_tags($message)),
    ];
    wp_safe_redirect(add_query_arg($args, wp_get_referer() ?: home_url()));
    exit;
  }

  // 4) Email
  $to      = get_option('admin_email');
  $subject = 'Portfolio Contact: ' . $subject;
  $body    = "Name: {$name}\nEmail: {$email}\n\nMessage:\n{$message}\n";
  $headers = [
    'Content-Type: text/plain; charset=UTF-8',
    'Reply-To: ' . $name . ' <' . $email . '>',
  ];

  $sent = wp_mail($to, $subject, $body, $headers);

  // 5) Redirect with status
  $status = $sent ? 'ok' : 'fail';
  wp_safe_redirect( add_query_arg('contact_status', $status, wp_get_referer() ?: home_url()) );
  exit;
}
add_action('admin_post_nopriv_contact_form_submit', 'myp_handle_contact_form');
add_action('admin_post_contact_form_submit',        'myp_handle_contact_form');
