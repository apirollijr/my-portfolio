<?php get_header(); ?>

<main class="container">
  <article class="page-content">
    <h1><?php post_type_archive_title(); ?></h1>

    <div class="project-grid">
      <?php echo do_shortcode('[github_repos user="apirollijr" count="20"]'); ?>
    </div>
  </article>
</main>

<?php get_footer(); ?>
