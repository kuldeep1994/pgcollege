<?php

$checkSegment = $this->uri->segment(4);
$areaUrl = SITE_AREA . '/master/course_wise_subjects';

?>
<ul class='nav nav-pills'>
	<li<?php echo $checkSegment == '' ? ' class="active"' : ''; ?>>
		<a href="<?php echo site_url($areaUrl); ?>" id='list'>
            <?php echo lang('course_wise_subjects_list'); ?>
        </a>
	</li>
	<?php if ($this->auth->has_permission('Course_wise_subjects.Master.Create')) : ?>
	<li<?php echo $checkSegment == 'create' ? ' class="active"' : ''; ?>>
		<a href="<?php echo site_url($areaUrl . '/create'); ?>" id='create_new'>
            <?php echo lang('course_wise_subjects_new'); ?>
        </a>
	</li>
	<?php endif; ?>
</ul>