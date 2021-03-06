<?php get_header() ?>
<div class="container mx-auto my-16 flex justify-around">
  <main class="mx-auto">
    <?php if (!is_singular()) : ?>
      <?php get_template_part('components/list-title') ?>
      <div class="grid grid-cols-2 gap-8 mt-8">
    <?php endif; ?>
    <?php
    if (have_posts()) {
      while (have_posts()) {
        the_post();
        if (is_singular()) {
          echo get_template_part('template-parts/content', 'singular');
        } else {
          echo get_template_part('template-parts/content');
        }
      }
    }
    ?>
    <?php if (!is_singular()) : ?>
      </div><!-- loop grid -->
      <div class="mt-8 text-sm text-slate-500 nav-links-container">
        <?php the_posts_pagination(); ?>
      </div>
    <?php endif; ?>
  </main>
  <?php get_sidebar() ?>
</div>

<?php if (comments_open() || get_comments_number()) {
  comments_template();
} ?>
<?php get_footer() ?>