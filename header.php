<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php if ( function_exists('wp_body_open') ) { wp_body_open(); } ?>
<header class="site-header">
  <div class="container">
    <div class="site-branding">
      <a href="<?php echo esc_url( home_url('/') ); ?>" class="site-link">
        <div class="site-logo">
          <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/logo.png' ); ?>" alt="<?php bloginfo('name'); ?> logo" />
        </div>
        <div class="site-name">Anthony Pirolli Jr</div>
      </a>
    </div>

    <button class="menu-toggle" aria-label="Open menu" aria-controls="primary-menu" aria-expanded="false">
      <span class="menu-toggle-bar"></span>
      <span class="menu-toggle-bar"></span>
      <span class="menu-toggle-bar"></span>
    </button>

    <nav class="main-nav" id="primary-menu" aria-label="<?php esc_attr_e('Primary menu','my-portfolio'); ?>">
      <?php
        wp_nav_menu([
          'theme_location' => 'header-menu',
          'menu_class'     => 'nav-menu',
          'container'      => false,
          'fallback_cb'    => '__return_empty_string',
          'depth'          => 2,
        ]);
      ?>
    </nav>
    <div class="nav-overlay" hidden></div>
  </div>
</header>

