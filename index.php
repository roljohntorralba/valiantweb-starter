<?php get_header() ?>
<div class="container mx-auto mt-16 flex justify-around">
  <main class="mx-auto">
    <?php if (!is_singular()) : ?>
      <h1 class="text-4xl">Latest Posts</h1>
      <div class="grid grid-cols-2 gap-8 mt-8">
      <?php endif ?>
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
      <div class="mt-8 ml-[-8px] text-sm text-slate-500 nav-links-container">
        <?php
        if (!is_singular()) {
          the_posts_pagination();
        }
        ?>
      </div>
    <?php endif; ?>
    <?php if (comments_open() || get_comments_number()) : ?>
      <div class="mt-8">
        <?php comments_template(); ?>
      </div>
    <?php endif; ?>
  </main>
  <?php get_sidebar() ?>
</div>
<?php get_footer() ?>