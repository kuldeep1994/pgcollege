<?php

if (validation_errors()) :
?>
<div class='alert alert-block alert-error fade in'>
    <a class='close' data-dismiss='alert'>&times;</a>
    <h4 class='alert-heading'>
        <?php echo lang('course_errors_message'); ?>
    </h4>
    <?php echo validation_errors(); ?>
</div>
<?php
endif;

$id = isset($course->id) ? $course->id : '';

?>
<div class='admin-box'>
    <h3>Course</h3>
    <?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
        <fieldset>
            

            <div class="control-group<?php echo form_error('course_name') ? ' error' : ''; ?>">
                <?php echo form_label(lang('course_field_course_name') . lang('bf_form_label_required'), 'course_name', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='course_name' type='text' required='required' name='course_name' maxlength='100' value="<?php echo set_value('course_name', isset($course->course_name) ? $course->course_name : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('course_name'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('stream') ? ' error' : ''; ?>">
                <?php echo form_label(lang('course_field_stream') . lang('bf_form_label_required'), 'stream', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='stream' type='text' required='required' name='stream' maxlength='100' value="<?php echo set_value('stream', isset($course->stream) ? $course->stream : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('stream'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('frequency') ? ' error' : ''; ?>">
                <?php echo form_label(lang('course_field_frequency') . lang('bf_form_label_required'), 'frequency', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='frequency' type='text' required='required' name='frequency' maxlength='100' value="<?php echo set_value('frequency', isset($course->frequency) ? $course->frequency : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('frequency'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('no_of_frequency') ? ' error' : ''; ?>">
                <?php echo form_label(lang('course_field_no_of_frequency') . lang('bf_form_label_required'), 'no_of_frequency', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='no_of_frequency' type='text' required='required' name='no_of_frequency'  value="<?php echo set_value('no_of_frequency', isset($course->no_of_frequency) ? $course->no_of_frequency : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('no_of_frequency'); ?></span>
                </div>
            </div>
        </fieldset>
        <fieldset class='form-actions'>
            <input type='submit' name='save' class='btn btn-primary' value="<?php echo lang('course_action_create'); ?>" />
            <?php echo lang('bf_or'); ?>
            <?php echo anchor(SITE_AREA . '/master/course', lang('course_cancel'), 'class="btn btn-warning"'); ?>
            
        </fieldset>
    <?php echo form_close(); ?>
</div>