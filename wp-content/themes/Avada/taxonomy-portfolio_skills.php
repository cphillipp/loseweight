<?php
get_header(); ?>
	<div id="content" class="full-width portfolio portfolio-one">
		<div class="portfolio-wrapper">
			<?php
			while(have_posts()): the_post();
				if(has_post_thumbnail()):
			?>
			<?php
			$item_classes = '';
			$item_cats = get_the_terms($post->ID, 'portfolio_category');
			if($item_cats):
			foreach($item_cats as $item_cat) {
				$item_classes .= $item_cat->slug . ' ';
			}
			endif;
			?>
			<div class="portfolio-item <?php echo $item_classes; ?>">
				<div class="image">
					<a href="<?php the_permalink(); ?>">
						<?php the_post_thumbnail('portfolio-one'); ?>
					</a>
					<div class="image-extras">
						<div class="image-extras-content">
							<?php $full_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full'); ?>
							<a class="icon" href="<?php the_permalink(); ?>"><img src="<?php bloginfo('template_directory'); ?>/images/link-ico.png" alt="<?php the_title(); ?>"/></a>
							<a class="icon" href="<?php echo $full_image[0]; ?>" rel="prettyPhoto"><img src="<?php bloginfo('template_directory'); ?>/images/finder-ico.png" alt="<?php the_title(); ?>" /></a>
							<h3><?php the_title(); ?><h3>
						</div>
					</div>
				</div>
				<div class="portfolio-content">
					<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<h4><?php echo get_the_term_list($post->ID, 'portfolio_category', '', ', ', ''); ?></h4>
					<?php the_excerpt(); ?>
					<div class="buttons"></div>
				</div>
			</div>
			<?php endif; endwhile; ?>
		</div>
		<?php kriesi_pagination($gallery->max_num_pages, $range = 2); ?>
	</div>
<?php get_footer(); ?>