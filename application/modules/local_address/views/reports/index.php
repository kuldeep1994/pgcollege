<?php

$num_columns	= 6;
$can_delete	= $this->auth->has_permission('Local_Address.Reports.Delete');
$can_edit		= $this->auth->has_permission('Local_Address.Reports.Edit');
$has_records	= isset($records) && is_array($records) && count($records);

if ($can_delete) {
    $num_columns++;
}
?>
<div class='admin-box'>
	<h3>
		<?php echo lang('local_address_area_title'); ?>
	</h3>
	<?php echo form_open($this->uri->uri_string()); ?>
		<table class='table table-striped'>
			<thead>
				<tr>
					<?php if ($can_delete && $has_records) : ?>
					<th class='column-check'><input class='check-all' type='checkbox' /></th>
					<?php endif;?>
					
					<th><?php echo lang('local_address_field_street_address'); ?></th>
					<th><?php echo lang('local_address_field_city'); ?></th>
					<th><?php echo lang('local_address_field_state'); ?></th>
					<th><?php echo lang('local_address_field_zip_code'); ?></th>
					<th><?php echo lang('local_address_field_country'); ?></th>
				</tr>
			</thead>
			<?php if ($has_records) : ?>
			<tfoot>
				<?php if ($can_delete) : ?>
				<tr>
					<td colspan='<?php echo $num_columns; ?>'>
						<?php echo lang('bf_with_selected'); ?>
						<input type='submit' name='delete' id='delete-me' class='btn btn-danger' value="<?php echo lang('bf_action_delete'); ?>" onclick="return confirm('<?php e(js_escape(lang('local_address_delete_confirm'))); ?>')" />
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
					<td><?php echo anchor(SITE_AREA . '/reports/local_address/edit/' . $record->id, '<span class="icon-pencil"></span> ' .  $record->street_address); ?></td>
				<?php else : ?>
					<td><?php e($record->street_address); ?></td>
				<?php endif; ?>
					<td><?php e($record->city); ?></td>
					<td><?php e($record->state); ?></td>
					<td><?php e($record->zip_code); ?></td>
					<td><?php e($record->country); ?></td>
				</tr>
				<?php
					endforeach;
				else:
				?>
				<tr>
					<td colspan='<?php echo $num_columns; ?>'><?php echo lang('local_address_records_empty'); ?></td>
				</tr>
				<?php endif; ?>
			</tbody>
		</table>
	<?php
    echo form_close();
    
    ?>
</div>