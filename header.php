<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
  <header class="site-header">
  <div class="container">
        <div class="site-branding">
          <a href="<?php echo home_url(); ?>" class="site-link">
            <div class="site-logo">
              <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.png" alt="Site Logo" />
            </div>
            <div class="site-name">Anthony Pirolli Jr</div>
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

