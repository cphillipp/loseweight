<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * WooSlider Sliders Class
 *
 * All functionality pertaining to the slideshows in WooSlider.
 *
 * @package WordPress
 * @subpackage WooSlider
 * @category Core
 * @author WooThemes
 * @since 1.0.0
 *
 * TABLE OF CONTENTS
 *
 * - __construct()
 * - add()
 * - get_slides()
 * - render()
 * - get_placeholder_image()
 * - slideshow_type_attachments()
 * - slideshow_type_posts()
 * - slideshow_type_slides()
 */
class WooSlider_Sliders {
	public $token;
	public $sliders;

	/**
	 * Constructor.
	 * @since  1.0.0
	 */
	public function __construct () {} // End __construct()

	/**
	 * Add a slider to be kept track of on the current page.
	 * @since  1.0.0
	 * @param  array $slides 	An array of items to act as slides.
	 * @param  array $settings   Arguments pertaining to this specific slider.
	 * @param  array $args  		Optional arguments to be passed to the slider.
	 */
	public function add ( $slides, $settings, $args = array() ) {
		if ( isset( $settings['id'] ) && ! in_array( $settings['id'], array_keys( (array)$this->sliders ) ) ) {
			$this->sliders[(string)$settings['id']] = array( 'slides' => $slides, 'args' => $settings, 'extra' => $args );
		}
	} // End add()

	/**
	 * Get the slides pertaining to a specified slider.
	 * @since  1.0.0
	 * @param  int $id   The ID of the slider in question.
	 * @param  array  $args Optional arguments pertaining to this slider.
	 * @return array       An array of slides pertaining to the specified slider.
	 */
	public function get_slides ( $type, $args = array() ) {
		$slides = array();

		$supported_types = WooSlider_Utils::get_slider_types();

		if ( in_array( $type, array_keys( $supported_types ) ) ) {
			if ( method_exists( $this, 'slideshow_type_' . esc_attr( $type ) ) ) {
				$slides = call_user_func( array( $this, 'slideshow_type_' . esc_attr( $type ) ), $args );
			} else {
				if ( isset( $supported_types[$type]['callback'] ) && $supported_types[$type]['callback'] != 'method' ) {
					if ( is_callable( $supported_types[$type]['callback'] ) ) {
						$slides = call_user_func( $supported_types[$type]['callback'], $args );
					}
				}
			}
		}

		return (array)$slides;
	} // End get_slides()

	/**
	 * Render the slides into appropriate HTML.
	 * @since  1.0.0
	 * @param  array $slides 	The slides to render.
	 * @return string         	The rendered HTML.
	 */	
	public function render ( $slides ) {
		$html = '';

		if ( ! is_array( $slides ) ) $slides = (array)$slides;

		if ( is_array( $slides ) && count( $slides ) ) {
			foreach ( $slides as $k => $v ) {
				if ( isset( $v['content'] ) ) {
					$atts = '';
					if ( isset( $v['attributes'] ) && is_array( $v['attributes'] ) && ( count( $v['attributes'] ) > 0 ) ) {
						foreach ( $v['attributes'] as $i => $j ) {
							$atts .= ' ' . esc_attr( strtolower( $i ) ) . '="' . esc_attr( $j ) . '"';
						}
					}
					$html .= '<li class="slide"' . $atts . '>' . "\n" . $v['content'] . '</li>' . "\n";
				}
			}
		}

		return $html;
	} // End render()

	/**
	 * Get the placeholder thumbnail image.
	 * @since  1.0.0
	 * @return string The URL to the placeholder thumbnail image.
	 */
	public function get_placeholder_image () {
		global $wooslider;
		return esc_url( apply_filters( 'wooslider_placeholder_thumbnail', $wooslider->plugin_url . 'assets/images/placeholder.png' ) );
	} // End get_placeholder_image()

	/**
	 * Get the slides for the "attachments" slideshow type.
	 * @since  1.0.0
	 * @param  array $args Array of arguments to determine which slides to return.
	 * @return array       An array of slides to render for the slideshow.
	 */
	private function slideshow_type_attachments ( $args = array() ) {
		global $post;
		$slides = array();

		$defaults = array(
						'limit' => '5', 
						'id' => $post->ID, 
						'size' => 'large', 
						'thumbnails' => ''
						);

		$args = wp_parse_args( $args, $defaults );

		$query_args = array( 'post_type' => 'attachment', 'post_mime_type' => 'image', 'post_parent' => intval( $args['id'] ), 'numberposts' => intval( $args['limit'] ) );
		$attachments = get_posts( $query_args );

		if ( ! is_wp_error( $attachments ) && ( count( $attachments ) > 0 ) ) {
			foreach ( $attachments as $k => $v ) {
				$data = array( 'content' => wp_get_attachment_image( $v->ID, esc_attr( $args['size'] ) ) );
				if ( $args['thumbnails'] == 'true' ) {
					$thumb_url = wp_get_attachment_thumb_url( $v->ID );
					if ( ! is_bool( $thumb_url ) ) {
						$data['attributes'] = array( 'data-thumb' => $thumb_url );
					} else {
						$data['attributes'] = array( 'data-thumb' => esc_url( WooSlider_Utils::get_placeholder_image() ) );
					}
				}
				$slides[] = $data;
			}
		}

		return $slides;
	} // End slideshow_type_attachments()

