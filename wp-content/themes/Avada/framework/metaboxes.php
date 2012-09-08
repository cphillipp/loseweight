<?php

class PyreThemeFrameworkMetaboxes {
	
	public function __construct()
	{
		add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
		add_action('save_post', array($this, 'save_meta_boxes'));
		add_action('admin_enqueue_scripts', array($this, 'admin_script_loader'));
	}

	// Load backend scripts
	function admin_script_loader() {
	    wp_register_script('upload', get_bloginfo('template_directory').'/js/upload.js');
	    wp_enqueue_script('upload');
	    wp_enqueue_script('media-upload');
	    wp_enqueue_script('thickbox');
	    wp_enqueue_style('thickbox');
	}
	
	public function add_meta_boxes()
	{
		$this->add_meta_box('post_options', 'Post Options', 'post');
		$this->add_meta_box('page_options', 'Page Options', 'page');
		$this->add_meta_box('review_info', 'Review Info', 'post');
		$this->add_meta_box('portfolio_options', 'Portfolio Options', 'avada_portfolio');
		$this->add_meta_box('contact_info', 'Contact Info', 'page');
	}
	
	public function add_meta_box($id, $label, $post_type)
	{
	    add_meta_box( 
	        'pyre_' . $id,
	        $label,
	        array($this, $id),
	        $post_type
	    );
	}
	
	public function save_meta_boxes($post_id)
	{
		if(defined( 'DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return;
		}
		
		foreach($_POST as $key => $value) {
			if(strstr($key, 'pyre_')) {
				update_post_meta($post_id, $key, $value);
			}
		}
	}
	
	public function review_info()
	{	
		include 'views/metaboxes/style.php';
		include 'views/metaboxes/review_info.php';
	}
	
	public function post_options()
	{	
		include 'views/metaboxes/style.php';
		include 'views/metaboxes/post_options.php';
	}

	public function page_options()
	{	
		include 'views/metaboxes/style.php';
		include 'views/metaboxes/page_options.php';
	}

	public function portfolio_options()
	{	
		include 'views/metaboxes/style.php';
		include 'views/metaboxes/portfolio_options.php';
	}
	
	public function contact_info()
	{	
		include 'views/metaboxes/style.php';
		include 'views/metaboxes/contact_info.php';
	}
	
	public function text($id, $label, $desc = '')
	{
		global $post;
		
		$html = '';
		$html .= '<div class="pyre_metabox_field">';
			$html .= '<label for="pyre_' . $id . '">';
			$html .= $label;
			$html .= '</label>';
			$html .= '<div class="field">';
				$html .= '<input type="text" id="pyre_' . $id . '" name="pyre_' . $id . '" value="' . get_post_meta($post->ID, 'pyre_' . $id, true) . '" />';
				if($desc) {
					$html .= '<p>' . $desc . '</p>';
				}
			$html .= '</div>';
		$html .= '</div>';
		
		echo $html;
	}
	
	public function select($id, $label, $options, $desc = '')
	{
		global $post;
		
		$html = '';
		$html .= '<div class="pyre_metabox_field">';
			$html .= '<label for="pyre_' . $id . '">';
			$html .= $label;
			$html .= '</label>';
			$html .= '<div class="field">';
				$html .= '<select id="pyre_' . $id . '" name="pyre_' . $id . '">';
				foreach($options as $key => $option) {
					if(get_post_meta($post->ID, 'pyre_' . $id, true) == $key) {
						$selected = 'selected="selected"';
					} else {
						$selected = '';
					}
					
					$html .= '<option ' . $selected . 'value="' . $key . '">' . $option . '</option>';
				}
				$html .= '</select>';
				if($desc) {
					$html .= '<p>' . $desc . '</p>';
				}
			$html .= '</div>';
		$html .= '</div>';
		
		echo $html;
	}

	public function textarea($id, $label, $desc = '')
	{
		global $post;

		$html = '';
		$html = '';
		$html .= '<div class="pyre_metabox_field">';
			$html .= '<label for="pyre_' . $id . '">';
			$html .= $label;
			$html .= '</label>';
			$html .= '<div class="field">';
				$html .= '<textarea cols="120" rows="10" id="pyre_' . $id . '" name="pyre_' . $id . '">' . get_post_meta($post->ID, 'pyre_' . $id, true) . '</textarea>';
				if($desc) {
					$html .= '<p>' . $desc . '</p>';
				}
			$html .= '</div>';
		$html .= '</div>';
		
		echo $html;
	}

	public function upload($id, $label, $desc = '')
	{
		global $post;

		$html = '';
		$html = '';
		$html .= '<div class="pyre_metabox_field">';
			$html .= '<label for="pyre_' . $id . '">';
			$html .= $label;
			$html .= '</label>';
			$html .= '<div class="field">';
			    $html .= '<input name="pyre_' . $id . '" class="upload_field" id="pyre_' . $id . '" type="text" value="' . get_post_meta($post->ID, 'pyre_' . $id, true) . '" />';
			    $html .= '<input class="upload_button" type="button" value="Browse" />';
				if($desc) {
					$html .= '<p>' . $desc . '</p>';
				}
			$html .= '</div>';
		$html .= '</div>';
		
		echo $html;
	}
	
}

$metaboxes = new PyreThemeFrameworkMetaboxes;