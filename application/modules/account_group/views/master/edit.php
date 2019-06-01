<?php

if (validation_errors()) :
?>
<div class='alert alert-block alert-error fade in'>
    <a class='close' data-dismiss='alert'>&times;</a>
    <h4 class='alert-heading'>
        <?php echo lang('account_group_errors_message'); ?>
    </h4>
    <?php echo validation_errors(); ?>
</div>
<?php
endif;

$id = isset($account_group->id) ? $account_group->id : '';

?>
<div class='admin-box'>
    <h3>Account Group</h3>
    <?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
        <fieldset>
            

            <div class="control-group<?php echo form_error('group_name') ? ' error' : ''; ?>">
                <?php echo form_label(lang('account_group_field_group_name') . lang('bf_form_label_required'), 'group_name', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='group_name' type='text' required='required' name='group_name' maxlength='255' value="<?php echo set_value('group_name', isset($account_group->group_name) ? $account_group->group_name : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('group_name'); ?></span>
                </div>
            </div>

            <?php // Change the values in this array to populate your dropdown as required
                $options = array('' => 'Please Select Parent Group');
                foreach($group as $row){
                    $options[$row->id] = $row->group_name; 
                }
                echo form_dropdown(array('name' => 'parent_group'), $options, set_value('parent_group', isset($account_group->parent_group) ? $account_group->parent_group : ''), lang('account_group_field_parent_group') . lang('bf_form_label_required'));
            ?>

            <div class="control-group<?php echo form_error('description') ? ' error' : ''; ?>">
                <?php echo form_label(lang('account_group_field_description') . lang('bf_form_label_required'), 'description', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <?php echo form_textarea(array('name' => 'description', 'id' => 'description', 'rows' => '5', 'cols' => '80', 'value' => set_value('description', isset($account_group->description) ? $account_group->description : ''), 'required' => 'required')); ?>
                    <span class='help-inline'><?php echo form_error('description'); ?></span>
                </div>
            </div>

        </fieldset>
        <fieldset class='form-actions'>
            <input type='submit' name='save' class='btn btn-primary' value="<?php echo lang('account_group_action_edit'); ?>" />
            <?php echo lang('bf_or'); ?>
            <?php echo anchor(SITE_AREA . '/content/account_group', lang('account_group_cancel'), 'class="btn btn-warning"'); ?>
            
            <?php if ($this->auth->has_permission('Account_Group.Content.Delete')) : ?>
                <?php echo lang('bf_or'); ?>
                <button type='submit' name='delete' formnovalidate class='btn btn-danger' id='delete-me' onclick="return confirm('<?php e(js_escape(lang('account_group_delete_confirm'))); ?>');">
                    <span class='icon-trash icon-white'></span>&nbsp;<?php echo lang('account_group_delete_record'); ?>
                </button>
            <?php endif; ?>
        </fieldset>
    <?php echo form_close(); ?>
</div>