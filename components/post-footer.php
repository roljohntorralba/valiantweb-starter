<?php
$labels_flag = isset($args['labels']) ? ($args['labels'] ? true : false ): true;
$links_flag = isset($args['links']) ? ($args['links'] ? true : false) : true; 
// Show the categories.
if (isset($args['cats'])) {
  if ($args['cats']) {
    vws_show_tax($labels_flag, $links_flag);
  }
} else {
  vws_show_tax($labels_flag, $links_flag);
}

// Show the tags.
if (isset($args['tags'])) {
  if ($args['tags']) {
    vws_show_tax($labels_flag, $links_flag, 'tags', 'post_tag', 'tags');
  }
} else {
  vws_show_tax($labels_flag, $links_flag, 'tags', 'post_tag', 'tags');
}
?>