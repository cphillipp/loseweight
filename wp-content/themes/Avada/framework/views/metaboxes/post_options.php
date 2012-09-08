<div class='pyre_metabox'>
<?php
$this->select(	'page_title',
				'Page Title',
				array('yes' => 'Show', 'no' => 'Hide'),
				''
			);
?>
<?php
$this->textarea(	'video',
				'Video Embed Code'
			);
?>
<?php
$this->select(	'sidebar_position',
				'Sidebar Position',
				array('right' => 'Right', 'left' => 'Left'),
				''
			);
?>
</div>