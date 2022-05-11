<article class="prose prose-slate prose-img:shadow-lg prose-img:shadow-slate-500/30 prose-headings:font-serif dark:prose-invert lg:prose-lg prose-a:text-primary-500 hover:prose-a:text-primary-600 prose-blockquote:leading-normal">
  <header class="grid grid-cols-1 gap-4 mb-4 not-prose">
    <h1 class="text-4xl font-serif"><?php the_title() ?></h1>
    <?php if (function_exists('get_field') && get_field('leading_text')) : ?>
      <p class="text-neutral-600/70 leading-snug text-xl"><?php the_field('leading_text') ?></p>
    <?php endif; ?>
    <?php get_template_part('components/post-meta') ?>
  </header>
  <div>
    <?php the_content() ?>
  </div>
  <?php if(get_post_type() == 'post'): ?>
  <footer class="not-prose">
    <?php get_template_part('components/post-footer') ?>
  </footer>
  <?php endif; ?>
</article>