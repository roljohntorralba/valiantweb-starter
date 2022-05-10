<?php

/**
 * Get menu items as array
 * @source https://developer.wordpress.org/reference/functions/wp_get_nav_menu_items/#comment-1800
 */
function vws_get_menu_array($menu_location)
{
  $menu_locations = get_nav_menu_locations();
  $menu = array();
  if(isset($menu_locations[$menu_location])) {
    $menu_id = $menu_locations[$menu_location];
    $array_menu = wp_get_nav_menu_items($menu_id);
    foreach ($array_menu as $m) {
      if (empty($m->menu_item_parent)) {
        $menu[$m->ID] = array();
        $menu[$m->ID]['ID']      =   $m->ID;
        $menu[$m->ID]['title']       =   $m->title;
        $menu[$m->ID]['url']         =   $m->url;
        $menu[$m->ID]['children']    =   array();
      }
    }
    $submenu = array();
    foreach ($array_menu as $m) {
      if ($m->menu_item_parent) {
        $submenu[$m->ID] = array();
        $submenu[$m->ID]['ID']       =   $m->ID;
        $submenu[$m->ID]['title']    =   $m->title;
        $submenu[$m->ID]['url']  =   $m->url;
        $menu[$m->menu_item_parent]['children'][$m->ID] = $submenu[$m->ID];
      }
    }
  }
  return $menu;
}

/**
 * Shows a list of taxonomy
 */
function vws_show_tax($labels = true, $links = true, $label = 'Posted in', $taxonomy = 'category', $style = 'default') {
  $no_links_style = 'transition-colors flex py-1 px-1.5 mb-1 mr-1 rounded bg-neutral-400 font-semibold text-xs text-white';
  switch ($style) {
    case 'tags':
      $btn_style = 'transition-colors flex mb-1 mr-1 px-1.5 py-1 rounded bg-transparent font-semibold text-xs text-neutral-500 hover:bg-primary-500 hover:text-white hover:no-underline';
      break;
    default:
      $btn_style = 'transition-colors flex mb-1 mr-1 py-1 px-2 rounded bg-neutral-400 font-semibold text-xs text-white uppercase hover:bg-primary-500 hover:text-white hover:no-underline';
      break;
  }
  $terms = get_the_terms(get_the_ID(), $taxonomy);
  if ($terms) {
    printf('<div class="mb-2 text-sm text-neutral-500 flex flex-wrap items-baseline">');
    if($labels) {
      printf('<span class="mr-1">%s:</span>', ucfirst(esc_html($label)));
    }
    foreach ($terms as $term) {
      if($links) {
        printf('<a href="%s" class="%s">%s</a>', get_term_link($term, $taxonomy), $btn_style, $term->name);
      } else {
        printf('<span class="%s">%s</span>', $no_links_style, $term->name);
      }
    }
    printf('</div>');
  }
}