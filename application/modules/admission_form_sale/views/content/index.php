<?php

$num_columns	= 13;
$can_delete	= $this->auth->has_permission('Admission_Form_Sale.Content.Delete');
$can_edit		= $this->auth->has_permission('Admission_Form_Sale.Content.Edit');
$has_records	= isset($records) && is_array($records) && count($records);

if ($can_delete) {
    $num_columns++;
}
?>
<div class='admin-box'>
	<h3>
		<?php echo lang('admission_form_sale_area_title'); ?>
	</h3>
	<?php echo form_open($this->uri->uri_string()); ?>
		<table class='table table-striped'>
			<thead>
				<tr>
					<?php if ($can_delete && $has_records) : ?>
					<th class='column-check'><input class='check-all' type='checkbox' /></th>
					<?php endif;?>
					
					<th><?php echo lang('admission_form_sale_field_academic_year'); ?></th>
					<th><?php echo lang('admission_form_sale_field_student_name'); ?></th>
					<th><?php echo lang('admission_form_sale_field_mobile_no'); ?></th>
					<th><?php echo lang('admission_form_sale_field_course'); ?></th>
					<th><?php echo lang('admission_form_sale_field_date'); ?></th>
					<th><?php echo lang('admission_form_sale_field_father_name'); ?></th>
					<th><?php echo lang('admission_form_sale_field_form_no'); ?></th>
					<th><?php echo lang('admission_form_sale_field_amount'); ?></th>
					<th><?php echo lang('admission_form_sale_column_deleted'); ?></th>
					<th><?php echo lang('admission_form_sale_column_created'); ?></th>
					<th><?php echo lang('admission_form_sale_column_modified'); ?></th>
					<th><?php echo lang('admission_form_sale_field_action'); ?></th>
				</tr>
			</thead>
			<?php if ($has_records) : ?>
			<tfoot>
				<?php if ($can_delete) : ?>
				<tr>
					<td colspan='<?php echo $num_columns; ?>'>
						<?php echo lang('bf_with_selected'); ?>
						<input type='submit' name='delete' id='delete-me' class='btn btn-danger' value="<?php echo lang('bf_action_delete'); ?>" onclick="return confirm('<?php e(js_escape(lang('admission_form_sale_delete_confirm'))); ?>')" />
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
					<td><?php echo anchor(SITE_AREA . '/content/admission_form_sale/edit/' . $record->id, '<span class="icon-pencil"></span> ' .  $record->academic_year); ?></td>
				<?php else : ?>
					<td><?php e($record->academic_year); ?></td>
				<?php endif; ?>
					<td><?php e($record->student_name); ?></td>
					<td><?php e($record->mobile_no); ?></td>
					<td><?php e($this->db->get_where('bf_course',array('id'=>$record->course))->row()->course_name); ?></td>
					<td><?php e($record->date); ?></td>
					<td><?php e($record->father_name); ?></td>
					<td><?php e($record->form_no); ?></td>
					<td><?php e($record->amount); ?></td>
					<td><?php echo $record->deleted > 0 ? lang('admission_form_sale_true') : lang('admission_form_sale_false'); ?></td>
					<td><?php e($record->created_on); ?></td>
					<td><?php e($record->modified_on); ?></td>
					<td><?php echo anchor(SITE_AREA . '/content/admission_form_sale/reciept/' . $record->id, '<span class="icon-print"></span> ' . 'Print'); ?></td>
				</tr>
				<?php
					endforeach;
				else:
				?>
				<tr>
					<td colspan='<?php echo $num_columns; ?>'><?php echo lang('admission_form_sale_records_empty'); ?></td>
				</tr>
				<?php endif; ?>
			</tbody>
		</table>
	<?php
    echo form_close();
    
    ?>
</div>