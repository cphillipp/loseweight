<div class='pyre_metabox'>
<?php
$this->select(	'width',
				'Width (Content Columns)',
				array('full' => 'Full Width', 'half' => 'Half Width'),
				''
			);
?>
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
$this->text(	'project_url',
				'Project URL',
				''
			);
?>
<?php
$this->text(	'project_url_text',
				'Project URL Text',
				''
			);
?>
<?php
$this->text(	'copy_url',
				'Copyright URL',
				''
			);
?>
<?php
$this->text(	'copy_url_text',
				'Copyright URL Text',
				''
			);
?>
</div>