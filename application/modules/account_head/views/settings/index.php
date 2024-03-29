<?php

$num_columns	= 7;
$can_delete	= $this->auth->has_permission('Account_Head.Settings.Delete');
$can_edit		= $this->auth->has_permission('Account_Head.Settings.Edit');
$has_records	= isset($records) && is_array($records) && count($records);

if ($can_delete) {
    $num_columns++;
}
?>
<div class='admin-box'>
	<h3>
		<?php echo lang('account_head_area_title'); ?>
	</h3>
	<?php echo form_open($this->uri->uri_string()); ?>
		<table class='table table-striped'>
			<thead>
				<tr>
					<?php if ($can_delete && $has_records) : ?>
					<th class='column-check'><input class='check-all' type='checkbox' /></th>
					<?php endif;?>
					
					<th><?php echo lang('account_head_field_head_name'); ?></th>
					<th><?php echo lang('account_head_field_account_group'); ?></th>
					<th><?php echo lang('account_head_field_description'); ?></th>
					<th><?php echo lang('account_head_column_deleted'); ?></th>
					<th><?php echo lang('account_head_column_created'); ?></th>
					<th><?php echo lang('account_head_column_modified'); ?></th>
				</tr>
			</thead>
			<?php if ($has_records) : ?>
			<tfoot>
				<?php if ($can_delete) : ?>
				<tr>
					<td colspan='<?php echo $num_columns; ?>'>
						<?php echo lang('bf_with_selected'); ?>
						<input type='submit' name='delete' id='delete-me' class='btn btn-danger' value="<?php echo lang('bf_action_delete'); ?>" onclick="return confirm('<?php e(js_escape(lang('account_head_delete_confirm'))); ?>')" />
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
					<td><?php echo anchor(SITE_AREA . '/settings/account_head/edit/' . $record->id, '<span class="icon-pencil"></span> ' .  $record->head_name); ?></td>
				<?php else : ?>
					<td><?php e($record->head_name); ?></td>
				<?php endif; ?>
					<td><?php e($record->account_group); ?></td>
					<td><?php e($record->description); ?></td>
					<td><?php echo $record->deleted > 0 ? lang('account_head_true') : lang('account_head_false'); ?></td>
					<td><?php e($record->created_on); ?></td>
					<td><?php e($record->modified_on); ?></td>
				</tr>
				<?php
					endforeach;
				else:
				?>
				<tr>
					<td colspan='<?php echo $num_columns; ?>'><?php echo lang('account_head_records_empty'); ?></td>
				</tr>
				<?php endif; ?>
			</tbody>
		</table>
	<?php
    echo form_close();
    
    ?>
</div>