<?php

if (validation_errors()) :
?>
<div class='alert alert-block alert-error fade in'>
    <a class='close' data-dismiss='alert'>&times;</a>
    <h4 class='alert-heading'>
        <?php echo lang('year_or_semester_errors_message'); ?>
    </h4>
    <?php echo validation_errors(); ?>
</div>
<?php
endif;

$id = isset($year_or_semester->id) ? $year_or_semester->id : '';

?>
<div class='admin-box'>
    <h3>Year or Semester</h3>
    <?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
        <fieldset>

            <?php // Change the values in this array to populate your dropdown as required
                $options[''] = 'Please select class';
                if(!empty($course)){
                    foreach($course as $row){
                        $options[$row->id] = $row->course_name;
                    }
                }
                echo form_dropdown(array('name' => 'course_id', 'required' => 'required'), $options, set_value('course_id', isset($year_or_semester->course_id) ? $year_or_semester->course_id : ''), lang('year_or_semester_field_course_id') . lang('bf_form_label_required'));
            ?>

            <div class="control-group<?php echo form_error('year_or_semester_name') ? ' error' : ''; ?>">
                <?php echo form_label(lang('year_or_semester_field_year_or_semester_name') . lang('bf_form_label_required'), 'year_or_semester_name', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='year_or_semester_name' type='text' required='required' name='year_or_semester_name' maxlength='50' value="<?php echo set_value('year_or_semester_name', isset($year_or_semester->year_or_semester_name) ? $year_or_semester->year_or_semester_name : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('year_or_semester_name'); ?></span>
                </div>
            </div>
        </fieldset>
        <fieldset class='form-actions'>
            <input type='submit' name='save' class='btn btn-primary' value="<?php echo lang('year_or_semester_action_create'); ?>" />
            <?php echo lang('bf_or'); ?>
            <?php echo anchor(SITE_AREA . '/master/year_or_semester', lang('year_or_semester_cancel'), 'class="btn btn-warning"'); ?>
            
        </fieldset>
    <?php echo form_close(); ?>
</div>