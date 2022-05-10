<?php
if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>
<aside class="w-80 shrink-0 ml-8" role="sidebar">
  <?php dynamic_sidebar('sidebar-1') ?>
</aside>