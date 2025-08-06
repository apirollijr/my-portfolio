<?php get_header(); ?>

<main class="container">
  <article class="page-content">
    <h1><?php post_type_archive_title(); ?></h1>

    <?php echo do_shortcode('[github_repos user="apirollijr" count="20"]'); ?>
  </article>
</main>

<?php get_footer(); ?>

