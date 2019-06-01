<?php

if (validation_errors()) :
?>
<div class='alert alert-block alert-error fade in'>
    <a class='close' data-dismiss='alert'>&times;</a>
    <h4 class='alert-heading'>
        <?php echo lang('account_head_errors_message'); ?>
    </h4>
    <?php echo validation_errors(); ?>
</div>
<?php
endif;

$id = isset($account_head->id) ? $account_head->id : '';

?>
<div class='admin-box'>
    <h3>Account Head</h3>
    <?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
        <fieldset>
            

            <div class="control-group<?php echo form_error('head_name') ? ' error' : ''; ?>">
                <?php echo form_label(lang('account_head_field_head_name') . lang('bf_form_label_required'), 'head_name', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='head_name' type='text' required='required' name='head_name' maxlength='255' value="<?php echo set_value('head_name', isset($account_head->head_name) ? $account_head->head_name : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('head_name'); ?></span>
                </div>
            </div>

            <?php // Change the values in this array to populate your dropdown as required
                $options = array(
                    30 => 30,
                );
                echo form_dropdown(array('name' => 'account_group', 'required' => 'required'), $options, set_value('account_group', isset($account_head->account_group) ? $account_head->account_group : ''), lang('account_head_field_account_group') . lang('bf_form_label_required'));
            ?>

            <div class="control-group<?php echo form_error('description') ? ' error' : ''; ?>">
                <?php echo form_label(lang('account_head_field_description') . lang('bf_form_label_required'), 'description', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <?php echo form_textarea(array('name' => 'description', 'id' => 'description', 'rows' => '5', 'cols' => '80', 'value' => set_value('description', isset($account_head->description) ? $account_head->description : ''), 'required' => 'required')); ?>
                    <span class='help-inline'><?php echo form_error('description'); ?></span>
                </div>
            </div>
        </fieldset>
        <fieldset class='form-actions'>
            <input type='submit' name='save' class='btn btn-primary' value="<?php echo lang('account_head_action_edit'); ?>" />
            <?php echo lang('bf_or'); ?>
            <?php echo anchor(SITE_AREA . '/reports/account_head', lang('account_head_cancel'), 'class="btn btn-warning"'); ?>
            
            <?php if ($this->auth->has_permission('Account_Head.Reports.Delete')) : ?>
                <?php echo lang('bf_or'); ?>
                <button type='submit' name='delete' formnovalidate class='btn btn-danger' id='delete-me' onclick="return confirm('<?php e(js_escape(lang('account_head_delete_confirm'))); ?>');">
                    <span class='icon-trash icon-white'></span>&nbsp;<?php echo lang('account_head_delete_record'); ?>
                </button>
            <?php endif; ?>
        </fieldset>
    <?php echo form_close(); ?>
</div>