<?php
/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */
if (post_password_required())
  return;

function vws_add_comment_author_link_class($comment_id) {
  $comment = get_comment( $comment_id );
  $url     = get_comment_author_url( $comment );
  $author  = get_comment_author( $comment );
  return "<a href='$url' rel='external nofollow ugc' class='url text-slate-600'>$author</a>";
}
add_filter('get_comment_author_link', 'vws_add_comment_author_link_class');
?>
<div class="bg-slate-200 border-t border-slate-300 mt-16 py-16">
  <div class="container mx-auto">
    <div id="comments" class="comments-area w-[707px] mx-auto">

      <?php if (have_comments()) : ?>
        <h2 class="text-2xl mb-6">
          <?php
          printf('Join the discussion &middot; %1$s comment%2$s', get_comments_number(), get_comments_number() == 1 ? '' : 's');
          ?>
        </h2>

        <ol class="list-none mb-8">
          <?php
          wp_list_comments(array(
            'walker'      => new \ValiantWeb\Comment_Walker(),
            'style'       => 'ol',
            'short_ping'  => true,
            'avatar_size' => 40,
          ));
          ?>
        </ol><!-- .comment-list -->

        <?php
        // Are there comments to navigate through?
        if (get_comment_pages_count() > 1 && get_option('page_comments')) :
        ?>
          <nav class="navigation comment-navigation" role="navigation">
            <h1 class="screen-reader-text section-heading"><?php _e('Comment navigation', 'twentythirteen'); ?></h1>
            <div class="nav-previous"><?php previous_comments_link(__('&larr; Older Comments', 'twentythirteen')); ?></div>
            <div class="nav-next"><?php next_comments_link(__('Newer Comments &rarr;', 'twentythirteen')); ?></div>
          </nav><!-- .comment-navigation -->
        <?php endif; // Check for comment navigation 
        ?>

        <?php if (!comments_open() && get_comments_number()) : ?>
          <p class="no-comments"><?php _e('Comments are closed.', 'twentythirteen'); ?></p>
        <?php endif; ?>

      <?php endif; // have_comments() 
      ?>

      <?php
      // Customize the comment form.
      $commenter     = wp_get_current_commenter();
      $user          = wp_get_current_user();
      $user_identity = $user->exists() ? $user->display_name : '';
      $req   = get_option('require_name_email');
      $required_attribute = ' required';
      $checked_attribute  = ' checked';
      $required_indicator = ' <span class="required" aria-hidden="true">*</span>';
      $comment_form_class = 'flex flex-col';
      $label_class = 'text-sm font-semibold text-slate-600 mb-2 cursor-pointer';
      // Website field disabled by default. Change the $fields['url'] value to $website_field below to enable it.
      $website_field = sprintf(
        '<p class="comment-form-url %s col-span-2">%s %s</p>',
        $comment_form_class,
        sprintf(
          '<label class="%s" for="url">%s</label>',
          $label_class,
          __('Website')
        ),
        sprintf(
          '<input id="url" class="form-input" name="url" type="url" value="%s" size="30" maxlength="200" />',
          esc_attr($commenter['comment_author_url'])
        )
        );
      $fields = array(
        'author' => sprintf(
          '<p class="comment-form-author %s">%s %s</p>',
          $comment_form_class,
          sprintf(
            '<label class="%s" for="author">%s%s</label>',
            $label_class,
            __('Name'),
            ($req ? $required_indicator : '')
          ),
          sprintf(
            '<input id="author" class="form-input" name="author" type="text" value="%s" size="30" maxlength="245"%s />',
            esc_attr($commenter['comment_author']),
            ($req ? $required_attribute : '')
          )
        ),
        'email'  => sprintf(
          '<p class="comment-form-email %s">%s %s</p>',
          $comment_form_class,
          sprintf(
            '<label class="%s" for="email">%s%s</label>',
            $label_class,
            __('Email'),
            ($req ? $required_indicator : '')
          ),
          sprintf(
            '<input id="email" class="form-input" name="email" type="email" value="%s" size="30" maxlength="100" aria-describedby="email-notes"%s />',
            esc_attr($commenter['comment_author_email']),
            ($req ? $required_attribute : '')
          )
        ),
        'url'    => '',
      );
      if (has_action('set_comment_cookies', 'wp_set_comment_cookies') && get_option('show_comments_cookies_opt_in')) {
        $consent = empty($commenter['comment_author_email']) ? '' : $checked_attribute;

        $fields['cookies'] = sprintf(
          '<p class="comment-form-cookies-consent flex items-center col-span-2 mt-2">%s %s</p>',
          sprintf(
            '<input id="wp-comment-cookies-consent" class="form-checkbox" name="wp-comment-cookies-consent" type="checkbox" value="yes"%s />',
            $consent
          ),
          sprintf(
            '<label class="text-sm ml-2 text-slate-500 cursor-pointer" for="wp-comment-cookies-consent">%s</label>',
            __('Save my name, email, and website in this browser for the next time I comment.')
          )
        );

      }
      $required_text = sprintf(
        ' <span class="required-field-message" aria-hidden="true">' . __('Required fields are marked %s') . '</span>',
        trim($required_indicator)
      );
      $comment_form_args = array(
        'fields'               => $fields,
        'comment_field'        => sprintf(
          '<p class="comment-form-comment %s col-span-2">%s %s</p>',
          $comment_form_class,
          sprintf(
            '<label class="%s" for="comment">%s%s</label>',
            $label_class,
            _x('Comment', 'noun'),
            $required_indicator
          ),
          '<textarea id="comment" class="form-textarea" name="comment" cols="45" rows="7" maxlength="65525"' . $required_attribute . '></textarea>'
        ),
        'must_log_in'          => sprintf(
          '<p class="must-log-in">%s</p>',
          sprintf(
            /* translators: %s: Login URL. */
            __('You must be <a href="%s">logged in</a> to post a comment.'),
            /** This filter is documented in wp-includes/link-template.php */
            wp_login_url()
          )
        ),
        'logged_in_as'         => sprintf(
          '<p class="logged-in-as text-slate-500 mb-2 col-span-2">%s%s</p>',
          sprintf(
            /* translators: 1: Edit user link, 2: Accessibility text, 3: User name, 4: Logout URL. */
            __('<a href="%1$s" class="text-slate-500" aria-label="%2$s">Logged in as %3$s</a>. <a href="%4$s" class="text-slate-500">Log out?</a>'),
            get_edit_user_link(),
            /* translators: %s: User name. */
            esc_attr(sprintf(__('Logged in as %s. Edit your profile.'), $user_identity)),
            $user_identity,
            /** This filter is documented in wp-includes/link-template.php */
            wp_logout_url()
          ),
          $required_text
        ),
        'comment_notes_before' => sprintf(
          '<p class="comment-notes text-slate-500 mb-2 col-span-2">%s%s</p>',
          sprintf(
            '<span id="email-notes">%s</span>',
            __('Your email address will not be published.')
          ),
          $required_text
        ),
        'comment_notes_after'  => '',
        'id_form'              => 'commentform',
        'id_submit'            => 'submit',
        'class_container'      => 'comment-respond',
        'class_form'           => 'comment-form grid grid-cols-2 gap-4',
        'class_submit'         => 'submit',
        'name_submit'          => 'submit',
        'title_reply'          => __('Leave a Reply'),
        'title_reply_to'       => __('Leave a Reply to %s'),
        'title_reply_before'   => '<h3 id="reply-title" class="comment-reply-title text-xl mb-2">',
        'title_reply_after'    => '</h3>',
        'cancel_reply_before'  => ' <small class="ml-4">',
        'cancel_reply_after'   => '</small>',
        'cancel_reply_link'    => __('Cancel reply'),
        'label_submit'         => __('Post Comment'),
        'submit_button'        => '<input name="%1$s" type="submit" id="%2$s" class="%3$s btn" value="%4$s" />',
        'submit_field'         => '<p class="form-submit mt-4">%1$s %2$s</p>',
      );
      comment_form($comment_form_args);
      ?>

    </div><!-- #comments -->
  </div>
</div>