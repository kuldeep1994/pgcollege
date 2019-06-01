<?php

$num_columns	= 3;
$can_delete	= $this->auth->has_permission('Course_wise_subjects.Master.Delete');
$can_edit		= $this->auth->has_permission('Course_wise_subjects.Master.Edit');
$has_records	= isset($records) && is_array($records) && count($records);

if ($can_delete) {
    $num_columns++;
}
?>
<div class='admin-box'>
	<h3>
		<?php echo lang('course_wise_subjects_area_title'); ?>
	</h3>
	<?php echo form_open($this->uri->uri_string()); ?>
		<table class='table table-striped'>
			<thead>
				<tr>
					<?php if ($can_delete && $has_records) : ?>
					<th class='column-check'><input class='check-all' type='checkbox' /></th>
					<?php endif;?>
					
					<th><?php echo lang('course_wise_subjects_field_course_id'); ?></th>
					<th><?php echo lang('course_wise_subjects_field_year_or_semester_id'); ?></th>
					<th><?php echo lang('course_wise_subjects_field_subject_id'); ?></th>
				</tr>
			</thead>
			<?php if ($has_records) : ?>
			<tfoot>
				<?php if ($can_delete) : ?>
				<tr>
					<td colspan='<?php echo $num_columns; ?>'>
						<?php echo lang('bf_with_selected'); ?>
						<input type='submit' name='delete' id='delete-me' class='btn btn-danger' value="<?php echo lang('bf_action_delete'); ?>" onclick="return confirm('<?php e(js_escape(lang('course_wise_subjects_delete_confirm'))); ?>')" />
					</td>
				</tr>
				<?php endif; ?>
			</tfoot>
			<?php endif; ?>
			<tbody>
				<?php
				if ($has_records) :
					foreach ($records as $record) :
				?>
				<tr>
					<?php if ($can_delete) : ?>
					<td class='column-check'><input type='checkbox' name='checked[]' value='<?php echo $record->id; ?>' /></td>
					<?php endif;?>
					
				<?php if ($can_edit) : ?>
				<?php $course_name = $this->course_model->course_name($record->course_id); ?>
					<td><?php echo anchor(SITE_AREA . '/master/course_wise_subjects/edit/' . $record->id, '<span class="icon-pencil"></span> ' .  $course_name); ?></td>
				<?php else : ?>
					<td><?php e($course_name ); ?></td>
				<?php endif; ?>
					<td><?php e($this->course_wise_subjects_model->getYearOrSemesterName($record->year_or_semester_id)); ?></td>
					<td><?php e($this->course_wise_subjects_model->getSubject($record->subject_id)); ?></td>
				</tr>
				<?php
					endforeach;
				else:
				?>
				<tr>
					<td colspan='<?php echo $num_columns; ?>'><?php echo lang('course_wise_subjects_records_empty'); ?></td>
				</tr>
				<?php endif; ?>
			</tbody>
		</table>
	<?php
    echo form_close();
    
    echo $this->pagination->create_links();
    ?>
</div>