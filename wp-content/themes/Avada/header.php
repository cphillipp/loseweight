<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1; maximum-scale=1" />
	
	<title><?php bloginfo('name'); ?> <?php wp_title(' - ', true, 'left'); ?></title>

	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" />
	<!--[if lt IE 9]>
	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/respond.min.js"></script>
	<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/ie.css" />
	<![endif]-->
	<?php if(of_get_option('responsiveness', 'yes') == 'yes'): ?>
	<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/media.css" />
	<?php endif; ?>

	<link href='http://fonts.googleapis.com/css?family=<?php echo urlencode(of_get_option('body_font', 'PT Sans')); ?>:400,400italic,700,700italic' rel='stylesheet' type='text/css' />

	<?php if(of_get_option('headings_font', 'Antic Slab') != 'museo'): ?>
	<link href='http://fonts.googleapis.com/css?family=<?php echo urlencode(of_get_option('headings_font', 'Antic Slab')); ?>:400,400italic,700,700italic' rel='stylesheet' type='text/css' />
	<?php endif; ?>

	<?php if(of_get_option('favicon')): ?>
	<link rel="shortcut icon" href="<?php echo of_get_option('favicon'); ?>" type="image/x-icon" />
	<?php endif; ?>

	<?php wp_enqueue_script('jquery'); ?>
	<?php wp_enqueue_script('jtwt', get_bloginfo('template_directory').'/js/jtwt.js'); ?>
	<?php wp_enqueue_script('jquery.elastislide', get_bloginfo('template_directory').'/js/jquery.elastislide.js'); ?>
	<?php wp_enqueue_script('jquery.prettyPhoto', get_bloginfo('template_directory').'/js/jquery.prettyPhoto.js'); ?>
	<?php wp_enqueue_script('jquery.isotope', get_bloginfo('template_directory').'/js/jquery.isotope.min.js'); ?>
	<?php wp_enqueue_script('jquery.flexslider', get_bloginfo('template_directory').'/js/jquery.flexslider-min.js'); ?>
	<?php wp_enqueue_script('jquery.cycle', get_bloginfo('template_directory').'/js/jquery.cycle.lite.js'); ?>
	<?php wp_enqueue_script('jquery.fitvids', get_bloginfo('template_directory').'/js/jquery.fitvids.js'); ?>
	<?php wp_enqueue_script('modernizr', get_bloginfo('template_directory').'/js/modernizr.js'); ?>
	<?php wp_enqueue_script('avada', get_bloginfo('template_directory').'/js/main.js'); ?>
	<?php wp_head(); ?>

	<script type="text/javascript">
	jQuery(document).ready(function($) {
		$('.flexslider').flexslider();

		$('.video, .wooslider .slide-content').fitVids();

		function onAfter(curr, next, opts, fwd) {
		  var $ht = $(this).height();

		  //set the container's height to that of the current slide
		  $(this).parent().animate({height: $ht});
		}

	    $('.reviews').cycle({
			fx: 'fade',
			after: onAfter,
			timeout: '<?php echo of_get_option('testimonials_speed', 4000); ?>'
		});
	});
	</script>

	<?php if(is_page_template('contact.php') && get_post_meta($post->ID, 'pyre_gmap', true)): ?>
	<script src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
	<script type="text/javascript">
	jQuery(document).ready(function() {
		var geocoder;
		var map;

		geocoder = new google.maps.Geocoder();
		var latlng = new google.maps.LatLng(-34.397, 150.644);
		var mapOptions = {
		zoom: 8,
		center: latlng,
		mapTypeId: google.maps.MapTypeId.ROADMAP
		}
		map = new google.maps.Map(document.getElementById('gmap'), mapOptions);

		var address = '<?php echo get_post_meta($post->ID, 'pyre_gmap', true); ?>';
		geocoder.geocode( { 'address': address}, function(results, status) {
		if (status == google.maps.GeocoderStatus.OK) {
		map.setCenter(results[0].geometry.location);
		var marker = new google.maps.Marker({
		map: map,
		position: results[0].geometry.location
		});
		} else {
		alert('Geocode was not successful for the following reason: ' + status);
		}
		});
	});
	</script>
	<?php endif; ?>

	<style type="text/css">
	<?php if(of_get_option('sidebar_position', 'right') == 'left'): ?>
	#sidebar{
		float:left;
	}
	#content{
		float:right;
	}
	<?php endif; ?>

	<?php if(of_get_option('primary_color', '#a0ce4e')): ?>
	a:hover,
	#nav ul .current_page_item a, #nav ul .current-menu-item a, #nav ul > .current-menu-parent a,
	.footer-area ul li a:hover,
	.side-nav li.current_page_item a,
	.portfolio-tabs li.active a, .faq-tabs li.active a,
	.project-content .project-info .project-info-box a:hover,
	.about-author .title a,
	span.dropcap{
		color:<?php echo of_get_option('primary_color', '#a0ce4e'); ?> !important;
	}
	#nav ul .current_page_item a, #nav ul .current-menu-item a, #nav ul > .current-menu-parent a,
	#nav ul ul,
	.reading-box,
	.side-nav li.current_page_item a,
	.portfolio-tabs li.active a, .faq-tabs li.active a,
	.tab-holder .tabs li.active a,
	.post-content blockquote,
	.progress-bar-content{
		border-color:<?php echo of_get_option('primary_color', '#a0ce4e'); ?> !important;
	}
	h5.toggle.active span.arrow,
	.post-content ul.arrow li::before,
	.progress-bar-content{
		background-color:<?php echo of_get_option('primary_color', '#a0ce4e'); ?> !important;
	}
	<?php endif; ?>

	<?php if(of_get_option('pricing_box_color', '#92C563')): ?>
	.sep-boxed-pricing ul li.title-row{
		background-color:<?php echo of_get_option('pricing_box_color', '#92C563'); ?> !important;
		border-color:<?php echo of_get_option('pricing_box_color', '#92C563'); ?> !important;
	}
	<?php endif; ?>
	<?php if(of_get_option('image_gradient_top_color', '#D1E990') && of_get_option('image_gradient_bottom_color', '#AAD75B')): ?>
	.image .image-extras{
		background-image: linear-gradient(top, <?php echo of_get_option('image_gradient_top_color', '#D1E990'); ?> 0%, <?php echo of_get_option('image_gradient_bottom_color', '#D1E990'); ?> 100%);
		background-image: -o-linear-gradient(top, <?php echo of_get_option('image_gradient_top_color', '#D1E990'); ?> 0%, <?php echo of_get_option('image_gradient_bottom_color', '#D1E990'); ?> 100%);
		background-image: -moz-linear-gradient(top, <?php echo of_get_option('image_gradient_top_color', '#D1E990'); ?> 0%, <?php echo of_get_option('image_gradient_bottom_color', '#D1E990'); ?> 100%);
		background-image: -webkit-linear-gradient(top, <?php echo of_get_option('image_gradient_top_color', '#D1E990'); ?> 0%, <?php echo of_get_option('image_gradient_bottom_color', '#D1E990'); ?> 100%);
		background-image: -ms-linear-gradient(top, <?php echo of_get_option('image_gradient_top_color', '#D1E990'); ?> 0%, <?php echo of_get_option('image_gradient_bottom_color', '#D1E990'); ?> 100%);

		background-image: -webkit-gradient(
			linear,
			left top,
			left bottom,
			color-stop(0, <?php echo of_get_option('image_gradient_top_color', '#D1E990'); ?>),
			color-stop(1, <?php echo of_get_option('image_gradient_bottom_color', '#D1E990'); ?>)
		);
	}
	.no-cssgradients .image .image-extras{
		background:<?php echo of_get_option('image_gradient_top_color', '#D1E990'); ?>;
	}
	<?php endif; ?>
	<?php if(of_get_option('button_gradient_top_color', '#D1E990') && of_get_option('button_gradient_bottom_color', '#AAD75B') && of_get_option('button_gradient_text_color', '#54770f')): ?>
	#main .reading-box .button,
	#main .continue.button,
	#main .portfolio-one .button,
	#main .comment-submit{
		color: <?php echo of_get_option('button_gradient_text_color', '#54770f'); ?> !important;
		background-image: linear-gradient(top, <?php echo of_get_option('button_gradient_top_color', '#D1E990'); ?> 0%, <?php echo of_get_option('button_gradient_bottom_color', '#D1E990'); ?> 100%);
		background-image: -o-linear-gradient(top, <?php echo of_get_option('button_gradient_top_color', '#D1E990'); ?> 0%, <?php echo of_get_option('button_gradient_bottom_color', '#D1E990'); ?> 100%);
		background-image: -moz-linear-gradient(top, <?php echo of_get_option('button_gradient_top_color', '#D1E990'); ?> 0%, <?php echo of_get_option('button_gradient_bottom_color', '#D1E990'); ?> 100%);
		background-image: -webkit-linear-gradient(top, <?php echo of_get_option('button_gradient_top_color', '#D1E990'); ?> 0%, <?php echo of_get_option('button_gradient_bottom_color', '#D1E990'); ?> 100%);
		background-image: -ms-linear-gradient(top, <?php echo of_get_option('button_gradient_top_color', '#D1E990'); ?> 0%, <?php echo of_get_option('button_gradient_bottom_color', '#D1E990'); ?> 100%);

		background-image: -webkit-gradient(
			linear,
			left top,
			left bottom,
			color-stop(0, <?php echo of_get_option('button_gradient_top_color', '#D1E990'); ?>),
			color-stop(1, <?php echo of_get_option('button_gradient_bottom_color', '#D1E990'); ?>)
		);
		border:1px solid <?php echo of_get_option('button_gradient_bottom_color', '#AAD75B'); ?>;
	}
	.no-cssgradients #main .reading-box .button,
	.no-cssgradients #main .continue.button,
	.no-cssgradients #main .portfolio-one .button,
	.no-cssgradients #main .comment-submit{
		background:<?php echo of_get_option('button_gradient_top_color', '#D1E990'); ?>;
	}
	#main .reading-box .button:hover,
	#main .continue.button:hover,
	#main .portfolio-one .button:hover,
	#main .comment-submit:hover{
		color: <?php echo of_get_option('button_gradient_text_color', '#54770f'); ?> !important;
		background-image: linear-gradient(top, <?php echo of_get_option('button_gradient_bottom_color', '#D1E990'); ?> 0%, <?php echo of_get_option('button_gradient_top_color', '#D1E990'); ?> 100%);
		background-image: -o-linear-gradient(top, <?php echo of_get_option('button_gradient_bottom_color', '#D1E990'); ?> 0%, <?php echo of_get_option('button_gradient_top_color', '#D1E990'); ?> 100%);
		background-image: -moz-linear-gradient(top, <?php echo of_get_option('button_gradient_bottom_color', '#D1E990'); ?> 0%, <?php echo of_get_option('button_gradient_top_color', '#D1E990'); ?> 100%);
		background-image: -webkit-linear-gradient(top, <?php echo of_get_option('button_gradient_bottom_color', '#D1E990'); ?> 0%, <?php echo of_get_option('button_gradient_top_color', '#D1E990'); ?> 100%);
		background-image: -ms-linear-gradient(top, <?php echo of_get_option('button_gradient_bottom_color', '#D1E990'); ?> 0%, <?php echo of_get_option('button_gradient_top_color', '#D1E990'); ?> 100%);

		background-image: -webkit-gradient(
			linear,
			left top,
			left bottom,
			color-stop(0, <?php echo of_get_option('button_gradient_bottom_color', '#D1E990'); ?>),
			color-stop(1, <?php echo of_get_option('button_gradient_top_color', '#D1E990'); ?>)
		);
		border:1px solid <?php echo of_get_option('button_gradient_bottom_color', '#AAD75B'); ?>;
	}
	.no-cssgradients #main .reading-box .button:hover,
	.no-cssgradients #main .continue.button:hover,
	.no-cssgradients #main .portfolio-one .button:hover,
	.no-cssgradients #main .comment-submit:hover{
		background:<?php echo of_get_option('button_gradient_bottom_color', '#D1E990'); ?>;
	}
	<?php endif; ?>

	<?php if(of_get_option('layout', 'wide') == 'boxed'): ?>
	body{
		background-color:<?php echo of_get_option('bg_color', '#d7d6d6'); ?>;
		<?php if(of_get_option('background')): ?>
		background-image:url(<?php echo of_get_option('background'); ?>);
		background-repeat:<?php echo of_get_option('background_repeat', 'repeat'); ?>;
		<?php elseif(of_get_option('pattern', 'pattern1')): ?>
		background-image:url("<?php echo get_bloginfo('template_directory') . '/images/patterns/' . of_get_option('pattern', 'pattern1') . '.png'; ?>");
		background-repeat:repeat;
		<?php endif; ?>
	}
	#wrapper{
		background:#fff;
		width:1000px;
		margin:0 auto;
	}
	#layerslider-container{
		overflow:hidden;
	}
	<?php endif; ?>

	<?php if(of_get_option('page_title_bg', get_bloginfo('template_directory') . "/images/page_title_bg.png")): ?>
	.page-title-container{
		background-image:url(<?php echo of_get_option('page_title_bg', get_bloginfo('template_directory') . "/images/page_title_bg.png"); ?>) !important;
	}
	<?php endif; ?>

	<?php if(of_get_option('body_font', 'PT Sans')): ?>
	body,#nav ul li ul li a,
	.more,
	.container h3,
	.meta .date,
	.review blockquote q,
	.review blockquote div strong,
	.footer-area  h3,
	.image .image-extras .image-extras-content h4,
	.project-content .project-info h4,
	.post-content blockquote,
	.button.large,
	.button.small{
		font-family:'<?php echo of_get_option('body_font'); ?>', Arial, Helvetica, sans-serif !important;
	}
	.container h3,
	.review blockquote div strong,
	.footer-area  h3,
	.button.large,
	.button.small{
		font-weight:bold;
	}
	.meta .date,
	.review blockquote q,
	.post-content blockquote{
		font-style:italic;
	}
	<?php endif; ?>
	<?php if(of_get_option('headings_font', 'Antic Slab') != 'museo'): ?>
	#nav,
	#main .reading-box h2,
	#main h2,
	.page-title h2,
	.image .image-extras .image-extras-content h3,
	#main .post h2,
	#sidebar .widget h3,
	.tab-holder .tabs li a,
	.share-box h4,
	.project-content h3,
	.side-nav li a,
	h5.toggle a,
	.full-boxed-pricing ul li.title-row,
	.full-boxed-pricing ul li.pricing-row,
	.sep-boxed-pricing ul li.title-row,
	.sep-boxed-pricing ul li.pricing-row,
	.person-author-wrapper,
	.post-content h1, .post-content h2, .post-content h3, .post-content h4, .post-content h5, .post-content h6{
		font-family:'<?php echo of_get_option('headings_font'); ?>', arial, helvetica, sans-serif !important;
	}
	<?php endif; ?>
	</style>

	<style type="text/css" id="ss">
	</style>

	<link rel="stylesheet" id="style_selector_ss" href="" />
