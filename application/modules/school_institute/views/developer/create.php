<?php

if (validation_errors()) :
?>
<div class='alert alert-block alert-error fade in'>
    <a class='close' data-dismiss='alert'>&times;</a>
    <h4 class='alert-heading'>
        <?php echo lang('school_institute_errors_message'); ?>
    </h4>
    <?php echo validation_errors(); ?>
</div>
<?php
endif;

$id = isset($school_institute->id) ? $school_institute->id : '';

?>
<div class='admin-box'>
    <h3>School-Institute</h3>
    <?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
        <fieldset>
            

            <div class="control-group<?php echo form_error('institute_name') ? ' error' : ''; ?>">
                <?php echo form_label(lang('school_institute_field_institute_name') . lang('bf_form_label_required'), 'institute_name', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='institute_name' type='text' required='required' name='institute_name' maxlength='255' value="<?php echo set_value('institute_name', isset($school_institute->institute_name) ? $school_institute->institute_name : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('institute_name'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('address') ? ' error' : ''; ?>">
                <?php echo form_label(lang('school_institute_field_address'), 'address', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <?php echo form_textarea(array('name' => 'address', 'id' => 'address', 'rows' => '5', 'cols' => '80', 'value' => set_value('address', isset($school_institute->address) ? $school_institute->address : ''))); ?>
                    <span class='help-inline'><?php echo form_error('address'); ?></span>
                </div>
            </div>

            <?php // Change the values in this array to populate your dropdown as required
                $options = array(
                    50 => 50,
                );
                echo form_dropdown(array('name' => 'city', 'required' => 'required'), $options, set_value('city', isset($school_institute->city) ? $school_institute->city : ''), lang('school_institute_field_city') . lang('bf_form_label_required'));
            ?>

            <?php // Change the values in this array to populate your dropdown as required
                $options = array(
                    30 => 30,
                );
                echo form_dropdown(array('name' => 'state', 'required' => 'required'), $options, set_value('state', isset($school_institute->state) ? $school_institute->state : ''), lang('school_institute_field_state') . lang('bf_form_label_required'));
            ?>

            <div class="control-group<?php echo form_error('zip_code') ? ' error' : ''; ?>">
                <?php echo form_label(lang('school_institute_field_zip_code') . lang('bf_form_label_required'), 'zip_code', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='zip_code' type='text' required='required' name='zip_code' maxlength='30' value="<?php echo set_value('zip_code', isset($school_institute->zip_code) ? $school_institute->zip_code : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('zip_code'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('country') ? ' error' : ''; ?>">
                <?php echo form_label(lang('school_institute_field_country') . lang('bf_form_label_required'), 'country', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='country' type='text' required='required' name='country' maxlength='30' value="<?php echo set_value('country', isset($school_institute->country) ? $school_institute->country : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('country'); ?></span>
                </div>
            </div>
        </fieldset>
        <fieldset class='form-actions'>
            <input type='submit' name='save' class='btn btn-primary' value="<?php echo lang('school_institute_action_create'); ?>" />
            <?php echo lang('bf_or'); ?>
            <?php echo anchor(SITE_AREA . '/developer/school_institute', lang('school_institute_cancel'), 'class="btn btn-warning"'); ?>
            
        </fieldset>
    <?php echo form_close(); ?>
</div>