<?php
// Do not delete these lines
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if ( post_password_required() ) { ?>
		<p class="no-comments"><?php _e('This post is password protected. Enter the password to view comments.', 'Avada'); ?></p>
	<?php
		return;
	}
?>
	
<!-- You can start editing here. -->

<?php if ( have_comments() ) : ?>

	<div class="comments-container">
		<div class="title"><h2><?php comments_number(__('No Comments', 'Avada'), __('One Comment', 'Avada'), __('% Comments', 'Avada'));?></h2></div>
		
		<ol class="commentlist">
			<?php wp_list_comments('type=comment&callback=avada_comment'); ?>
		</ol>
		
		<div class="comments-navigation">
		    <div class="alignleft"><?php previous_comments_link(); ?></div>
		    <div class="alignright"><?php next_comments_link(); ?></div>
		</div>
	</div>

<?php else : // this is displayed if there are no comments so far ?>

	<?php if ( comments_open() ) : ?>
		<!-- If comments are open, but there are no comments. -->

	 <?php else : // comments are closed ?>
		<!-- If comments are closed. -->
		<p class="no-comments"><?php _e('Comments are closed.', 'Avada'); ?></p>

	<?php endif; ?>

<?php endif; ?>

<?php if ( comments_open() ) : ?>

<div id="respond" class="section">
	<div>
	<div class="title"><h2><?php comment_form_title(__('Leave A Comment', 'Avada'), __('Leave A Comment', 'Avada')); ?></h2></div>
	<div>

	<div><p class="cancel-comment-reply"><?php cancel_comment_reply_link(); ?></p></div>

	<?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
	<p>You must be <a href="<?php echo wp_login_url( get_permalink() ); ?>">logged in</a> to post a comment.</p>
	<?php else : ?>

	<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post">

		<?php if ( is_user_logged_in() ) : ?>

		<p><?php _e('Logged in as', 'Avada'); ?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="Log out of this account"><?php _e('Log out &raquo;', 'Avada'); ?></a></p>

		<div id="comment-textarea">
			
			<textarea name="comment" id="comment" cols="39" rows="4" tabindex="4" class="textarea-comment"></textarea>
		
		</div>
		
		<div id="comment-submit">
		
			<p><div class=""><input name="submit" type="submit" id="submit" tabindex="5" value="<?php _e('Post Comment', 'Avada'); ?>" class="comment-submit  small button green" /></div></p>
			<?php comment_id_fields(); ?>
			<?php do_action('comment_form', $post->ID); ?>
			
		</div>
		
		<?php else : ?>

		<div id="comment-input">

			<input type="text" name="author" id="author" value="<?php _e('Name (required)', 'Avada'); ?>" size="22" tabindex="1" <?php if ($req) echo "aria-required='true'"; ?> class="input-name" />

			<input type="text" name="email" id="email" value="<?php _e('Email (required)', 'Avada'); ?>" size="22" tabindex="2" <?php if ($req) echo "aria-required='true'"; ?> class="input-email"  />
		
			<input type="text" name="url" id="url" value="<?php _e('Website', 'Avada'); ?>" size="22" tabindex="3" class="input-website" />
			
		</div>
		
		<div id="comment-textarea">
			
			<textarea name="comment" id="comment" cols="39" rows="4" tabindex="4" class="textarea-comment"><?php _e('Comment...', 'Avada'); ?></textarea>
		
		</div>
		
		<div id="comment-submit">
		
			<p><div><input name="submit" type="submit" id="submit" tabindex="5" value="<?php _e('Post Comment', 'Avada'); ?>" class="comment-submit small button green" /></div></p>
			<?php comment_id_fields(); ?>
			<?php do_action('comment_form', $post->ID); ?>
			
		</div>

		<?php endif; ?>

	</form>

	<?php endif; // If registration required and not logged in ?>
	</div>
	</div>
</div>

<?php endif; // if you delete this the sky will fall on your head ?>