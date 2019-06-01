<?php

if (validation_errors()) :
?>
<div class='alert alert-block alert-error fade in'>
    <a class='close' data-dismiss='alert'>&times;</a>
    <h4 class='alert-heading'>
        <?php echo lang('subject_errors_message'); ?>
    </h4>
    <?php echo validation_errors(); ?>
</div>
<?php
endif;

$id = isset($subject->id) ? $subject->id : '';

?>
<div class='admin-box'>
    <h3>Subject</h3>
    <?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
        <fieldset>
            

            <div class="control-group<?php echo form_error('title') ? ' error' : ''; ?>">
                <?php echo form_label(lang('subject_field_title') . lang('bf_form_label_required'), 'title', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='title' type='text' required='required' name='title' maxlength='255' value="<?php echo set_value('title', isset($subject->title) ? $subject->title : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('title'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('stream') ? ' error' : ''; ?>">
                <?php echo form_label(lang('subject_field_stream') . lang('bf_form_label_required'), 'stream', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='stream' type='text' required='required' name='stream' maxlength='255' value="<?php echo set_value('stream', isset($subject->stream) ? $subject->stream : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('stream'); ?></span>
                </div>
            </div>
        </fieldset>
        <fieldset class='form-actions'>
            <input type='submit' name='save' class='btn btn-primary' value="<?php echo lang('subject_action_create'); ?>" />
            <?php echo lang('bf_or'); ?>
            <?php echo anchor(SITE_AREA . '/master/subject', lang('subject_cancel'), 'class="btn btn-warning"'); ?>
            
        </fieldset>
    <?php echo form_close(); ?>
</div>