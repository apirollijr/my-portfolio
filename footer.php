<footer class="site-footer">
  <div class="container">
    <nav class="footer-nav" aria-label="<?php esc_attr_e('Footer menu','my-portfolio'); ?>">
      <?php
        wp_nav_menu([
          'theme_location' => 'footer-menu',
          'menu_class'     => 'footer-menu',
          'container'      => false,
          'fallback_cb'    => '__return_empty_string',
          'depth'          => 1,
        ]);
      ?>
    </nav>
    <p>&copy; <?php echo esc_html( date('Y') ); ?> <?php bloginfo('name'); ?>. All rights reserved.</p>
  </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
