<?php

if (validation_errors()) :
?>
<div class='alert alert-block alert-error fade in'>
    <a class='close' data-dismiss='alert'>&times;</a>
    <h4 class='alert-heading'>
        <?php echo lang('local_address_errors_message'); ?>
    </h4>
    <?php echo validation_errors(); ?>
</div>
<?php
endif;

$id = isset($local_address->id) ? $local_address->id : '';

?>
<div class='admin-box'>
    <h3>Local Address</h3>
    <?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
        <fieldset>
            

            <div class="control-group<?php echo form_error('street_address') ? ' error' : ''; ?>">
                <?php echo form_label(lang('local_address_field_street_address') . lang('bf_form_label_required'), 'street_address', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <?php echo form_textarea(array('name' => 'street_address', 'id' => 'street_address', 'rows' => '5', 'cols' => '80', 'value' => set_value('street_address', isset($local_address->street_address) ? $local_address->street_address : ''), 'required' => 'required')); ?>
                    <span class='help-inline'><?php echo form_error('street_address'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('city') ? ' error' : ''; ?>">
                <?php echo form_label(lang('local_address_field_city') . lang('bf_form_label_required'), 'city', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='city' type='text' required='required' name='city' maxlength='50' value="<?php echo set_value('city', isset($local_address->city) ? $local_address->city : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('city'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('state') ? ' error' : ''; ?>">
                <?php echo form_label(lang('local_address_field_state') . lang('bf_form_label_required'), 'state', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='state' type='text' required='required' name='state' maxlength='50' value="<?php echo set_value('state', isset($local_address->state) ? $local_address->state : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('state'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('zip_code') ? ' error' : ''; ?>">
                <?php echo form_label(lang('local_address_field_zip_code') . lang('bf_form_label_required'), 'zip_code', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='zip_code' type='text' required='required' name='zip_code' maxlength='30' value="<?php echo set_value('zip_code', isset($local_address->zip_code) ? $local_address->zip_code : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('zip_code'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('country') ? ' error' : ''; ?>">
                <?php echo form_label(lang('local_address_field_country') . lang('bf_form_label_required'), 'country', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='country' type='text' required='required' name='country' maxlength='30' value="<?php echo set_value('country', isset($local_address->country) ? $local_address->country : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('country'); ?></span>
                </div>
            </div>
        </fieldset>
        <fieldset class='form-actions'>
            <input type='submit' name='save' class='btn btn-primary' value="<?php echo lang('local_address_action_create'); ?>" />
            <?php echo lang('bf_or'); ?>
            <?php echo anchor(SITE_AREA . '/reports/local_address', lang('local_address_cancel'), 'class="btn btn-warning"'); ?>
            
        </fieldset>
    <?php echo form_close(); ?>
</div>