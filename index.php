<?php get_header() ?>

  <div>
    <main class="prose mx-auto">
      <?php
      if (have_posts()) {
        while (have_posts()) {
          the_post();

        }
      }
      ?>
    </main>
    <aside>
      sidebar
    </aside>
  </div>
<?php get_footer() ?>