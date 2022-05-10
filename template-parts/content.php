<a href="<?php the_permalink() ?>" class="block bg-white transition-all hover:no-underline hover:rotate-1 hover:-translate-y-2 hover:scale-105 hover:bg-gradient-to-br from-white to-slate-100 rounded-2xl shadow-xl shadow-slate-300/50 group">
  <div class="aspect-w-8 aspect-h-4">
    <?php echo get_the_post_thumbnail(null, 'medium', ['class' => 'object-cover rounded-t-2xl']) ?>
  </div>
  <article class="text-slate-500 px-6 pt-6 pb-8">
    <header class="grid grid-cols-1 gap-2 mb-2">
      <?php the_title('<h2 class="text-2xl leading-tight">', '</h2>') ?>
      <?php get_template_part('components/post-meta', null, ['avatar' => false]) ?>
    </header>
    <div class="line-clamp-5">
      <?php the_excerpt() ?>
    </div>
    <?php if (get_post_type() == 'post') : ?>
      <footer class="not-prose mt-4">
        <?php get_template_part('components/post-footer', null, ['tags' => false, 'labels' => false, 'links' => false]) ?>
      </footer>
    <?php endif; ?>
  </article>
</a>