</head>
<body <?php body_class($class); ?>>
	<div id="wrapper">
	<header id="header">
		<div class="row">
			<h1 class="logo"><a href="<?php bloginfo('wpurl'); ?>"><img src="<?php echo of_get_option('logo', get_bloginfo('template_directory')."/images/logo.gif"); ?>" alt="<?php bloginfo('name'); ?>" /></a></h1>
			<nav id="nav" class="nav-holder">
				<?php wp_nav_menu(array('theme_location' => 'main_navigation', 'depth' => 3, 'container' => false, 'menu_id' => 'nav')); ?>
			</nav>
		</div>
	</header>
	<?php
	// Layer Slider
	if(get_post_meta($post->ID, 'pyre_slider_type', true) == 'layer' && (get_post_meta($post->ID, 'pyre_slider', true) || get_post_meta($post->ID, 'pyre_slider', true) != 0)): ?>
	<div id="layerslider-container">
		<div id="layerslider-wrapper">
		<div class="ls-shadow-top"></div>
		<?php echo do_shortcode('[layerslider id="'.get_post_meta($post->ID, 'pyre_slider', true).'"]'); ?>
		<div class="ls-shadow-bottom"></div>
		</div>
	<?php if(get_post_meta($post->ID, 'pyre_fallback', true)): ?>
	<div id="fallback-slide">
		<img src="<?php echo get_post_meta($post->ID, 'pyre_fallback', true); ?>" alt="" />
	</div>
	<?php endif; ?>
	</div>
	<?php endif; ?>
	<?php
	// Flex Slider
	if(get_post_meta($post->ID, 'pyre_slider_type', true) == 'flex' && (get_post_meta($post->ID, 'pyre_wooslider', true) || get_post_meta($post->ID, 'pyre_wooslider', true) != 0)) {
		echo do_shortcode('[wooslider slide_page="'.get_post_meta($post->ID, 'pyre_wooslider', true).'" slider_type="slides"]');
	}
	?>
	<?php if(((is_page() || is_single() || is_singular('avada_portfolio')) && get_post_meta($post->ID, 'pyre_page_title', true) == 'yes') && !is_front_page()): ?>
	<div class="page-title-container">
		<div class="page-title">
			<h2><?php the_title(); ?></h2>
			<?php kriesi_breadcrumb(); ?>
		</div>
	</div>
	<?php endif; ?>
	<?php if(is_home() && !is_front_page()): ?>
	<div class="page-title-container">
		<div class="page-title">
			<h2><?php _e('Blog', 'Avada'); ?></h2>
			<?php kriesi_breadcrumb(); ?>
		</div>
	</div>
	<?php endif; ?>
	<?php if(is_search()): ?>
	<div class="page-title-container">
		<div class="page-title">
			<h2><?php _e('Search results for:', 'Avada'); ?> <?php echo get_search_query(); ?></h2>
		</div>
	</div>
	<?php endif; ?>
	<?php if(is_archive()): ?>
	<div class="page-title-container">
		<div class="page-title">
			<h2><?php single_cat_title(); ?></h2>
			<?php kriesi_breadcrumb(); ?>
		</div>
	</div>
	<?php endif; ?>
	<div id="main" style="overflow:hidden !important;">
		<div class="row">