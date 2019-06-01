<?php

$num_columns	= 23;
$can_delete	= $this->auth->has_permission('Student_Registration.Content.Delete');
$can_edit		= $this->auth->has_permission('Student_Registration.Content.Edit');
$has_records	= isset($records) && is_array($records) && count($records);

if ($can_delete) {
    $num_columns++;
}
?>
<div class='admin-box'>
	<h3>
		<?php echo lang('student_registration_area_title'); ?>
	</h3>
	<?php echo form_open($this->uri->uri_string()); ?>
		<table class='table table-striped'>
			<thead>
				<tr>
					<?php if ($can_delete && $has_records) : ?>
					<th class='column-check'><input class='check-all' type='checkbox' /></th>
					<?php endif;?>
					<th><?php echo lang('student_registration_field_student_name'); ?></th>
					<th><?php echo lang('student_registration_field_gender'); ?></th>
					<th><?php echo lang('student_registration_field_dob'); ?></th>
					<th><?php echo lang('student_registration_field_registration_no'); ?></th>
					<th><?php echo lang('student_registration_field_nationality'); ?></th>
					<th><?php echo lang('student_registration_field_annual_income'); ?></th>
					<th><?php echo lang('student_registration_field_relegion'); ?></th>
					<th><?php echo lang('student_registration_field_caste'); ?></th>
					<th><?php echo lang('student_registration_field_cast_category'); ?></th>
					<th><?php echo lang('student_registration_field_aadhar_number'); ?></th>
					<th><?php echo lang('student_registration_field_mobile_number'); ?></th>
					<th><?php echo lang('student_registration_actions'); ?></th>
				</tr>
			</thead>
			<?php if ($has_records) : ?>
			<tfoot>
				<?php if ($can_delete) : ?>
				<tr>
					<td colspan='<?php echo $num_columns; ?>'>
						<?php echo lang('bf_with_selected'); ?>
						<input type='submit' name='delete' id='delete-me' class='btn btn-danger' value="<?php echo lang('bf_action_delete'); ?>" onclick="return confirm('<?php e(js_escape(lang('student_registration_delete_confirm'))); ?>')" />
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
					<td><?php echo anchor(SITE_AREA . '/content/student_registration/edit/' . $record->id, '<span class="icon-pencil"></span> ' .  $record->student_name); ?></td>
				<?php else : ?>
					<td><?php e($record->student_name); ?></td>
				<?php endif; ?>
					<td><?php e($record->gender); ?></td>
					<td><?php e($record->dob); ?></td>
					<td><?php e($record->registration_no); ?></td>
					<td><?php e($this->address_model->getCountryName($record->nationality)); ?></td>
					<td><?php e($record->annual_income); ?></td>
					<td><?php e($record->relegion); ?></td>
					<td><?php e($record->caste); ?></td>
					<td><?php e($record->cast_category); ?></td>
					<td><?php e($record->aadhar_number); ?></td>
					<td><?php e($record->mobile_number); ?></td>
					<td><?php echo anchor(SITE_AREA . '/content/student_registration/admission/' . $record->id, '<span class="icon-book"></span> ' .  'Admission'); ?></td>
				</tr>
				<?php
					endforeach;
				else:
				?>
				<tr>
					<td colspan='<?php echo $num_columns; ?>'><?php echo lang('student_registration_records_empty'); ?></td>
				</tr>
				<?php endif; ?>
			</tbody>
		</table>
	<?php
    echo form_close();
    
    ?>
</div>