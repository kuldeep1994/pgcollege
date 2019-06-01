<?php

if (validation_errors()) :
?>
<div class='alert alert-block alert-error fade in'>
    <a class='close' data-dismiss='alert'>&times;</a>
    <h4 class='alert-heading'>
        <?php echo lang('fee_heads_errors_message'); ?>
    </h4>
    <?php echo validation_errors(); ?>
</div>
<?php
endif;

$id = isset($fee_heads->id) ? $fee_heads->id : '';

?>
<div class='admin-box'>
    <h3>Fee Heads</h3>
    <?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
        <fieldset>
            

            <div class="control-group<?php echo form_error('fee_head_name') ? ' error' : ''; ?>">
                <?php echo form_label(lang('fee_heads_field_fee_head_name') . lang('bf_form_label_required'), 'fee_head_name', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='fee_head_name' type='text' required='required' name='fee_head_name' maxlength='30' value="<?php echo set_value('fee_head_name', isset($fee_heads->fee_head_name) ? $fee_heads->fee_head_name : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('fee_head_name'); ?></span>
                </div>
            </div>
        </fieldset>
        <fieldset class='form-actions'>
            <input type='submit' name='save' class='btn btn-primary' value="<?php echo lang('fee_heads_action_edit'); ?>" />
            <?php echo lang('bf_or'); ?>
            <?php echo anchor(SITE_AREA . '/master/fee_heads', lang('fee_heads_cancel'), 'class="btn btn-warning"'); ?>
            
            <?php if ($this->auth->has_permission('Fee_Heads.Master.Delete')) : ?>
                <?php echo lang('bf_or'); ?>
                <button type='submit' name='delete' formnovalidate class='btn btn-danger' id='delete-me' onclick="return confirm('<?php e(js_escape(lang('fee_heads_delete_confirm'))); ?>');">
                    <span class='icon-trash icon-white'></span>&nbsp;<?php echo lang('fee_heads_delete_record'); ?>
                </button>
            <?php endif; ?>
        </fieldset>
    <?php echo form_close(); ?>
</div>