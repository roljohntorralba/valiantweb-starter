<!DOCTYPE html>
<html <?php language_attributes(); ?> class="scroll-smooth <?php printf('%s', is_user_logged_in() ? 'has-admin-bar' : '') ?>">

<head>

  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="profile" href="https://gmpg.org/xfn/11">

  <?php wp_head(); ?>

</head>

<body <?php body_class('bg-slate-100 dark:bg-slate-900 dark:text-slate-100'); ?>>
  <?php wp_body_open(); ?>

  <header id="site-header" class="bg-white/90 dark:bg-slate-900/80 backdrop-blur-md shadow-lg shadow-slate-300/10 z-10">
    <div class="container py-4 mx-auto transition-all">
      <nav class="flex items-center justify-between">
        <a href="<?php echo esc_url(home_url('/')) ?>" class="text-xl font-extrabold p-1 inline-block text-slate-600 dark:text-slate-200"><?php bloginfo('name') ?></a>
        <ul class="flex items-center">
          <?php
          wp_nav_menu(
            array(
              'container'  => '',
              'items_wrap' => '%3$s',
              'theme_location' => 'primary',
              'walker' => new VWS_Nav_Walker(),
            )
          );
          ?>
        </ul>
      </nav>
    </div>
  </header>

  <?php if(has_post_thumbnail() && is_singular()): ?>
    <div class="aspect-w-16 aspect-h-4">
      <?php echo get_the_post_thumbnail(null, 'post-thumbnail', ['class' => 'object-cover']) ?>
    </div>
  <?php endif; ?>