<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/*
 * WooSlider Settings Class
 *
 * All functionality pertaining to the settings in WooSlider.
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
 * - init_sections()
 * - init_fields()
 * - get_duration_options()
 */
class WooSlider_Settings extends WooSlider_Settings_API {
	
	/**
	 * __construct function.
	 * 
	 * @access public
	 * @since 1.0.0
	 * @return void
	 */
	public function __construct () {
	    parent::__construct(); // Required in extended classes.
	    add_action( 'admin_head', array( $this, 'add_contextual_help' ) );  
	} // End __construct()
	
	/**
	 * init_sections function.
	 * 
	 * @access public
	 * @since 1.0.0
	 * @return void
	 */
	public function init_sections () {
	
		$sections = array();

		$sections['default-settings'] = array(
					'name' 			=> __( 'General Settings', 'wooslider' ), 
					'description'	=> __( 'Settings to apply to all slideshows, unless overridden.', 'wooslider' )
				);

		$sections['control-settings'] = array(
					'name' 			=> __( 'Control Settings', 'wooslider' ), 
					'description'	=> __( 'Customise the ways in which slideshows can be controlled.', 'wooslider' )
				);

		$sections['button-settings'] = array(
					'name' 			=> __( 'Button Settings', 'wooslider' ), 
					'description'	=> __( 'Customise the texts of the various slideshow buttons.', 'wooslider' )
				);
		
		$this->sections = $sections;
		
	} // End init_sections()
	
	/**
	 * init_fields function.
	 * 
	 * @access public
	 * @since 1.0.0
	 * @uses  WooSlider_Utils::get_slider_types()
	 * @return void
	 */
	public function init_fields () {
		global $pagenow;

	    $fields = array();

    	$fields['animation'] = array(
								'name' => __( 'Animation', 'wooslider' ), 
								'description' => __( 'The slider animation', 'wooslider' ), 
								'type' => 'select', 
								'default' => 'fade', 
								'section' => 'default-settings', 
								'required' => 0, 
								'options' => array( 'fade' => __( 'Fade', 'wooslider' ), 'slide' => __( 'Slide', 'wooslider' ) )
								);

    	$fields['direction'] = array(
								'name' => __( 'Slide Direction', 'wooslider' ), 
								'description' => __( 'The direction to slide (if using the "Slide" animation)', 'wooslider' ), 
								'type' => 'select', 
								'default' => 'horizontal', 
								'section' => 'default-settings', 
								'required' => 0, 
								'options' => array( 'horizontal' => __( 'Horizontal', 'wooslider' ), 'vertical' => __( 'Vertical', 'wooslider' ) )
								);

    	$fields['slideshow_speed'] = array(
								'name' => __( 'Slideshow Speed', 'wooslider' ), 
								'description' => __( 'Set the delay between each slide animation (in seconds)', 'wooslider' ), 
								'type' => 'range', 
								'default' => '7.0', 
								'section' => 'default-settings', 
								'required' => 0, 
								'options' => $this->get_duration_options( false )
								);

    	$fields['animation_duration'] = array(
								'name' => __( 'Animation Speed', 'wooslider' ), 
								'description' => __( 'Set the duration of each slide animation (in seconds)', 'wooslider' ), 
								'type' => 'range', 
								'default' => '0.6', 
								'section' => 'default-settings', 
								'required' => 0, 
								'options' => $this->get_duration_options()
								);

    	// Button Settings
    	$fields['prev_text'] = array(
								'name' => __( '"Previous" Link Text', 'wooslider' ), 
								'description' => __( 'The text to display on the "Previous" button.', 'wooslider' ), 
								'type' => 'text', 
								'default' => __( 'Previous', 'wooslider' ), 
								'section' => 'button-settings'
								);

    	$fields['next_text'] = array(
								'name' => __( '"Next" Link Text', 'wooslider' ), 
								'description' => __( 'The text to display on the "Next" button.', 'wooslider' ), 
								'type' => 'text', 
								'default' => __( 'Next', 'wooslider' ), 
								'section' => 'button-settings'
								);

    	$fields['play_text'] = array(
								'name' => __( '"Play" Button Text', 'wooslider' ), 
								'description' => __( 'The text to display on the "Play" button.', 'wooslider' ), 
								'type' => 'text', 
								'default' => __( 'Play', 'wooslider' ), 
								'section' => 'button-settings'
								);

    	$fields['pause_text'] = array(
								'name' => __( '"Pause" Button Text', 'wooslider' ), 
								'description' => __( 'The text to display on the "Pause" button.', 'wooslider' ), 
								'type' => 'text', 
								'default' => __( 'Pause', 'wooslider' ), 
								'section' => 'button-settings'
								);

    	// Control Settings
    	$fields['autoslide'] = array(
								'name' => '', 
								'description' => __( 'Animate the slideshows automatically', 'wooslider' ), 
								'type' => 'checkbox', 
								'default' => true, 
								'section' => 'control-settings'
								);

    	$fields['smoothheight'] = array(
								'name' => '', 
								'description' => __( 'Adjust the height of the slideshow to the height of the current slide', 'wooslider' ), 
								'type' => 'checkbox', 
								'default' => false, 
								'section' => 'control-settings'
								);

    	$fields['direction_nav'] = array(
								'name' => '', 
								'description' => __( 'Display the "Previous/Next" navigation', 'wooslider' ), 
								'type' => 'checkbox', 
								'default' => true, 
								'section' => 'control-settings'
								);

    	$fields['control_nav'] = array(
								'name' => '', 
								'description' => __( 'Display the slideshow pagination', 'wooslider' ), 
								'type' => 'checkbox', 
								'default' => true, 
								'section' => 'control-settings'
								);

    	$fields['keyboard_nav'] = array(
								'name' => '', 
								'description' => __( 'Enable keyboard navigation', 'wooslider' ), 
								'type' => 'checkbox', 
								'default' => false, 
								'section' => 'control-settings'
								);

    	$fields['mousewheel_nav'] = array(
								'name' => '', 
								'description' => __( 'Enable the mousewheel navigation', 'wooslider' ), 
								'type' => 'checkbox', 
								'default' => false, 
								'section' => 'control-settings'
								);

    	$fields['playpause'] = array(
								'name' => '', 
								'description' => __( 'Enable the "Play/Pause" event', 'wooslider' ), 
								'type' => 'checkbox', 
								'default' => false, 
								'section' => 'control-settings'
								);

    	$fields['randomize'] = array(
								'name' => '', 
								'description' => __( 'Randomize the order of slides in slideshows', 'wooslider' ), 
								'type' => 'checkbox', 
								'default' => false, 
								'section' => 'control-settings'
								);

    	$fields['animation_loop'] = array(
								'name' => '', 
								'description' => __( 'Loop the slideshow animations', 'wooslider' ), 
								'type' => 'checkbox', 
								'default' => true, 
								'section' => 'control-settings'
								);

    	$fields['pause_on_action'] = array(
								'name' => '', 
								'description' => __( 'Pause the slideshow autoplay when using the pagination or "Previous/Next" navigation', 'wooslider' ), 
								'type' => 'checkbox', 
								'default' => true, 
								'section' => 'control-settings'
								);

    	$fields['pause_on_hover'] = array(
								'name' => '', 
								'description' => __( 'Pause the slideshow autoplay when hovering over a slide', 'wooslider' ), 
								'type' => 'checkbox', 
								'default' => false, 
								'section' => 'control-settings'
								);
		
		$this->fields = $fields;
	
	} // End init_fields()

