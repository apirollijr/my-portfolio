<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
  <header class="site-header">
  <div class="container">
    <div class="site-logo">
      <a href="<?php echo esc_url(home_url('/')); ?>">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.png" alt="<?php bloginfo('name'); ?>" height="50">
      </a>
    </div>

    <nav class="main-nav">
      <?php
      wp_nav_menu([
        'theme_location' => 'header-menu',
        'menu_class' => 'nav-menu',
        'container' => false,
      ]);
      ?>
    </nav>
  </div>
</header>

