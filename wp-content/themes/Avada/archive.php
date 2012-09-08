<?php get_header(); ?>
	<?php
	if(of_get_option('sidebar_position', 'right') == 'left') {
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
			<?php if(of_get_option('blog_style', 'large') == 'large'): ?>
			<?php
			$args = array(
			    'post_type' => 'attachment',
			    'numberposts' => '5',
			    'post_status' => null,
			    'post_parent' => $post->ID,
				'orderby' => 'menu_order',
				'order' => 'ASC',
				'exclude' => get_post_thumbnail_id()
			);
			$attachments = get_posts($args);
			if($attachments || has_post_thumbnail() || get_post_meta(get_the_ID(), 'pyre_video', true)):
			?>
			<div class="flexslider post-slideshow">
				<ul class="slides">
					<?php if(get_post_meta(get_the_ID(), 'pyre_video', true)): ?>
					<li class="video">
						<?php echo get_post_meta(get_the_ID(), 'pyre_video', true); ?>
					</li>
					<?php endif; ?>
					<?php if(has_post_thumbnail()): ?>
					<?php $full_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); ?>
					<?php $attachment_data = wp_get_attachment_metadata(get_post_thumbnail_id()); ?>
					<li>
						<div class="image">
							<a href="<?php the_permalink(); ?>">
								<?php the_post_thumbnail('blog-large'); ?>
								<?php if(count($attachments) == 0): ?>
								<div class="image-extras">
									<div class="image-extras-content">
										<img src="<?php bloginfo('template_directory'); ?>/images/link-ico.png" alt="<?php the_title(); ?>"/>
										<h3><?php the_title(); ?><h3>
									</div>
								</div>
								<?php endif; ?>
							</a>
						</div>
					</li>
					<?php endif; ?>
					<?php foreach($attachments as $attachment): ?>
					<?php $attachment_image = wp_get_attachment_image_src($attachment->ID, 'blog-large'); ?>
					<?php $full_image = wp_get_attachment_image_src($attachment->ID, 'full'); ?>
					<?php $attachment_data = wp_get_attachment_metadata($attachment->ID); ?>
					<li>
						<div class="image">
							<a href="<?php the_permalink(); ?>">
								<img src="<?php echo $attachment_image[0]; ?>" alt="<?php echo $attachment->post_title; ?>" />
								<?php if(count($attachments) == 0): ?>
								<div class="image-extras">
									<div class="image-extras-content">
										<img src="<?php bloginfo('template_directory'); ?>/images/link-ico.png" alt="<?php the_title(); ?>"/>
										<h3><?php the_title(); ?><h3>
									</div>
								</div>
								<?php endif; ?>
							</a>
						</div>
					</li>
					<?php endforeach; ?>
				</ul>
			</div>
			<?php endif; ?>
			<?php endif; ?>
			<?php if(of_get_option('blog_style', 'large') == 'medium'): ?>
			<?php
			$args = array(
			    'post_type' => 'attachment',
			    'numberposts' => '5',
			    'post_status' => null,
			    'post_parent' => $post->ID,
				'orderby' => 'menu_order',
				'order' => 'ASC',
				'exclude' => get_post_thumbnail_id()
			);
			$attachments = get_posts($args);
			if($attachments || has_post_thumbnail() || get_post_meta(get_the_ID(), 'pyre_video', true)):
			?>
			<div class="flexslider blog-medium-image floated-post-slideshow">
				<ul class="slides">
					<?php if(get_post_meta(get_the_ID(), 'pyre_video', true)): ?>
					<li class="video">
						<?php echo get_post_meta(get_the_ID(), 'pyre_video', true); ?>
					</li>
					<?php endif; ?>
					<?php if(has_post_thumbnail()): ?>
					<?php $full_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); ?>
					<?php $attachment_data = wp_get_attachment_metadata(get_post_thumbnail_id()); ?>
					<li>
						<div class="image">
							<a href="<?php the_permalink(); ?>">
								<?php the_post_thumbnail('blog-medium'); ?>
								<?php if(count($attachments) == 0): ?>
								<div class="image-extras">
									<div class="image-extras-content">
										<img src="<?php bloginfo('template_directory'); ?>/images/link-ico.png" alt="<?php the_title(); ?>"/>
										<h3><?php the_title(); ?></h3>
									</div>
								</div>
								<?php endif; ?>
							</a>
						</div>
					</li>
					<?php endif; ?>
					<?php foreach($attachments as $attachment): ?>
					<?php $attachment_image = wp_get_attachment_image_src($attachment->ID, 'blog-medium'); ?>
					<?php $full_image = wp_get_attachment_image_src($attachment->ID, 'full'); ?>
					<?php $attachment_data = wp_get_attachment_metadata($attachment->ID); ?>
					<li>
						<div class="image">
							<a href="<?php the_permalink(); ?>">
								<img src="<?php echo $attachment_image[0]; ?>" alt="<?php echo $attachment->post_title; ?>" />
								<?php if(count($attachments) == 0): ?>
								<div class="image-extras">
									<div class="image-extras-content">
										<img src="<?php bloginfo('template_directory'); ?>/images/link-ico.png" alt="<?php the_title(); ?>"/>
										<h3><?php the_title(); ?></h3>
									</div>
								</div>
								<?php endif; ?>
							</a>
						</div>
					</li>
					<?php endforeach; ?>
				</ul>
			</div>
			<?php endif; ?>
			<?php endif; ?>
			<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
			<div class="post-content">
				<?php the_content(''); ?>
			</div>
			<div class="meta-info">
				<div class="alignleft">
					By <?php the_author_posts_link(); ?><span class="sep">|</span><?php the_category(', '); ?><span class="sep">|</span><?php comments_popup_link('0 Comments', '1 Comment', '% Comments'); ?>
				</div>
				<div class="alignright">
					<a href="<?php the_permalink(); ?>" class="read-more"><?php _e('Read More', 'Avada'); ?></a>
				</div>
			</div>
		</div>
		<?php endwhile; ?>
		<?php kriesi_pagination($pages = '', $range = 2); ?>
	</div>
	<div id="sidebar" style="<?php echo $sidebar_css; ?>">
		<?php
		if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Blog Sidebar')): 
		endif;
		?>
	</div>
<?php get_footer(); ?>