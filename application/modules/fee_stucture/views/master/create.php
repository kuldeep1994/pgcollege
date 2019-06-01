<?php

if (validation_errors()) :
?>
<div class='alert alert-block alert-error fade in'>
    <a class='close' data-dismiss='alert'>&times;</a>
    <h4 class='alert-heading'>
        <?php echo lang('fee_stucture_errors_message'); ?>
    </h4>
    <?php echo validation_errors(); ?>
</div>
<?php
endif;

$id = isset($fee_stucture->id) ? $fee_stucture->id : '';

?>
<div class='admin-box'>
    <h3>Fee Stucture</h3>
    <?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
        <fieldset>
            
        <input type="hidden" name="ci_csrf_token" id="ci_csrf_token">

            <?php // Change the values in this array to populate your dropdown as required
                $options[''] = 'Please select fee head';
                if(!empty($fee_head)){
                    foreach($fee_head as $row){
                            $options[$row->id] = $row->fee_head_name;
                    }
                }
                
                echo form_dropdown(array('name' => 'fee_head_id', 'required' => 'required'), $options, set_value('fee_head_id', isset($fee_stucture->fee_head_id) ? $fee_stucture->fee_head_id : ''), lang('fee_stucture_field_fee_head_id') . lang('bf_form_label_required'));
            ?>

            <?php // Change the values in this array to populate your dropdown as required

                $options_1[''] = 'Please select class';
                if(!empty($course)){
                    foreach($course as $row){
                            $options_1[$row->id] = $row->course_name;
                    }
                }
                echo form_dropdown(array('name' => 'course_id', 'required' => 'required'), $options_1, set_value('course_id', isset($fee_stucture->course_id) ? $fee_stucture->course_id : ''), lang('fee_stucture_field_course_id') . lang('bf_form_label_required'));
            ?>

            <?php // Change the values in this array to populate your dropdown as required
                $options_2[''] = 'Please select yaer/semester';
                echo form_dropdown(array('name' => 'year_or_semester_id', 'required' => 'required'), $options_2, set_value('year_or_semester_id', isset($fee_stucture->year_or_semester_id) ? $fee_stucture->year_or_semester_id : ''), lang('fee_stucture_field_year_or_semester_id') . lang('bf_form_label_required'));
            ?>

            <div class="control-group<?php echo form_error('frequency') ? ' error' : ''; ?>">
                <?php echo form_label(lang('fee_stucture_field_frequency') . lang('bf_form_label_required'), 'frequency', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='frequency' type='text' required='required' name='frequency' maxlength='30' value="<?php echo set_value('frequency', isset($fee_stucture->frequency) ? $fee_stucture->frequency : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('frequency'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('amount') ? ' error' : ''; ?>">
                <?php echo form_label(lang('fee_stucture_field_amount') . lang('bf_form_label_required'), 'amount', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='amount' type='text' required='required' name='amount' maxlength='255' value="<?php echo set_value('amount', isset($fee_stucture->amount) ? $fee_stucture->amount : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('amount'); ?></span>
                </div>
            </div>
        </fieldset>
        <fieldset class='form-actions'>
            <input type='submit' name='save' class='btn btn-primary' value="<?php echo lang('fee_stucture_action_create'); ?>" />
            <?php echo lang('bf_or'); ?>
            <?php echo anchor(SITE_AREA . '/master/fee_stucture', lang('fee_stucture_cancel'), 'class="btn btn-warning"'); ?>
            
        </fieldset>
    <?php echo form_close(); ?>
</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script>

    var csrf_token = '<?php echo $this->security->get_csrf_hash(); ?>';

    /* Get State*/

    $('#course_id').on('change', function() {
        var course_id = $(this).find(":selected").val();
        var htm = '';
        $('#year_or_semester_id').html('');
        
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
                        $('#year_or_semester_id').html(htm);
                        $('#ci_csrf_token').val(csrf_token);
                    }
            });
        }
    });
</script>