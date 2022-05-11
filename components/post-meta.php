<div class="flex items-center text-sm text-slate-400">
  <?php if(isset($args['avatar'])) {
    if($args['avatar']) {
      echo get_avatar(get_the_ID(), 40, '', '', ['class' => 'rounded shadow mr-3']);
    }
  } else {
    echo get_avatar(get_the_ID(), 40, '', '', ['class' => 'rounded shadow mr-3']);
  }
  ?>
  <span><?php echo esc_html(get_the_author_meta('display_name', $post->post_author)) ?></span>
  <span class="mx-2">&middot;</span>
  <span><?php the_modified_time(get_option('date_format')); ?></span>
</div>