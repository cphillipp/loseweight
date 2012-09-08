<?php get_header(); ?>
	<?php
	if(get_post_meta($post->ID, 'pyre_width', true) == 'half') {
		$portfolio_width = 'half';
	} else {
		$portfolio_width = 'full';
	}
	?>
	<div id="content" class="full-width portfolio-<?php echo $portfolio_width; ?>">
		<div class="single-navigation clearfix">
			<?php previous_post_link('%link', __('<span></span>Previous', 'Broadway')); ?>
			<?php next_post_link('%link', __('Next<span></span>', 'Broadway')); ?>
		</div>
		<?php while(have_posts()): the_post(); ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
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
			if($attachments || has_post_thumbnail() || get_post_meta($post->ID, 'pyre_video', true)):
			?>
			<div class="flexslider">
				<ul class="slides">
					<?php if(get_post_meta($post->ID, 'pyre_video', true)): ?>
					<li class="video">
						<?php echo get_post_meta($post->ID, 'pyre_video', true); ?>
					</li>
					<?php endif; ?>
					<?php if(has_post_thumbnail() && !get_post_meta($post->ID, 'pyre_video', true)): ?>
					<?php $attachment_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); ?>
					<?php $full_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); ?>
					<?php $attachment_data = wp_get_attachment_metadata(get_post_thumbnail_id()); ?>
					<li>
						<a href="<?php echo $full_image[0]; ?>" rel="prettyPhoto['gallery']"><img src="<?php echo $attachment_image[0]; ?>" alt="<?php echo $attachment->post_title; ?>" /></a>
					</li>
					<?php endif; ?>
					<?php foreach($attachments as $attachment): ?>
					<?php $attachment_image = wp_get_attachment_image_src($attachment->ID, 'full'); ?>
					<?php $full_image = wp_get_attachment_image_src($attachment->ID, 'full'); ?>
					<?php $attachment_data = wp_get_attachment_metadata($attachment->ID); ?>
					<li>
						<a href="<?php echo $full_image[0]; ?>" rel="prettyPhoto['gallery']"><img src="<?php echo $attachment_image[0]; ?>" alt="<?php echo $attachment->post_title; ?>" /></a>
					</li>
					<?php endforeach; ?>
				</ul>
			</div>
			<?php endif; ?>
			<div class="project-content">
				<div class="project-description">
					<h3><?php _e('Project Description', 'Avada'); ?></h3>
					<?php the_content(); ?>
				</div>
				<div class="project-info">
					<?php if(get_the_term_list($post->ID, 'portfolio_skills', '', '<br />', '')): ?>
					<h3><?php _e('Project Details', 'Avada'); ?></h3>
					<div class="project-info-box">
						<h4><?php _e('Skills Needed', 'Avada'); ?>:</h4>
						<div class="project-terms">
							<?php echo get_the_term_list($post->ID, 'portfolio_skills', '', '<br />', ''); ?>
						</div>
					</div>
					<?php endif; ?>
					<?php if(get_the_term_list($post->ID, 'portfolio_category', '', '<br />', '')): ?>
					<div class="project-info-box">
						<h4><?php _e('Categories', 'Avada'); ?>:</h4>
						<div class="project-terms">
							<?php echo get_the_term_list($post->ID, 'portfolio_category', '', '<br />', ''); ?>
						</div>
					</div>
					<?php endif; ?>
					<?php if(get_post_meta($post->ID, 'pyre_project_url', true) && get_post_meta($post->ID, 'pyre_project_url_text', true)): ?>
					<div class="project-info-box">
						<h4><?php _e('Project URL', 'Avada'); ?>:</h4>
						<span><a href="<?php echo get_post_meta($post->ID, 'pyre_project_url', true); ?>"><?php echo get_post_meta($post->ID, 'pyre_project_url_text', true); ?></a></span>
					</div>
					<?php endif; ?>
					<?php if(get_post_meta($post->ID, 'pyre_copy_url', true) && get_post_meta($post->ID, 'pyre_copy_url_text', true)): ?>
					<div class="project-info-box">
						<h4><?php _e('Copyright', 'Avada'); ?>:</h4>
						<span><a href="<?php echo get_post_meta($post->ID, 'pyre_copy_url', true); ?>"><?php echo get_post_meta($post->ID, 'pyre_copy_url_text', true); ?></a></span>
					</div>
					<?php endif; ?>
				</div>
			</div>
			<div style="clear:both;"></div>
			<?php $projects = get_related_projects($post->ID); ?>
			<?php if($projects->have_posts()): ?>
			<div class="related-posts related-projects">
				<div class="title"><h2><?php _e('Related Projects', 'Crucio'); ?></h2></div>
				<div id="carousel" class="es-carousel-wrapper">
					<div class="es-carousel">
						<ul>
							<?php while($projects->have_posts()): $projects->the_post(); ?>
							<?php if(has_post_thumbnail()): ?>
							<li>
								<div class="image">
									<a href="<?php the_permalink(); ?>">
										<?php the_post_thumbnail('related-img'); ?>
										<div class="image-extras">
											<div class="image-extras-content">
												<img src="<?php bloginfo('template_directory'); ?>/images/link-ico.png" alt="<?php the_title(); ?>"/>
												<h3><?php the_title(); ?></h3>
											</div>
										</div>
									</a>
								</div>
							</li>
							<?php endif; endwhile; ?>
						</ul>
					</div>
				</div>
			</div>
			<?php endif; ?>
		</div>
		<?php endwhile; ?>
	</div>
<?php get_footer(); ?>