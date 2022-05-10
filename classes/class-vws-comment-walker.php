<?php

/**
 * Custom comment walker class.
 */
class VWS_Comment_Walker extends Walker_Comment
{
  /**
   * Starts the list before the elements are added.
   *
   * @since 2.7.0
   *
   * @see Walker::start_lvl()
   * @global int $comment_depth
   *
   * @param string $output Used to append additional content (passed by reference).
   * @param int    $depth  Optional. Depth of the current comment. Default 0.
   * @param array  $args   Optional. Uses 'style' argument for type of HTML list. Default empty array.
   */
  public function start_lvl(&$output, $depth = 0, $args = array())
  {
    $GLOBALS['comment_depth'] = $depth + 1;

    switch ($args['style']) {
      case 'div':
        break;
      case 'ol':
        $output .= '<ol class="children ml-8">' . "\n";
        break;
      case 'ul':
      default:
        $output .= '<ul class="children ml-8">' . "\n";
        break;
    }
  }

  /**
   * Outputs a comment in the HTML5 format.
   *
   * @since 3.6.0
   *
   * @see wp_list_comments()
   *
   * @param WP_Comment $comment Comment to display.
   * @param int        $depth   Depth of the current comment.
   * @param array      $args    An array of arguments.
   */
  protected function html5_comment($comment, $depth, $args)
  {
    $tag = ('div' === $args['style']) ? 'div' : 'li';

    $commenter          = wp_get_current_commenter();
    $show_pending_links = !empty($commenter['comment_author']);

    if ($commenter['comment_author_email']) {
      $moderation_note = __('Your comment is awaiting moderation.');
    } else {
      $moderation_note = __('Your comment is awaiting moderation. This is a preview; your comment will be visible after it has been approved.');
    }
?>
    <<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class($this->has_children ? 'parent' : '', $comment); ?>>
      <article id="div-comment-<?php comment_ID(); ?>" class="comment-body bg-white px-6 py-4 rounded shadow-xl shadow-slate-400/10 ring-1 ring-slate-200 mb-4 text-slate-600">
        <footer class="comment-meta">
          <div class="flex items-center">
            <div class="comment-avatar vcard mr-4">
              <?php
              if (0 != $args['avatar_size']) {
                echo get_avatar($comment, $args['avatar_size'], '', '', ['class' => 'rounded bg-primary-300']);
              }
              ?>
            </div>

            <div class="comment-author-metadata flex flex-col text-sm">
              <?php
              $comment_author = get_comment_author_link($comment);

              if ('0' == $comment->comment_approved && !$show_pending_links) {
                $comment_author = get_comment_author($comment);
              }

              printf('<span class="fn font-semibold">%s</span>', $comment_author);
              ?>
              <?php
              printf(
                '<a href="%s" class="text-slate-600"><time datetime="%s">%s</time></a>',
                esc_url(get_comment_link($comment, $args)),
                get_comment_time('c'),
                sprintf(
                  /* translators: 1: Comment date, 2: Comment time. */
                  __('%1$s at %2$s'),
                  get_comment_date('', $comment),
                  get_comment_time()
                )
              );
              ?>
            </div><!-- .comment-author-metadata -->
          </div>

          <?php if ('0' == $comment->comment_approved) : ?>
            <div class="my-4 text-xs py-1 px-2 bg-orange-100 text-orange-400 ring-1 ring-orange-300  rounded-sm">
              <em class="comment-awaiting-moderation"><?php echo $moderation_note; ?></em>
            </div>
          <?php endif; ?>

        </footer><!-- .comment-meta -->

        <div class="comment-content mt-4 prose-sm prose-p:my-2 prose-p:text-base prose-p:leading-snug">
          <?php comment_text(); ?>
        </div><!-- .comment-content -->

        <div class="mt-4 flex items-center justify-between">
          <?php
          if ('1' == $comment->comment_approved || $show_pending_links) {
            comment_reply_link(
              array_merge(
                $args,
                array(
                  'add_below' => 'div-comment',
                  'depth'     => $depth,
                  'max_depth' => $args['max_depth'],
                  'before'    => '<div class="reply font-semibold hover:underline flex">',
                  'after'     => '</div>',
                )
              )
            );
          }
          ?>
          <?php edit_comment_link(__('Edit'), ' <span class="edit-link text-sm">', '</span>'); ?>
        </div>
      </article><!-- .comment-body -->
  <?php
  }
}
