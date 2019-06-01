<?php

if (validation_errors()) :
?>
<div class='alert alert-block alert-error fade in'>
    <a class='close' data-dismiss='alert'>&times;</a>
    <h4 class='alert-heading'>
        <?php echo lang('academic_year_errors_message'); ?>
    </h4>
    <?php echo validation_errors(); ?>
</div>
<?php
endif;

$id = isset($academic_year->id) ? $academic_year->id : '';

?>
<div class='admin-box'>
    <h3>Academic Year</h3>
    <?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
        <fieldset>
            

            <div class="control-group<?php echo form_error('academic_year') ? ' error' : ''; ?>">
                <?php echo form_label(lang('academic_year_field_academic_year') . lang('bf_form_label_required'), 'academic_year', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='academic_year' type='text' required='required' name='academic_year' maxlength='255' value="<?php echo set_value('academic_year', isset($academic_year->academic_year) ? $academic_year->academic_year : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('academic_year'); ?></span>
                </div>
            </div>
        </fieldset>
        <fieldset class='form-actions'>
            <input type='submit' name='save' class='btn btn-primary' value="<?php echo lang('academic_year_action_create'); ?>" />
            <?php echo lang('bf_or'); ?>
            <?php echo anchor(SITE_AREA . '/master/academic_year', lang('academic_year_cancel'), 'class="btn btn-warning"'); ?>
            
        </fieldset>
    <?php echo form_close(); ?>
</div>