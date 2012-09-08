<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * WooSlider Widget Base Class
 *
 * Base widget class for WooSlider.
 *
 * @package WordPress
 * @subpackage WooSlider
 * @category Widgets
 * @author WooThemes
 * @since 1.0.0
 *
 * TABLE OF CONTENTS
 *
 * - __construct()
 * - init()
 * - widget()
 * - update()
 * - form()
 * - generate_field_by_type()
 * - generate_slideshow()
 */
class WooSlider_Widget_Base extends WP_Widget {

	/* Variable Declarations */
	var $slider_type;
	var $can_show_slideshow;
	var $defaults = array( 'title' => '' );
	var $woo_widget_cssclass;
	var $woo_widget_description;
	var $woo_widget_idbase;
	var $woo_widget_title;

	/**
	 * __construct function.
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct () {
		/* Widget variable settings. */
		$this->woo_widget_cssclass = 'widget_wooslider_slideshow';
		$this->woo_widget_description = __( 'A slideshow of the content on your site', 'wooslider' );
		$this->woo_widget_idbase = 'wooslider_slideshow';
		$this->woo_widget_title = __( 'Slideshow (WooSlider)', 'wooslider' );

		$this->can_show_slideshow = true;

		$this->init();
	} // End Constructor

	/**
	 * Initialize the widget.
	 * @since  1.0.0
	 * @return void
	 */
	protected function init () {
		/* Widget settings. */
		$widget_ops = array( 'classname' => $this->woo_widget_cssclass, 'description' => $this->woo_widget_description );

		/* Widget control settings. */
		$control_ops = array( 'width' => 250, 'height' => 350, 'id_base' => $this->woo_widget_idbase );

		/* Create the widget. */
		$this->WP_Widget( $this->woo_widget_idbase, $this->woo_widget_title, $widget_ops, $control_ops );
	} // End init()

	/**
	 * widget function.
	 * @since  1.0.0
	 * @access public
	 * @param array $args
	 * @param array $instance
	 * @return void
	 */
	public function widget ( $args, $instance ) {
		$slideshow_html = $this->generate_slideshow( $instance );
		if ( $slideshow_html == '' ) { return; }

		$html = '';
		
		extract( $args, EXTR_SKIP );
		
		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'], $instance, $this->id_base );

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title ) {
			echo $before_title . esc_html( $title ) . $after_title;
		}
		
		/* Widget content. */
		
		// Add actions for plugins/themes to hook onto.
		do_action( $this->woo_widget_cssclass . '_top' );
		
		// Load widget content here.
		$html = '';

		$html .= $slideshow_html;

		echo $html;

		// Add actions for plugins/themes to hook onto.
		do_action( $this->woo_widget_cssclass . '_bottom' );

		/* After widget (defined by themes). */
		echo $after_widget;

	} // End widget()

	/**
	 * update function.
	 * @access public
	 * @param array $new_instance
	 * @param array $old_instance
	 * @return array $instance
	 */
	public function update ( $new_instance, $old_instance ) {
		global $wooslider;

		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = esc_html( $new_instance['title'] );

		/* Save fields for the various contexts. */
		$fields = $wooslider->admin->generate_default_conditional_fields( array( $this->slider_type => $this->slider_type ) );
		
		/* Advanced Settings switch and related fields. */
		$instance['show_advanced_settings'] = (bool)intval( $new_instance['show_advanced_settings'] );

		if ( isset( $instance['show_advanced_settings'] ) && ( $instance['show_advanced_settings'] == true ) ) {
			$wooslider->settings->init_fields();
			$advanced_fields = $wooslider->settings->fields;

			if ( is_array( $advanced_fields ) && count( $advanced_fields ) > 0 ) {
				foreach ( $advanced_fields as $k => $v ) {
					if ( ! isset( $fields[$this->slider_type][$k] ) ) {
						$fields[$this->slider_type][$k] = esc_html( $v );
					}
				}
			}
		}

		/* Cater for new fields and preserve old fields if they aren't part of our current fields to be saved. */
		// Save fields for the current type.
		if ( isset( $fields[$this->slider_type] ) ) {
			foreach ( $fields[$this->slider_type] as $i => $j ) {
				if ( $j['type'] == 'select' || $j['type'] == 'text' ) {
					$instance[$i] = esc_attr( $new_instance[$i] );
				}

				if ( $j['type'] == 'multicheck' ) {
					$instance[$i] = array_map( 'esc_attr', $new_instance[$i] );
				}

				if ( $j['type'] == 'checkbox' ) {
					if ( isset( $new_instance[$i] ) && ( $new_instance[$i] == 1 ) ) {
						$instance[$i] = (bool)intval( $new_instance[$i] );
					} else {
						$instance[$i] = false;
					}
				}
			}
		}

		// Allow child themes/plugins to act here.
		$instance = apply_filters( $this->woo_widget_idbase . '_widget_save', $instance, $new_instance, $this );
		
		return $instance;
	} // End update()

   /**
    * form function.
    * 
    * @since  1.0.0
    * @access public
    * @param array $instance
    * @uses  global $wooslider object
    * @return void
    */
   public function form ( $instance ) {
   		global $wooslider;

		/* Set up some default widget settings. */
		/* Make sure all keys are added here, even with empty string values. */
		$defaults = $this->defaults;
		
		// Allow child themes/plugins to filter here.
		$defaults = apply_filters( $this->woo_widget_idbase . '_widget_defaults', $defaults, $this );
		
		$defaults['show_advanced_settings'] = 0;

		$advanced_fields = array();

		if ( isset( $instance['show_advanced_settings'] ) && ( $instance['show_advanced_settings'] == 1 ) ) {
			$wooslider->settings->init_fields();
			$advanced_fields = $wooslider->settings->fields;

			if ( is_array( $advanced_fields ) && count( $advanced_fields ) > 0 ) {
				foreach ( $advanced_fields as $k => $v ) {
					if ( ! isset( $defaults[$k] ) ) {
						$defaults[$k] = $v['default'];
					}
				}
			}
		}

		$instance = wp_parse_args( (array) $instance, $defaults );
?>
		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title (optional):', 'wooslider' ); ?></label>
			<input type="text" name="<?php echo $this->get_field_name( 'title' ); ?>"  value="<?php echo $instance['title']; ?>" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" />
		</p>
		<?php
			if ( isset( $this->slider_type ) && ( $this->slider_type != '' ) ) {
				$fields = $wooslider->admin->generate_default_conditional_fields( array( $this->slider_type => $this->slider_type ) );

				foreach ( $fields[$this->slider_type] as $k => $v ) {
		?>
		<p>
			<?php
				$field_label = '<label for="' . esc_attr( $k ) . '">' . $v['name'] . '</label>' . "\n";
				if ( $v['type'] != 'checkbox' ) { echo $field_label; } // Display the label first if the field isn't a checkbox.
				$this->generate_field_by_type( $v['type'], $v['args'], $instance );
				if ( $v['type'] == 'checkbox' ) { echo $field_label; } // Display the label last if the field is a checkbox.
			?>
		</p>
		<?php
				}
		?>
		<hr />
		<!-- Widget Advanced Fields: Text Input -->
		<p>
			<input type="checkbox" name="<?php echo $this->get_field_name( 'show_advanced_settings' ); ?>"  value="1" id="<?php echo $this->get_field_id( 'show_advanced_settings' ); ?>" <?php checked( '1', $instance['show_advanced_settings'] ); ?> />
			<label for="<?php echo $this->get_field_id( 'show_advanced_settings' ); ?>"><?php _e( 'Customise Advanced Settings', 'wooslider' ); ?></label>
		</p>
		<p><small><?php _e( 'Save the widget settings with this checkbox checked to customise slideshow settings.', 'wooslider' ); ?></small></p>
		<?php
				if ( isset( $instance['show_advanced_settings'] ) && ( $instance['show_advanced_settings'] == 1 ) ) {
					if ( is_array( $advanced_fields ) && count( $advanced_fields ) > 0 ) {
						foreach ( $advanced_fields as $k => $v ) {
							echo '<p>' . "\n";
							$label = $v['name'];
							if ( $label == '' ) { $label = $v['description']; }
							$field_label = '<label for="' . esc_attr( $k ) . '">' . $label . '</label>' . "\n";
							if ( $v['type'] != 'checkbox' ) { echo $field_label; } // Display the label first if the field isn't a checkbox.
							$this->generate_field_by_type( $v['type'], array( 'key' => $k, 'data' => $v ), $instance );
							if ( $v['type'] == 'checkbox' ) { echo $field_label; } // Display the label last if the field is a checkbox.
							echo '</p>' . "\n";
						}
					}
				}
			}
		?>
<?php
		// Allow child themes/plugins to act here.
		do_action( $this->woo_widget_idbase . '_widget_settings', $instance, $this );

	} // End form()

	/**
	 * Generate a field from the settings API based on a provided field type.
	 * @since  1.0.0
	 * @param  string $type The type of field to generate.
	 * @param  array $args Arguments to be passed to the field.
	 * @param  array $instance The current widget's instance.
	 * @return void
	 */
	private function generate_field_by_type ( $type, $args, $instance ) {
		if ( is_array( $args ) && isset( $args['key'] ) && isset( $args['data'] ) ) {

			switch ( $type ) {
				// Select fields.
				case 'select':
				case 'images':
					$html = '<select name="' . esc_attr( $this->get_field_name( $args['key'] ) ) . '" id="' . esc_attr( $this->get_field_id( $args['key'] ) ) . '" class="widefat">' . "\n";
					foreach ( $args['data']['options'] as $k => $v ) {

						$html .= '<option value="' . esc_attr( $k ) . '"' . selected( $k, $instance[$args['key']], false ) . '>' . $v . '</option>' . "\n";
					}
					$html .= '</select>' . "\n";

					echo $html;
				break;

				// Multiple checkboxes.
				case 'multicheck':
				if ( isset( $args['data']['options'] ) && ( count( (array)$args['data']['options'] ) > 0 ) ) {
					$html = '<div class="multicheck-container" style="height: 100px; overflow-y: auto;">' . "\n";
					foreach ( $args['data']['options'] as $k => $v ) {
						$checked = '';
						if ( in_array( $k, (array)$instance[$args['key']] ) ) { $checked = ' checked="checked"'; }
						$html .= '<input type="checkbox" name="' . esc_attr( $this->get_field_name( $args['key'] ) ) . '[]" class="multicheck multicheck-' . esc_attr( $args['key'] ) . '" value="' . esc_attr( $k ) . '"' . $checked . ' /> ' . $v . '<br />' . "\n";
					}
					$html .= '</div>' . "\n";
					echo $html;
				}

				break;

				// Single checkbox.
				case 'checkbox':
				if ( isset( $args['key'] ) && $args['key'] != '' ) {
					$html .= '<input type="checkbox" name="' . esc_attr( $this->get_field_name( $args['key'] ) ) . '" class="checkbox checkbox-' . esc_attr( $args['key'] ) . '" value="1"' . checked( '1', $instance[$args['key']], false ) . ' /> ' . "\n";
					echo $html;
				}

				break;

				// Text input.
				case 'text':
				if ( isset( $args['key'] ) && $args['key'] != '' ) {
					$html .= '<input type="text" name="' . esc_attr( $this->get_field_name( $args['key'] ) ) . '" class="input-text input-text-' . esc_attr( $args['key'] ) . ' widefat" value="' . esc_attr( $instance[$args['key']] ) . '" /> ' . "\n";
					echo $html;
				}

				break;
			}
		}
	} // End generate_field_by_type()

	/**
	 * Generate the HTML for this slideshow.
	 * @since  1.0.0
	 * @return string The generated HTML.
	 */
	protected function generate_slideshow ( $instance ) {
		global $wooslider;
		$settings = $wooslider->settings->get_settings();
		$settings['slider_type'] = $this->slider_type;

		$extra_args = array();

		foreach ( $instance as $k => $v ) {
			if ( ! in_array( $k, array_keys( $settings ) ) ) {
				$extra_args[$k] = esc_attr( $v );
			}
		}

		// Make sure the various settings are applied.
		foreach ( $settings as $k => $v ) {
			if ( isset( $instance[$k] ) && ( $instance[$k] != $settings[$k] ) ) {
				$settings[$k] = esc_attr( $instance[$k] );
			}
		}

		$html = wooslider( $settings, $extra_args, false );

		return $html;
	} // End generate_slideshow()
} // End Class
?>