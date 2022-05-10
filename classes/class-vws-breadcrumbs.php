<?php

namespace ValiantWeb;

class Breadcrumbs
{
  private $start_el = '<ol class="flex items-center flex-wrap">';
  private $end_el = '</ol>';
  private $separator = '<span class="mx-2 text-xs opacity-30">/</span>';

  public function __construct(string $var = null)
  {
    $this->var = $var;
    $this->items_stack = [
      [
        'name'  => get_bloginfo('name'),
        'url'   => get_home_url('/')
      ]
    ];
  }

  public function add_item(string $name, string $url): void
  {
    $this->items_stack[] = [
      'name' => $name,
      'url' => $url
    ];
  }

  public function auto_generate(int $ID, string $blog_title = 'Blog'): void
  {
    // If it's a page, get parent pages.
    $ancestors = get_post_ancestors($ID);
    if (!empty($ancestors)) {
      foreach ($ancestors as $ancestor) {
        $parent = array_pop($ancestors);
        $title = get_the_title($parent);
        if (function_exists('get_field')) {
          $title = get_field('crumb_title', $parent) ? get_field('crumb_title', $parent) : get_the_title($parent);
        }
        $this->add_item(esc_html($title), get_the_permalink($parent));
      }
    }

    if (get_post_type() == 'post' && !is_home()) {
      // If it's a single post, add the archive page as parent crumb.
      $archive_url = get_post_type_archive_link('post');
      if ($archive_url !== get_home_url('/')) {
        $this->add_item(esc_html(ucfirst($blog_title)), $archive_url);
      }
    }

    if (is_home() && !is_front_page()) {
      // Blog posts page.
      $this->add_item(esc_html(ucfirst($blog_title)), get_the_permalink($ID));
    }
    if (!is_home() && !is_front_page()) {
      // All other pages except front page (including home when set as latest posts in reading settings).
      $title = get_the_title($ID);
      if (function_exists('get_field')) {
        $title = get_field('crumb_title', $ID) ? get_field('crumb_title', $ID) : get_the_title($ID);
      }
      $this->add_item(esc_html($title), get_the_permalink($ID));
    }
  }

  private function process_crumbs(): void
  {
    $output = '<div class="py-4 bg-slate-200 text-neutral-500 text-sm"><div class="container mx-auto">';
    $output .= $this->start_el;
    for ($i = 0; $i < count($this->items_stack); $i++) {
      $item = $this->items_stack[$i];
      if ($i >= count($this->items_stack) - 1) {
        // Last item in the stack.
        $output .= sprintf('<li>%s</li>', $item['name']);
      } else {
        $output .= sprintf('<li><a href="%s" class="text-neutral-400">%s</a></li>', $item['url'], $item['name']);
        $output .= $this->separator;
      }
    }
    $output .= $this->end_el;
    $output .= '</div></div>';
    printf('%s', $output);
  }

  public function display(): void
  {
    if (function_exists('get_field')) {
      if (!get_field('disable_breadcrumbs')) {
        $this->process_crumbs();
      }
    } else {
      $this->process_crumbs();
    }
  }

  public function show_string()
  {
    printf('%s', $this->var);
  }

  /**
   * Displays the custom breadcrumb.
   */
  public function display_breadcrumbs()
  {
    // Ensures ACF is active
    if (!function_exists('get_field')) {
      return;
    }

    $breadcrumbs_schema = array();
    $li_pattern = '<li><a href="%1$s">%2$s</a></li>';
    $li_pattern_last = '<li class="last-crumb">%s</li>';
    $position_ctr = 0;

    $country = get_field('location_country');
    $region = get_field('location_region');
    $city = get_field('location_city');
    $neighborhood = get_field('location_neighborhood');
    $post_title = get_the_title();
    $terms = get_the_terms(get_the_ID(), 'location_type');
    $current_term = $terms[0]->slug;

    // Add items to the breadcrumbs and increment index counter
    if ($country) {
      $url = get_the_permalink($country->ID);
      $title = get_the_title($country->ID);
      $breadcrumbs_schema[$position_ctr]['name'] = $title;
      $breadcrumbs_schema[$position_ctr]['item'] = $url;
      $position_ctr++;
    }
    if ($region) {
      $url = get_the_permalink($region->ID);
      $title = get_the_title($region->ID);
      $breadcrumbs_schema[$position_ctr]['name'] = $title;
      $breadcrumbs_schema[$position_ctr]['item'] = $url;
      $position_ctr++;
    }
    if ($city) {
      $url = get_the_permalink($city->ID);
      $title = get_the_title($city->ID);
      $breadcrumbs_schema[$position_ctr]['name'] = $title;
      $breadcrumbs_schema[$position_ctr]['item'] = $url;
      $position_ctr++;
    }
    if ($neighborhood) {
      $url = get_the_permalink($neighborhood->ID);
      $title = get_the_title($neighborhood->ID);
      $breadcrumbs_schema[$position_ctr]['name'] = $title;
      $breadcrumbs_schema[$position_ctr]['item'] = $url;
      $position_ctr++;
    }

    // Add the last breadcrumb item (current page) only if it's not a villa
    if ($current_term != 'villa') {
      $breadcrumbs_schema[$position_ctr]['name'] = $post_title;
    }

    $schema_count = count($breadcrumbs_schema);

    // Only print breadcrumbs if it has more than one items
    if ($schema_count > 1) {
      $breadcrumbs = '<ol class="breadcrumbs maj-breadcrumbs">';
      // not a country
      $loop_count = $schema_count;
      for ($i = 0; $i < $loop_count; $i++) {
        if ($i == $loop_count - 1 && $current_term != 'villa') {
          // Last crumb
          $breadcrumbs .= sprintf($li_pattern_last, $breadcrumbs_schema[$i]['name']);
        } else {
          $breadcrumbs .= sprintf($li_pattern, $breadcrumbs_schema[$i]['item'], $breadcrumbs_schema[$i]['name']);
        }
      }
      $breadcrumbs .= '</ol>';
      printf($breadcrumbs);
    }
  }
}
