<?php

namespace ValiantWeb;

/**
 * Custom nvagiation walker class.
 */
class Nav_Walker extends \Walker_Nav_Menu
{
  /**
   * Starts the list before the elements are added.
   *
   * @since 3.0.0
   *
   * @see Walker::start_lvl()
   *
   * @param string   $output Used to append additional content (passed by reference).
   * @param int      $depth  Depth of menu item. Used for padding.
   * @param stdClass $args   An object of wp_nav_menu() arguments.
   */
  public function start_lvl(&$output, $depth = 0, $args = null)
  {
    if (isset($args->item_spacing) && 'discard' === $args->item_spacing) {
      $t = '';
      $n = '';
    } else {
      $t = "\t";
      $n = "\n";
    }
    $indent = str_repeat($t, $depth);

    // Default class.
    $base_menu_class = 'lg:bg-neutral-300 lg:shadow-xl lg:shadow-neutral-300/30 lg:group-hover:block lg:hidden lg:absolute lg:top-full';
    $right_align_class = $base_menu_class . ' lg:right-0';
    $left_align_class = $base_menu_class . ' lg:left-0';
    $center_align_class = $base_menu_class . ' lg:left-1/2 lg:-translate-x-1/2 z-20';
    $classes = array('sub-menu', $right_align_class);

    /**
     * Filters the CSS class(es) applied to a menu list element.
     *
     * @since 4.8.0
     *
     * @param string[] $classes Array of the CSS classes that are applied to the menu `<ul>` element.
     * @param stdClass $args    An object of `wp_nav_menu()` arguments.
     * @param int      $depth   Depth of menu item. Used for padding.
     */
    $class_names = implode(' ', apply_filters('nav_menu_submenu_css_class', $classes, $args, $depth));
    $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

    $output .= "{$n}{$indent}<ul$class_names>{$n}";
  }

