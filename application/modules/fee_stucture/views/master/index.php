<?php

$num_columns	= 8;
$can_delete	= $this->auth->has_permission('Fee_Stucture.Master.Delete');
$can_edit		= $this->auth->has_permission('Fee_Stucture.Master.Edit');
$has_records	= isset($records) && is_array($records) && count($records);

if ($can_delete) {
    $num_columns++;
}
?>
<div class='admin-box'>

	<h3>
		<?php echo lang('fee_stucture_area_title'); ?>
	</h3>

	<?php echo form_open($this->uri->uri_string()); ?>
	    <input type="hidden" name="ci_csrf_token" id="ci_csrf_token" value="<?php echo $this->security->get_csrf_hash(); ?>">
		<div class="search_form">
	        <?php // Change the values in this array to populate your dropdown as required
                $options[''] = 'Please select course';
                if(!empty($course)){
                    foreach($course as $row){
                        $options[$row->id] = $row->course_name;
                    }
                }
                echo form_dropdown(array('name' => 'course'), $options, lang('course_wise_subjects_field_course_id'));
            ?>
            <?php // Change the values in this array to populate your dropdown as required
                $options_1[''] = 'Please select year';
                echo form_dropdown(array('name' => 'year_semester'), $options_1, lang('course_wise_subjects_field_year_or_semester_id'));
            ?>
			<div class="control-group">
				<div class="controls">
						<input type="submit" class="btn btn-success" value="search" name="action_search"> 
				</div>
			</div>
		</div>
	<?php echo form_close(); ?>

	<?php echo form_open($this->uri->uri_string()); ?>
		<table class='table table-striped'>
			<thead>
				<tr>
					<?php if ($can_delete && $has_records) : ?>
					<th class='column-check'><input class='check-all' type='checkbox' /></th>
					<?php endif;?>
					
					<th><?php echo lang('fee_stucture_field_fee_head_id'); ?></th>
					<th><?php echo lang('fee_stucture_field_course_id'); ?></th>
					<th><?php echo lang('fee_stucture_field_year_or_semester_id'); ?></th>
					<th><?php echo lang('fee_stucture_field_frequency'); ?></th>
					<th><?php echo lang('fee_stucture_field_amount'); ?></th>
					<th><?php echo lang('fee_stucture_column_created'); ?></th>
					<th><?php echo lang('fee_stucture_column_modified'); ?></th>
				</tr>
			</thead>
			<?php if ($has_records) : ?>
			<tfoot>
				<?php if ($can_delete) : ?>
				<tr>
					<td colspan='<?php echo $num_columns; ?>'>
						<?php echo lang('bf_with_selected'); ?>
						<input type='submit' name='delete' id='delete-me' class='btn btn-danger' value="<?php echo lang('bf_action_delete'); ?>" onclick="return confirm('<?php e(js_escape(lang('fee_stucture_delete_confirm'))); ?>')" />
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
					<td><?php echo anchor(SITE_AREA . '/master/fee_stucture/edit/' . $record->id, '<span class="icon-pencil"></span> ' .  $this->fee_stucture_model->getHeadName($record->fee_head_id)); ?></td>
				<?php else : ?>
					<td><?php e($record->fee_head_id); ?></td>
				<?php endif; ?>
					<td><?php e($this->course_model->course_name($record->course_id)); ?></td>
					<td><?php e($this->course_wise_subjects_model->getYearOrSemesterName($record->year_or_semester_id)); ?></td>
					<td><?php e($record->frequency); ?></td>
					<td><?php e($record->amount); ?></td>
					<td><?php e($record->created_on); ?></td>
					<td><?php e($record->modified_on); ?></td>
				</tr>
				<?php
					endforeach;
				else:
				?>
				<tr>
					<td colspan='<?php echo $num_columns; ?>'><?php echo lang('fee_stucture_records_empty'); ?></td>
				</tr>
				<?php endif; ?>
			</tbody>
		</table>
	<?php
    echo form_close();
    
    echo $this->pagination->create_links();
    ?>
</div>

<style>
.search_form {
    display: flex;
    justify-content: flex-end;
    align-items: baseline;
    -webkit-justify-content: flex-end;
    -webkit-align-items: baseline;
    -moz-justify-content: flex-end;
    -moz-align-items: baseline;
}
.search_form .btn-success {
    border-radius: 0px;
}
select {
    width: 165px;
	border: 1px solid #cccccc;
    border-radius: 0px;
}
button.btn, input[type="submit"].btn {
    margin-bottom: 11px;
}
</style>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script>

    var csrf_token = '<?php echo $this->security->get_csrf_hash(); ?>';

    /* Get State*/

    $('#course').on('change', function() {
        var course_id = $(this).find(":selected").val();
        var htm = '';
        $('#year_semester').html('');
        
        if(course_id!='')
        {
            $.ajax({
                    type:'POST',
                    dataType:'json',
                    url: '<?php echo site_url(SITE_AREA) ?>/master/course_wise_subjects/getYearOrSemester',
                    data: {'ci_csrf_token':csrf_token,'course_id':course_id},
                    success:function(response)
                    {
                        $(response.data).each(function( index, element ) {

                            htm += '<option value='+element.id+'>'+element.year_or_semester_name+'</option>';

                        });
                        csrf_token = response.token;
                        $('#year_semester').html(htm);
                        $('#ci_csrf_token').val(csrf_token);
                    }
            });
        }
    });
</script>