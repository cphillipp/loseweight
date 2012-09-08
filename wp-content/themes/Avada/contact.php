<?php
// Template Name: Contact
get_header(); ?>
<?php
//If the form is submitted
if(isset($_POST['submit'])) {
	//Check to make sure that the name field is not empty
	if(trim($_POST['contact_name']) == '' || trim($_POST['contact_name']) == 'Name (required)') {
		$hasError = true;
	} else {
		$name = trim($_POST['contact_name']);
	}

	//Check to make sure that the subject field is not empty
	if(trim($_POST['url']) == '' || trim($_POST['url']) == 'Subject (required)') {
		$hasError = true;
	} else {
		$subject = trim($_POST['url']);
	}

	//Check to make sure sure that a valid email address is submitted
	if(trim($_POST['email']) == '' || trim($_POST['email']) == 'Email (required)')  {
		$hasError = true;
	} else if (!eregi("^[A-Z0-9._%-]+@[A-Z0-9._%-]+\.[A-Z]{2,4}$", trim($_POST['email']))) {
		$hasError = true;
	} else {
		$email = trim($_POST['email']);
	}

	//Check to make sure comments were entered
	if(trim($_POST['comment']) == '' || trim($_POST['comment']) == 'Message') {
		$hasError = true;
	} else {
		if(function_exists('stripslashes')) {
			$comments = stripslashes(trim($_POST['comment']));
		} else {
			$comments = trim($_POST['comment']);
		}
	}

	//If there is no error, send the email
	if(!isset($hasError)) {
		$emailTo = get_post_meta($post->ID, 'pyre_email', true); //Put your own email address here
		$body = "Name: $name \n\nEmail: $email \n\nSubject: $subject \n\nComments:\n $comments";
		$headers = 'From: '.get_bloginfo('name').' <'.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $email;

		$mail = wp_mail($emailTo, $subject, $body, $headers);
		
		$emailSent = true;
	}
}
?>
	<?php if(is_page_template('contact.php') && get_post_meta($post->ID, 'pyre_gmap', true)): ?>
	<div id="gmap">
	</div>
	<?php endif; ?>
	<?php
	if(get_post_meta($post->ID, 'pyre_sidebar_position', true) == 'left') {
		$content_css = 'float:right;';
		$sidebar_css = 'float:left;';
	} else {
		$content_css = 'float:left;';
		$sidebar_css = 'float:right;';
	}
	?>
	<div id="content" style="<?php echo $content_css; ?>">
		<?php while(have_posts()): the_post(); ?>
			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="post-content">
				<?php the_content(); ?>
				
				<?php if(isset($hasError)) { //If errors are found ?>
					<p class="error"><?php _e("Please check if you've filled all the fields with valid information. Thank you.", 'Avada'); ?></p>
				<?php } ?>

				<?php if(isset($emailSent) && $emailSent == true) { //If email is sent ?>
					<p class="success-heading"><strong><?php _e('Email Successfully Sent!', 'Avada'); ?></strong></p>
					<p class="success"><?php _e('Thank you', 'Avada'); ?> <strong><?php echo $name;?></strong> <?php _e('for using my contact form! Your email was successfully sent and I will be in touch with you soon.', 'Avada'); ?></p>
				<?php } ?>
			</div>
			<form action="" method="post">
					
					<div id="comment-input">

						<input type="text" name="contact_name" id="author" value="<?php _e('Name (required)', 'Avada'); ?>" size="22" tabindex="1" aria-required="true" class="input-name">

						<input type="text" name="email" id="email" value="<?php _e('Email (required)', 'Avada'); ?>" size="22" tabindex="2" aria-required="true" class="input-email">
					
						<input type="text" name="url" id="url" value="<?php _e('Subject', 'Avada'); ?>" size="22" tabindex="3" class="input-website">
						
					</div>
					
					<div id="comment-textarea">
						
						<textarea name="comment" id="comment" cols="39" rows="4" tabindex="4" class="textarea-comment"><?php _e('Message', 'Avada'); ?></textarea>
					
					</div>
					
					<div id="comment-submit">

						<p><div><input name="submit" type="submit" id="submit" tabindex="5" value="<?php _e('Submit Form', 'Avada'); ?>" class="comment-submit button small green"></div></p>			
					</div>

			</form>
		</div>
		<?php endwhile; ?>
	</div>
	<div id="sidebar" style="<?php echo $sidebar_css; ?>"><?php generated_dynamic_sidebar(); ?></div>
<?php get_footer(); ?>