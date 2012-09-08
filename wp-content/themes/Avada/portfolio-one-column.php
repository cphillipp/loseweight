<?php
// Template Name: Portfolio One Column
get_header(); ?>
	<div id="content" class="full-width portfolio portfolio-one">
		<?php
		$portfolio_category = get_terms('portfolio_category');
		if($portfolio_category):
		?>
		<ul class="portfolio-tabs clearfix">
			<li class="active"><a data-filter="*" href="#"><?php _e('All', 'Avada'); ?></a></li>
			<?php foreach($portfolio_category as $portfolio_cat): ?>
			<li><a data-filter=".<?php echo $portfolio_cat->slug; ?>" href="#"><?php echo $portfolio_cat->name; ?></a></li>
			<?php endforeach; ?>
		</ul>
		<?php endif; ?>
		<div class="portfolio-wrapper">
			<?php
			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
			$args = array(
				'post_type' => 'avada_portfolio',
				'paged' => $paged,
				'posts_per_page' => of_get_option('portfolio_items', '10'),
			);
			$gallery = new WP_Query($args);
			while($gallery->have_posts()): $gallery->the_post();
				if(has_post_thumbnail() || get_post_meta($post->ID, 'pyre_video', true)):
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
				<?php if(has_post_thumbnail()): ?>
				<div class="image">
					<a href="<?php the_permalink(); ?>">
						<?php the_post_thumbnail('portfolio-one'); ?>
					</a>
					<div class="image-extras">
						<div class="image-extras-content">
							<?php $full_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full'); ?>
							<a class="icon" href="<?php the_permalink(); ?>"><img src="<?php bloginfo('template_directory'); ?>/images/link-ico.png" alt="<?php the_title(); ?>"/></a>
							<a class="icon" href="<?php echo $full_image[0]; ?>" rel="prettyPhoto['gallery']"><img src="<?php bloginfo('template_directory'); ?>/images/finder-ico.png" alt="<?php the_title(); ?>" /></a>
							<h3><?php the_title(); ?></h3>
						</div>
					</div>
				</div>
				<?php elseif(!has_post_thumbnail() && get_post_meta($post->ID, 'pyre_video', true)): ?>
				<div class="image video">
					<?php echo get_post_meta($post->ID, 'pyre_video', true); ?>
				</div>
				<?php endif; ?>
				<div class="portfolio-content">
					<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<h4><?php echo get_the_term_list($post->ID, 'portfolio_category', '', ', ', ''); ?></h4>
					<?php the_excerpt(); ?>
					<div class="buttons">
						<a href="<?php the_permalink(); ?>" class="green button small"><?php _e('Learn More', 'Avada'); ?></a>
						<?php if(get_post_meta($post->ID, 'pyre_project_url', true)): ?>
						<a href="<?php echo get_post_meta($post->ID, 'pyre_project_url', true); ?>" class="green button small"><?php _e('View Project', 'Avada'); ?></a>
						<?php endif; ?>
					</div>
				</div>
			</div>
			<?php endif; endwhile; ?>
		</div>
		<?php kriesi_pagination($gallery->max_num_pages, $range = 2); ?>
	</div>
<?php get_footer(); ?>