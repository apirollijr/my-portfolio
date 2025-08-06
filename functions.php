<?php
function my_portfolio_setup() {
  add_theme_support('title-tag');
  add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'my_portfolio_setup');

function my_portfolio_scripts() {
  $css_path = get_template_directory_uri() . '/assets/css/';

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