	/**
	 * Get the slides for the "posts" slideshow type.
	 * @since  1.0.0
	 * @param  array $args Array of arguments to determine which slides to return.
	 * @return array       An array of slides to render for the slideshow.
	 */
	private function slideshow_type_posts ( $args = array() ) {
		global $post;
		$slides = array();

		$defaults = array(
						'limit' => '5', 
						'category' => '',
						'tag' => '', 
						'layout' => 'text-left', 
						'size' => 'large', 
						'link_title' => 'false', 
						'overlay' => 'none' // none, full or natural
						);

		$args = wp_parse_args( $args, $defaults );

		// Determine and validate the layout type.
		$supported_layouts = WooSlider_Utils::get_posts_layout_types();
		if ( ! in_array( $args['layout'], array_keys( $supported_layouts ) ) ) { $args['layout'] = $defaults['layout']; }

		// Determine and validate the overlay setting.
		if ( ! in_array( $args['overlay'], array( 'none', 'full', 'natural' ) ) ) { $args['overlay'] = $defaults['overlay']; }

		$query_args = array( 'post_type' => 'post', 'numberposts' => intval( $args['limit'] ) );
		
		if ( $args['category'] != '' ) {
			$query_args['category_name'] = esc_attr( $args['category'] );
		}

		if ( $args['tag'] != '' ) {
			$query_args['tag'] = esc_attr( str_replace( ',', '+', $args['tag'] ) );
		}

		$posts = get_posts( $query_args );

		if ( ! is_wp_error( $posts ) && ( count( $posts ) > 0 ) ) {
			// Setup the CSS class.
			$class = 'layout-' . esc_attr( $args['layout'] ) . ' overlay-' . esc_attr( $args['overlay'] );

			foreach ( $posts as $k => $post ) {
				setup_postdata( $post );
				$image = get_the_post_thumbnail( get_the_ID(), $args['size'] );

				// Allow plugins/themes to filter here.
				$excerpt = '';
				if ( has_excerpt( get_the_ID() ) ) { $excerpt = wpautop( get_the_excerpt( get_the_ID() ) ); }

				$title = get_the_title( get_the_ID() );
				if ( $args['link_title'] == 'true' ) {
					$title = '<a href="' . get_permalink( $post ) . '">' . $title . '</a>';
				}
				$content = $image . '<div class="slide-excerpt"><h2 class="slide-title">' . $title . '</h2>' . $excerpt . '</div>';
				if ( $args['layout'] == 'text-top' ) {
					$content = '<div class="slide-excerpt"><h2 class="slide-title">' . $title . '</h2>' . $excerpt . '</div>' . $image;
				}

				$layed_out_content = apply_filters( 'wooslider_posts_layout_html', $content, $args, $post );

				$content = '<div class="' . esc_attr( $class ) . '">' . $layed_out_content . '</div>';
				$data = array( 'content' => $content );

				if ( $args['thumbnails'] == 'true' ) {
					$thumb_url = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'medium' );
					if ( ! is_bool( $thumb_url ) && isset( $thumb_url[0] ) ) {
						$data['attributes'] = array( 'data-thumb' => esc_url( $thumb_url[0] ) );
					} else {
						$data['attributes'] = array( 'data-thumb' => esc_url( WooSlider_Utils::get_placeholder_image() ) );
					}
				}
				$slides[] = $data;
			}
			wp_reset_postdata();
		}

		return $slides;
	} // End slideshow_type_posts()

	/**
	 * Get the slides for the "slides" slideshow type.
	 * @since  1.0.0
	 * @param  array $args Array of arguments to determine which slides to return.
	 * @return array       An array of slides to render for the slideshow.
	 */
	private function slideshow_type_slides ( $args = array() ) {
		global $post;
		$slides = array();

		$defaults = array(
						'limit' => '5', 
						'slide_page' => ''
						);

		$args = wp_parse_args( $args, $defaults );

		$query_args = array( 'post_type' => 'slide', 'numberposts' => intval( $args['limit'] ) );
		
		if ( $args['slide_page'] != '' ) {
			$cats_split = explode( ',', $args['slide_page'] );
			$query_args['tax_query'] = array();
			foreach ( $cats_split as $k => $v ) {
				$query_args['tax_query'][] = array(
						'taxonomy' => 'slide-page',
						'field' => 'slug',
						'terms' => esc_attr( trim( rtrim( $v ) ) )
					);
			}
		}

		$posts = get_posts( $query_args );

		if ( ! is_wp_error( $posts ) && ( count( $posts ) > 0 ) ) {
			foreach ( $posts as $k => $post ) {
				setup_postdata( $post );
				$content = get_the_content();

				$data = array( 'content' => '<div class="slide-content">' . "\n" . $content . "\n" . '</div>' . "\n" );
				if ( $args['thumbnails'] == 'true' ) {
					$thumb_url = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'medium' );
					if ( ! is_bool( $thumb_url ) && isset( $thumb_url[0] ) ) {
						$data['attributes'] = array( 'data-thumb' => esc_url( $thumb_url[0] ) );
					} else {
						$data['attributes'] = array( 'data-thumb' => esc_url( WooSlider_Utils::get_placeholder_image() ) );
					}
				}
				$slides[] = $data;
			}
			wp_reset_postdata();
		}

		return $slides;
	} // End slideshow_type_slides()
} // End Class
?>