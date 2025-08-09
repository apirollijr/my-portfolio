<?php
/** front-page.php */
get_header();

$headline   = get_theme_mod('hero_headline', 'Hi, I’m Anthony — I build fast, clean websites.');
$subheadline= get_theme_mod('hero_subheadline', 'WordPress & full‑stack projects with React, Express, and SQL. Let’s ship something great.');
$btn_text   = get_theme_mod('hero_button_text', 'Contact Me');
$btn_url    = get_theme_mod('hero_button_url', home_url('/#contact'));
$img_id     = (int) get_theme_mod('hero_image_id', 0);
$img_val = get_theme_mod('hero_image_id', 0);
if (is_numeric($img_val)) {
  $src_arr = wp_get_attachment_image_src((int)$img_val, 'hero_portrait');
  $img_src = $src_arr ? $src_arr[0] : get_template_directory_uri() . '/assets/img/selfie-placeholder.jpg';
} else {
  $img_src = $img_val ?: get_template_directory_uri() . '/assets/img/selfie-placeholder.jpg';
}

// Fallback to placeholder if no image is set or the ID is invalid
?>

<section class="hero" role="region" aria-label="Intro">
  <div class="hero__inner container">
    <div class="hero__copy">
      <h1 class="hero__title"><?php echo wp_kses_post($headline); ?></h1>
      <p class="hero__subtitle"><?php echo wp_kses_post($subheadline); ?></p>
      <a class="button hero__button" href="<?php echo esc_url($btn_url); ?>">
        <?php echo esc_html($btn_text); ?>
      </a>
    </div>

    <div class="hero__media">
      <img class="hero__image" src="<?php echo esc_url($img_src); ?>" alt="Portrait of Anthony Pirolli" loading="eager" decoding="async" />
    </div>
  </div>
  <div class="hero__bg" aria-hidden="true"></div>
</section>

<main class="home-main container">
  <?php
    // Your homepage content/loop here, or include template parts.
    if (have_posts()) :
      while (have_posts()) : the_post();
        the_content();
      endwhile;
    endif;
  ?>
</main>

<?php get_footer(); ?>