	/**
	 * Get options for the duration fields.
	 * @since  1.0.0
	 * @param  $include_milliseconds (default: true) Whether or not to include milliseconds between 0 and 1.
	 * @return array Options between 0.1 and 10 seconds.
	 */
	private function get_duration_options ( $include_milliseconds = true ) {
		$numbers = array( '1.0', '1.5', '2.0', '2.5', '3.0', '3.5', '4.0', '4.5', '5.0', '5.5', '6.0', '6.5', '7.0', '7.5', '8.0', '8.5', '9.0', '9.5', '10.0' );
		$options = array();

		if ( true == (bool)$include_milliseconds ) {
			$milliseconds = array( '0.1', '0.2', '0.3', '0.4', '0.5', '0.6', '0.7', '0.8', '0.9' );
			foreach ( $milliseconds as $k => $v ) {
				$options[$v] = $v;
			}
		} else {
			$options['0.5'] = '0.5';
		}

		foreach ( $numbers as $k => $v ) {
			$options[$v] = $v;
		}

		return $options;
	} // End get_duration_options()

	/**
	 * Add contextual help to the settings screen.
	 * @access public
	 * @since   1.0.0
	 * @return   void
	 */
	public function add_contextual_help () {
		get_current_screen()->add_help_tab( array(
		'id'		=> 'overview',
		'title'		=> __( 'Overview', 'wooslider' ),
		'content'	=>
			'<p>' . __( 'This screen contains all the default settings for your slideshows created by WooSlider (animation duration, speeds, display of slideshow controls, etc). Anything set here will apply to all WooSlider slideshows, unless overridden by a slideshow.', 'wooslider' ) . '</p>'
		) );
		
		get_current_screen()->add_help_tab( array(
		'id'		=> 'general-settings',
		'title'		=> __( 'General Settings', 'wooslider' ),
		'content'	=>
			'<p>' . __( 'Settings to apply to all slideshows, unless overridden.', 'wooslider' ) . '</p>' . 
			'<ol>' . 
			'<li><strong>' . __( 'Animation', 'wooslider' ) . '</strong> - ' . __( 'The default animation to use for your slideshows ("slide" or "fade").', 'wooslider' ) . '</li>' . 
			'<li><strong>' . __( 'Slide Direction', 'wooslider' ) . '</strong> - ' . __( 'Slide the slideshows either vertically or horizontally (works only with the "slide" animation).', 'wooslider' ) . ' <em>' . __( 'NOTE: When sliding vertically, all slides need to have the same height.', 'wooslider' ) . '</em></li>' .
			'<li><strong>' . __( 'Slideshow Speed', 'wooslider' ) . '</strong> - ' . __( 'The delay between each slide animation (in seconds).', 'wooslider' ) . '</li>' . 
			'<li><strong>' . __( 'Animation Speed', 'wooslider' ) . '</strong> - ' . __( 'The duration of each slide animation (in seconds).', 'wooslider' ) . '</li>' . 
			'</ol>'
		) );

		get_current_screen()->add_help_tab( array(
		'id'		=> 'control-settings',
		'title'		=> __( 'Control Settings', 'wooslider' ),
		'content'	=>
			'<p>' . __( 'Customise the ways in which slideshows can be controlled.', 'wooslider' ) . '</p>' . 
			'<ol>' . 
			'<li><strong>' . __( 'Animate the slideshows automatically', 'wooslider' ) . '</strong> - ' . __( 'Whether or not to automatically animate between the slides (the alternative is to slide only when using the controls).', 'wooslider' ) . '</li>' . 
			'<li><strong>' . __( 'Adjust the height of the slideshow to the height of the current slide', 'wooslider' ) . '</strong> - ' . __( 'Alternatively, the slideshow will take the height from it\'s tallest slide.', 'wooslider' ) . '</li>' .
			'<li><strong>' . __( 'Display the "Previous/Next" navigation', 'wooslider' ) . '</strong> - ' . __( 'Show/hide the "Previous" and "Next" button controls.', 'wooslider' ) . '</li>' . 
			'<li><strong>' . __( 'Display the slideshow pagination', 'wooslider' ) . '</strong> - ' . __( 'Show/hide the pagination bar below the slideshow.', 'wooslider' ) . '</li>' . 
			'<li><strong>' . __( 'Enable keyboard navigation', 'wooslider' ) . '</strong> - ' . __( 'Enable navigation of this slideshow via the "left" and "right" arrow keys on the viewer\'s computer keyboard.', 'wooslider' ) . '</li>' . 
			'<li><strong>' . __( 'Enable the mousewheel navigation', 'wooslider' ) . '</strong> - ' . __( 'Enable navigation of this slideshow via the viewer\'s computer mousewheel.', 'wooslider' ) . '</li>' . 
			'<li><strong>' . __( 'Enable the "Play/Pause" event', 'wooslider' ) . '</strong> - ' . __( 'Show/hide the "Play/Pause" button below the slideshow for pausing and resuming the automated slideshow.', 'wooslider' ) . '</li>' . 
			'<li><strong>' . __( 'Randomize the order of slides in slideshows', 'wooslider' ) . '</strong> - ' . __( 'Display the slides in the slideshow in a random order.', 'wooslider' ) . '</li>' . 
			'<li><strong>' . __( 'Loop the slideshow animations', 'wooslider' ) . '</strong> - ' . __( 'When arriving at the end of the slideshow, carry on sliding from the first slide, indefinitely.', 'wooslider' ) . '</li>' . 
			'<li><strong>' . __( 'Pause the slideshow autoplay when using the pagination or "Previous/Next" navigation', 'wooslider' ) . '</strong> - ' . __( 'Pause the slideshow automation when the viewer decides to navigate using the manual controls.', 'wooslider' ) . '</li>' . 
			'<li><strong>' . __( 'Pause the slideshow autoplay when hovering over a slide', 'wooslider' ) . '</strong> - ' . __( 'Pause the slideshow automation when the viewer hovers over the slideshow.', 'wooslider' ) . '</li>' .
			'</ol>'
		) );

		get_current_screen()->add_help_tab( array(
		'id'		=> 'button-settings',
		'title'		=> __( 'Button Settings', 'wooslider' ),
		'content'	=>
			'<p>' . __( 'Customise the texts of the various slideshow buttons.', 'wooslider' ) . '</p>' . 
			'<ol>' . 
			'<li><strong>' . __( '"Previous" Link Text', 'wooslider' ) . '</strong> - ' . __( 'The text for the "Previous" button.', 'wooslider' ) . '</li>' . 
			'<li><strong>' . __( '"Next" Link Text', 'wooslider' ) . '</strong> - ' . __( 'The text for the "Next" button.', 'wooslider' ) . '</li>' . 
			'<li><strong>' . __( '"Play" Button Text', 'wooslider' ) . '</strong> - ' . __( 'The text for the "Play" button.', 'wooslider' ) . '</li>' . 
			'<li><strong>' . __( '"Pause" Button Text', 'wooslider' ) . '</strong> - ' . __( 'The text for the "Pause" button.', 'wooslider' ) . '</li>' . 
			'</ol>'
		) );

		get_current_screen()->set_help_sidebar(
		'<p><strong>' . __( 'For more information:', 'wooslider' ) . '</strong></p>' .
		'<p><a href="http://support.woothemes.com/?ref=' . 'wooslider' . '" target="_blank">' . __( 'Support Desk', 'wooslider' ) . '</a></p>'
		);
	} // End add_contextual_help()
} // End Class
?>