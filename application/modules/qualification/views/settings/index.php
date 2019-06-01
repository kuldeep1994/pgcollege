<?php

$num_columns	= 12;
$can_delete	= $this->auth->has_permission('Qualification.Settings.Delete');
$can_edit		= $this->auth->has_permission('Qualification.Settings.Edit');
$has_records	= isset($records) && is_array($records) && count($records);

if ($can_delete) {
    $num_columns++;
}
?>
<div class='admin-box'>
	<h3>
		<?php echo lang('qualification_area_title'); ?>
	</h3>
	<?php echo form_open($this->uri->uri_string()); ?>
		<table class='table table-striped'>
			<thead>
				<tr>
					<?php if ($can_delete && $has_records) : ?>
					<th class='column-check'><input class='check-all' type='checkbox' /></th>
					<?php endif;?>
					
					<th><?php echo lang('qualification_field_class'); ?></th>
					<th><?php echo lang('qualification_field_stream'); ?></th>
					<th><?php echo lang('qualification_field_organization'); ?></th>
					<th><?php echo lang('qualification_field_board'); ?></th>
					<th><?php echo lang('qualification_field_rol_no'); ?></th>
					<th><?php echo lang('qualification_field_total_marks'); ?></th>
					<th><?php echo lang('qualification_field_obtained_marks'); ?></th>
					<th><?php echo lang('qualification_field_pass_year'); ?></th>
					<th><?php echo lang('qualification_field_registration_no'); ?></th>
					<th><?php echo lang('qualification_column_created'); ?></th>
					<th><?php echo lang('qualification_column_modified'); ?></th>
				</tr>
			</thead>
			<?php if ($has_records) : ?>
			<tfoot>
				<?php if ($can_delete) : ?>
				<tr>
					<td colspan='<?php echo $num_columns; ?>'>
						<?php echo lang('bf_with_selected'); ?>
						<input type='submit' name='delete' id='delete-me' class='btn btn-danger' value="<?php echo lang('bf_action_delete'); ?>" onclick="return confirm('<?php e(js_escape(lang('qualification_delete_confirm'))); ?>')" />
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
					<td><?php echo anchor(SITE_AREA . '/settings/qualification/edit/' . $record->id, '<span class="icon-pencil"></span> ' .  $record->class); ?></td>
				<?php else : ?>
					<td><?php e($record->class); ?></td>
				<?php endif; ?>
					<td><?php e($record->stream); ?></td>
					<td><?php e($record->organization); ?></td>
					<td><?php e($record->board); ?></td>
					<td><?php e($record->rol_no); ?></td>
					<td><?php e($record->total_marks); ?></td>
					<td><?php e($record->obtained_marks); ?></td>
					<td><?php e($record->pass_year); ?></td>
					<td><?php e($record->registration_no); ?></td>
					<td><?php e($record->created_on); ?></td>
					<td><?php e($record->modified_on); ?></td>
				</tr>
				<?php
					endforeach;
				else:
				?>
				<tr>
					<td colspan='<?php echo $num_columns; ?>'><?php echo lang('qualification_records_empty'); ?></td>
				</tr>
				<?php endif; ?>
			</tbody>
		</table>
	<?php
    echo form_close();
    
    echo $this->pagination->create_links();
    ?>
</div>