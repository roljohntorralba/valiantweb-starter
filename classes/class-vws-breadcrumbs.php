<?php

namespace ValiantWeb;

use Spatie\SchemaOrg\Schema;

class Breadcrumbs
{
  private $start_el = '<ol class="flex items-center flex-wrap">';
  private $end_el = '</ol>';
  private $separator = '<span class="mx-2 text-xs opacity-30">/</span>';

  /**
   * Initiates the Schema\BreadcrumbList, crumbs array of Schema\ListItems, and the items stack.
   */
  public function __construct()
  {
    $this->breadcrumb_schema = Schema::breadcrumbList();
    $this->temp_crumbs = [
      (Schema::listItem()
        ->position(1)
        ->name(get_bloginfo('name'))
        ->item(get_home_url('/')))
    ];
  }

  /**
   * Adds a crumb to the breadcrumb trail.
   */
  public function add_item(string $name, string $url): void
  {
    $this->temp_crumbs[] = Schema::listItem()
      ->position(count($this->temp_crumbs) + 1)
      ->name($name)
      ->item($url);
  }

  /**
   * Autogenerates the breadcrumbs based on page heirarchy (pages) or post and its archive page (posts).
   */
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

    // If it's a single post, add the archive page as parent crumb.
    if (get_post_type() == 'post' && !is_home()) {
      $archive_url = get_post_type_archive_link('post');
      if ($archive_url !== get_home_url('/')) {
        $this->add_item(esc_html(ucfirst($blog_title)), $archive_url);
      }
    }

    // Blog posts page.
    if (is_home() && !is_front_page()) {
      $this->add_item(esc_html(ucfirst($blog_title)), get_the_permalink($ID));
    }

    // All other pages except front page (including home when set as latest posts in reading settings).
    if (!is_home() && !is_front_page()) {
      $title = get_the_title($ID);
      if (function_exists('get_field')) {
        $title = get_field('crumb_title', $ID) ? get_field('crumb_title', $ID) : get_the_title($ID);
      }
      $this->add_item(esc_html($title), get_the_permalink($ID));
    }
  }

  /**
   * Creates the HTML elements.
   */
  private function process_crumbs(): void
  {
    $output = '<div class="py-4 bg-slate-200 text-neutral-500 text-sm"><div class="container mx-auto">';
    $output .= $this->start_el;
    for ($i = 0; $i < count($this->temp_crumbs); $i++) {
      $item = $this->temp_crumbs[$i];
      if ($i >= count($this->temp_crumbs) - 1) {
        // Last item in the stack.
        $output .= sprintf('<li>%s</li>', $item->getProperty('name'));
      } else {
        $output .= sprintf('<li><a href="%s" class="text-neutral-400">%s</a></li>', $item->getProperty('item'), $item->getProperty('name'));
        $output .= $this->separator;
      }
    }
    $output .= $this->end_el;
    $output .= '</div></div>';
    printf('%s', $output);

    // Remove the last item's URL (item key).
    $this->temp_crumbs[count($this->temp_crumbs) - 1]
      ->offsetUnset('item');
    $this->breadcrumb_schema->itemListElement($this->temp_crumbs);
    echo $this->breadcrumb_schema->toScript(); 
  }

  /**
   * Renders the breadcrumbs.
   */
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
}
