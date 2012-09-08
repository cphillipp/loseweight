<div class="pyre_metabox">
<?php
$this->select(	'page_title',
				'Page Title',
				array('yes' => 'Show', 'no' => 'Hide'),
				''
			);
?>
<?php
$this->select(	'slider_type',
				'Slider Type',
				array('no' => 'No Slider', 'layer' => 'LayerSlider', 'flex' => 'FlexSlider'),
				''
			);
?>
<?php
$slides_array[0] = 'Select a slider';
$slides = get_option('layerslider-slides');  
if($slides){
$slides = is_array($slides) ? $slides : unserialize($slides);
foreach($slides as $key => $val){
	$slides_array[$key+1] = 'LayerSlider #'.($key+1);
}
}
$this->select(	'slider',
				'Select LayerSlider',
				$slides_array,
				''
			);
?>
<?php
$slides_array = array();
$slides_array[0] = 'Select a slider';
$slides = get_terms('slide-page');
if($slides){
$slides = is_array($slides) ? $slides : unserialize($slides);
foreach($slides as $key => $val){
	$slides_array[$val->slug] = $val->name;
}
}
$this->select(	'wooslider',
				'Select FlexSlider',
				$slides_array,
				''
			);
?>
<?php $this->upload('fallback', 'Slider Fallback Image'); ?>
<?php
$this->select(	'sidebar_position',
				'Sidebar Position',
				array('right' => 'Right', 'left' => 'Left'),
				''
			);
?>
</div>