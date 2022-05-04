<a href="<?php the_permalink() ?>" class="block px-6 py-8 bg-white transition-all hover:rotate-1 hover:-translate-y-2 hover:scale-105 hover:bg-gradient-to-br from-white to-slate-100 rounded-2xl shadow-xl shadow-slate-300/50 group">
  <article class="text-slate-500 grid grid-cols-1 gap-4">
    <header class="grid grid-cols-1 gap-4">
      <?php the_title('<h2 class="text-2xl">', '</h2>') ?>
      <div class="flex text-sm text-slate-400">
        <span><?php the_modified_time( get_option( 'date_format' ) ); ?></span>
        <span class="mx-2">&middot;</span>
        <span><?php echo esc_html( get_the_author_meta( 'display_name' ) ) ?></span>
      </div>
    </header>
    <div class="leading-relaxed line-clamp-5">
      <?php the_excerpt() ?>
    </div>
  </article>
</a>