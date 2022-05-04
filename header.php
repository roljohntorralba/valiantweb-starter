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
        <a href="<?php echo esc_url(home_url('/')) ?>" class="text-xl font-extrabold p-1 inline-block text-slate-700 hover:text-lime-500 dark:text-slate-200 dark:hover:text-lime-300"><?php bloginfo('name') ?></a>
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

  <?php if(is_singular()) : global $post; ?>
  <section id="hero" class="bg-slate-600 text-slate-100">
    <div class="container mx-auto py-32">
      <h1 class="text-6xl text-white font-extrabold text-center"><?php the_title() ?></h1>
      <div class="mx-auto mt-8 flex align-center justify-center text-lg text-slate-300 text-center">
        <span><?php the_modified_time( get_option( 'date_format' ) ); ?></span>
        <span class="mx-2">&middot;</span>
        <span><?php echo esc_html( get_the_author_meta( 'display_name', $post->post_author ) ) ?></span>
      </div>
    </div>
  </section>
  <?php endif ?>