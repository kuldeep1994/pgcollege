<?php

if (validation_errors()) :
?>
<div class='alert alert-block alert-error fade in'>
    <a class='close' data-dismiss='alert'>&times;</a>
    <h4 class='alert-heading'>
        <?php echo lang('organization_errors_message'); ?>
    </h4>
    <?php echo validation_errors(); ?>
</div>
<?php
endif;

$id = isset($organization->id) ? $organization->id : '';

?>
<div class='admin-box'>
    <h3>Organization</h3>
    <?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
        <fieldset>
            

            <div class="control-group<?php echo form_error('organization_name') ? ' error' : ''; ?>">
                <?php echo form_label(lang('organization_field_organization_name') . lang('bf_form_label_required'), 'organization_name', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='organization_name' type='text' required='required' name='organization_name' maxlength='255' value="<?php echo set_value('organization_name', isset($organization->organization_name) ? $organization->organization_name : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('organization_name'); ?></span>
                </div>
            </div>
        </fieldset>
        <fieldset class='form-actions'>
            <input type='submit' name='save' class='btn btn-primary' value="<?php echo lang('organization_action_create'); ?>" />
            <?php echo lang('bf_or'); ?>
            <?php echo anchor(SITE_AREA . '/master/organization', lang('organization_cancel'), 'class="btn btn-warning"'); ?>
            
        </fieldset>
    <?php echo form_close(); ?>
</div>