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
