<?php
// Template Name: FAQs
get_header(); ?>
	<div id="content" class="faqs">
		<?php
		$portfolio_category = get_terms('faq_category');
		if($portfolio_category):
		?>
		<ul class="faq-tabs clearfix">
			<li class="active"><a data-filter="*" href="#"><?php _e('All', 'Avada'); ?></a></li>
			<?php foreach($portfolio_category as $portfolio_cat): ?>
			<li><a data-filter=".<?php echo $portfolio_cat->slug; ?>" href="#"><?php echo $portfolio_cat->name; ?></a></li>
			<?php endforeach; ?>
		</ul>
		<?php endif; ?>
		<div class="portfolio-wrapper">
			<?php
			$args = array(
				'post_type' => 'avada_faq',
				'nopaging' => true
			);
			$gallery = new WP_Query($args);
			while($gallery->have_posts()): $gallery->the_post();
			?>
			<?php
			$item_classes = '';
			$item_cats = get_the_terms($post->ID, 'faq_category');
			if($item_cats):
			foreach($item_cats as $item_cat) {
				$item_classes .= $item_cat->slug . ' ';
			}
			endif;
			?>
			<div class="faq-item <?php echo $item_classes; ?>">
				<h5 class="toggle"><a href="#"><span class="arrow"></span><span class="toggle-title"><?php the_title(); ?></span></a></h5>
				<div class="toggle-content">
					<?php the_content(); ?>
				</div>
			</div>
			<?php endwhile; ?>
		</div>
	</div>
	<div id="sidebar"><?php generated_dynamic_sidebar(); ?></div>
<?php get_footer(); ?>