  /**
   * Starts the element output.
   *
   * @since 3.0.0
   * @since 4.4.0 The {@see 'nav_menu_item_args'} filter was added.
   * @since 5.9.0 Renamed `$item` to `$data_object` and `$id` to `$current_object_id`
   *              to match parent class for PHP 8 named parameter support.
   *
   * @see Walker::start_el()
   *
   * @param string   $output            Used to append additional content (passed by reference).
   * @param WP_Post  $data_object       Menu item data object.
   * @param int      $depth             Depth of menu item. Used for padding.
   * @param stdClass $args              An object of wp_nav_menu() arguments.
   * @param int      $current_object_id Optional. ID of the current menu item. Default 0.
   */
  public function start_el(&$output, $data_object, $depth = 0, $args = null, $current_object_id = 0)
  {
    // Restores the more descriptive, specific name for use within this method.
    $menu_item = $data_object;
    $link_base_class = 'inline-block px-4 py-6 text-neutral-700 flex items-center';
    $link_group_class = $link_base_class . ' group-hover:text-neutral-700 group-hover:bg-neutral-300 group-hover:no-underline';
    $link_single_class = $link_base_class . ' hover:text-neutral-700 hover:bg-neutral-300 hover:no-underline';

    if (isset($args->item_spacing) && 'discard' === $args->item_spacing) {
      $t = '';
      $n = '';
    } else {
      $t = "\t";
      $n = "\n";
    }
    $indent = ($depth) ? str_repeat($t, $depth) : '';

    $classes   = empty($menu_item->classes) ? array() : (array) $menu_item->classes;
    $classes[] = 'menu-item-' . $menu_item->ID;

    // If menu item is a parent.
    $is_parent = in_array('menu-item-has-children', $classes);

    if ($is_parent) {
      $classes[] = 'group relative';
    }

    /**
     * Filters the arguments for a single nav menu item.
     *
     * @since 4.4.0
     *
     * @param stdClass $args      An object of wp_nav_menu() arguments.
     * @param WP_Post  $menu_item Menu item data object.
     * @param int      $depth     Depth of menu item. Used for padding.
     */
    $args = apply_filters('nav_menu_item_args', $args, $menu_item, $depth);

    /**
     * Filters the CSS classes applied to a menu item's list item element.
     *
     * @since 3.0.0
     * @since 4.1.0 The `$depth` parameter was added.
     *
     * @param string[] $classes   Array of the CSS classes that are applied to the menu item's `<li>` element.
     * @param WP_Post  $menu_item The current menu item object.
     * @param stdClass $args      An object of wp_nav_menu() arguments.
     * @param int      $depth     Depth of menu item. Used for padding.
     */
    $class_names = implode(' ', apply_filters('nav_menu_css_class', array_filter($classes), $menu_item, $args, $depth));
    $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

    /**
     * Filters the ID applied to a menu item's list item element.
     *
     * @since 3.0.1
     * @since 4.1.0 The `$depth` parameter was added.
     *
     * @param string   $menu_id   The ID that is applied to the menu item's `<li>` element.
     * @param WP_Post  $menu_item The current menu item.
     * @param stdClass $args      An object of wp_nav_menu() arguments.
     * @param int      $depth     Depth of menu item. Used for padding.
     */
    $id = apply_filters('nav_menu_item_id', 'menu-item-' . $menu_item->ID, $menu_item, $args, $depth);
    $id = $id ? ' id="' . esc_attr($id) . '"' : '';

    $output .= $indent . '<li' . $id . $class_names . '>';

    $atts           = array();
    $atts['title']  = !empty($menu_item->attr_title) ? $menu_item->attr_title : '';
    $atts['target'] = !empty($menu_item->target) ? $menu_item->target : '';
    if ('_blank' === $menu_item->target && empty($menu_item->xfn)) {
      $atts['rel'] = 'noopener';
    } else {
      $atts['rel'] = $menu_item->xfn;
    }
    $atts['href']         = !empty($menu_item->url) ? $menu_item->url : '';
    $atts['aria-current'] = $menu_item->current ? 'page' : '';
    if($is_parent) {
      $atts['class']        = $link_group_class;
    } else {
      $atts['class']        = $link_single_class;
    }

    /**
     * Filters the HTML attributes applied to a menu item's anchor element.
     *
     * @since 3.6.0
     * @since 4.1.0 The `$depth` parameter was added.
     *
     * @param array $atts {
     *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
     *
     *     @type string $title        Title attribute.
     *     @type string $target       Target attribute.
     *     @type string $rel          The rel attribute.
     *     @type string $href         The href attribute.
     *     @type string $aria-current The aria-current attribute.
     *     @type string $class        The class attribute.
     * }
     * @param WP_Post  $menu_item The current menu item object.
     * @param stdClass $args      An object of wp_nav_menu() arguments.
     * @param int      $depth     Depth of menu item. Used for padding.
     */
    $atts = apply_filters('nav_menu_link_attributes', $atts, $menu_item, $args, $depth);

    $attributes = '';
    foreach ($atts as $attr => $value) {
      if (is_scalar($value) && '' !== $value && false !== $value) {
        $value       = ('href' === $attr) ? esc_url($value) : esc_attr($value);
        $attributes .= ' ' . $attr . '="' . $value . '"';
      }
    }

    /** This filter is documented in wp-includes/post-template.php */
    $title = apply_filters('the_title', $menu_item->title, $menu_item->ID);

    /**
     * Filters a menu item's title.
     *
     * @since 4.4.0
     *
     * @param string   $title     The menu item's title.
     * @param WP_Post  $menu_item The current menu item object.
     * @param stdClass $args      An object of wp_nav_menu() arguments.
     * @param int      $depth     Depth of menu item. Used for padding.
     */
    $title = apply_filters('nav_menu_item_title', $title, $menu_item, $args, $depth);

    $item_output  = $args->before;
    $item_output .= '<a' . $attributes . '>';
    $item_output .= $args->link_before . $title . $args->link_after;
    if ($is_parent) {
      // Add chevron down icon.
      $item_output .= '<svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-5 w-5 text-neutral-400 group-hover:text-neutral-500 hidden lg:block" viewBox="0 0 20 20" fill="currentColor">
      <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
    </svg>';
    }
    $item_output .= '</a>';
    $item_output .= $args->after;

    /**
     * Filters a menu item's starting output.
     *
     * The menu item's starting output only includes `$args->before`, the opening `<a>`,
     * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
     * no filter for modifying the opening and closing `<li>` for a menu item.
     *
     * @since 3.0.0
     *
     * @param string   $item_output The menu item's starting HTML output.
     * @param WP_Post  $menu_item   Menu item data object.
     * @param int      $depth       Depth of menu item. Used for padding.
     * @param stdClass $args        An object of wp_nav_menu() arguments.
     */
    $output .= apply_filters('walker_nav_menu_start_el', $item_output, $menu_item, $depth, $args);
  }
}
