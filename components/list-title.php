<?php if (is_archive()) : ?>
  <?php the_archive_title('<h1 class="text-4xl">', '</h1>'); ?>
<?php elseif (is_search()) : ?>
  <h1 class="text-4xl"><?php printf(esc_html('Search results for: %s'), '<span>' . get_search_query() . '</span>'); ?></h1>
<?php else : ?>
  <h1 class="text-4xl">Latest Posts</h1>
<?php endif; ?>