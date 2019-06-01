<?php

$checkSegment = $this->uri->segment(4);
$areaUrl = SITE_AREA . '/content/admission_form_sale';

?>
<ul class='nav nav-pills'>
	<li<?php echo $checkSegment == '' ? ' class="active"' : ''; ?>>
		<a href="<?php echo site_url($areaUrl); ?>" id='list'>
            <?php echo lang('admission_form_sale_list'); ?>
        </a>
	</li>
	<?php if ($this->auth->has_permission('Admission_Form_Sale.Content.Create')) : ?>
	<li<?php echo $checkSegment == 'create' ? ' class="active"' : ''; ?>>
		<a href="<?php echo site_url($areaUrl . '/create'); ?>" id='create_new'>
            <?php echo lang('admission_form_sale_new'); ?>
        </a>
	</li>
	<?php endif; ?>
</ul>