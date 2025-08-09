<?php
function my_portfolio_setup() {
  add_theme_support('title-tag');
  add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'my_portfolio_setup');

function my_portfolio_scripts() {
  $css_path = get_template_directory_uri() . '/assets/css/';

  wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Plaster&display=swap', false);
  wp_enqueue_style('base', $css_path . 'base.css');
  wp_enqueue_style('layout', $css_path . 'layout.css');
  wp_enqueue_style('module', $css_path . 'module.css');
  wp_enqueue_style('state', $css_path . 'state.css');
  wp_enqueue_style('theme', $css_path . 'theme.css');
}
add_action('wp_enqueue_scripts', 'my_portfolio_scripts');



function my_portfolio_custom_post_type() {
  register_post_type('project', [
    'labels' => [
      'name' => 'Projects',
      'singular_name' => 'Project'
    ],
    'public' => true,
    'has_archive' => true,
    'supports' => ['title', 'editor', 'thumbnail'],
    'rewrite' => ['slug' => 'projects'],
    'show_in_rest' => true,
  ]);
}
add_action('init', 'my_portfolio_custom_post_type');

function my_portfolio_register_menus() {
  register_nav_menus([
    'header-menu' => __('Header Menu'),
    'footer-menu' => __('Footer Menu'),
  ]);
}
add_action('after_setup_theme', 'my_portfolio_register_menus');

/* =========================
 * HERO: image size + customizer
 * ========================= */

// Hard-cropped image size for the hero
add_action('after_setup_theme', function () {
    add_theme_support('post-thumbnails');
    add_image_size('hero_portrait', 840, 840, true); // square, hard crop
});

/**
 * Register Homepage Hero settings/controls
 */
function myp_customize_register_hero( $wp_customize ) {

    // Section
    $wp_customize->add_section('hero_section', array(
        'title'       => __('Homepage Hero', 'my-portfolio'),
        'priority'    => 30,
        'description' => __('Edit the hero content shown on the homepage.', 'my-portfolio'),
    ));

    // Headline
    $wp_customize->add_setting('hero_headline', array(
        'default'           => 'Hi, I’m Anthony — I build fast, clean websites.',
        'sanitize_callback' => 'wp_kses_post',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('hero_headline', array(
        'label'   => __('Headline', 'my-portfolio'),
        'type'    => 'textarea',
        'section' => 'hero_section',
    ));

    // Subheadline
    $wp_customize->add_setting('hero_subheadline', array(
        'default'           => 'WordPress & full‑stack projects with React, Express, and SQL. Let’s ship something great.',
        'sanitize_callback' => 'wp_kses_post',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('hero_subheadline', array(
        'label'   => __('Subheadline', 'my-portfolio'),
        'type'    => 'textarea',
        'section' => 'hero_section',
    ));

    // Button text
    $wp_customize->add_setting('hero_button_text', array(
        'default'           => 'Contact Me',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('hero_button_text', array(
        'label'   => __('Button Text', 'my-portfolio'),
        'type'    => 'text',
        'section' => 'hero_section',
    ));

    // Button URL
    $wp_customize->add_setting('hero_button_url', array(
        'default'           => home_url('/#contact'),
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('hero_button_url', array(
        'label'   => __('Button Link (URL)', 'my-portfolio'),
        'type'    => 'url',
        'section' => 'hero_section',
    ));

    // Cropped Image (shows crop UI)
    $wp_customize->add_setting('hero_image_id', array(
        'default'           => 0,
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control(new WP_Customize_Cropped_Image_Control(
        $wp_customize,
        'hero_image_id',
        array(
            'label'       => __('Selfie / Hero Image', 'my-portfolio'),
            'section'     => 'hero_section',
            'flex_width'  => true,
            'flex_height' => true,
            'width'       => 840,
            'height'      => 840,
            'description' => __('Upload an image and crop it to fit the hero.', 'my-portfolio'),
        )
    ));
}
add_action('customize_register', 'myp_customize_register_hero');

/**
 * Live preview (optional)
 */
function myp_customize_preview_js() {
    wp_enqueue_script(
        'hero-customizer-preview',
        get_template_directory_uri() . '/assets/js/hero-customizer-preview.js',
        array('customize-preview','jquery'),
        null,
        true
    );
}
add_action('customize_preview_init', 'myp_customize_preview_js');
