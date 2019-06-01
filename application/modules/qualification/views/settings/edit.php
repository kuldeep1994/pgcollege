<?php

if (validation_errors()) :
?>
<div class='alert alert-block alert-error fade in'>
    <a class='close' data-dismiss='alert'>&times;</a>
    <h4 class='alert-heading'>
        <?php echo lang('qualification_errors_message'); ?>
    </h4>
    <?php echo validation_errors(); ?>
</div>
<?php
endif;

$id = isset($qualification->id) ? $qualification->id : '';

?>
<div class='admin-box'>
    <h3>Qualification</h3>
    <?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
        <fieldset>
            

            <div class="control-group<?php echo form_error('class') ? ' error' : ''; ?>">
                <?php echo form_label(lang('qualification_field_class') . lang('bf_form_label_required'), 'class', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='class' type='text' required='required' name='class' maxlength='30' value="<?php echo set_value('class', isset($qualification->class) ? $qualification->class : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('class'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('stream') ? ' error' : ''; ?>">
                <?php echo form_label(lang('qualification_field_stream') . lang('bf_form_label_required'), 'stream', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='stream' type='text' required='required' name='stream' maxlength='30' value="<?php echo set_value('stream', isset($qualification->stream) ? $qualification->stream : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('stream'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('organization') ? ' error' : ''; ?>">
                <?php echo form_label(lang('qualification_field_organization') . lang('bf_form_label_required'), 'organization', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='organization' type='text' required='required' name='organization' maxlength='100' value="<?php echo set_value('organization', isset($qualification->organization) ? $qualification->organization : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('organization'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('board') ? ' error' : ''; ?>">
                <?php echo form_label(lang('qualification_field_board') . lang('bf_form_label_required'), 'board', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='board' type='text' required='required' name='board' maxlength='30' value="<?php echo set_value('board', isset($qualification->board) ? $qualification->board : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('board'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('rol_no') ? ' error' : ''; ?>">
                <?php echo form_label(lang('qualification_field_rol_no') . lang('bf_form_label_required'), 'rol_no', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='rol_no' type='text' required='required' name='rol_no' maxlength='55' value="<?php echo set_value('rol_no', isset($qualification->rol_no) ? $qualification->rol_no : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('rol_no'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('total_marks') ? ' error' : ''; ?>">
                <?php echo form_label(lang('qualification_field_total_marks') . lang('bf_form_label_required'), 'total_marks', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='total_marks' type='text' required='required' name='total_marks' maxlength='30' value="<?php echo set_value('total_marks', isset($qualification->total_marks) ? $qualification->total_marks : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('total_marks'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('obtained_marks') ? ' error' : ''; ?>">
                <?php echo form_label(lang('qualification_field_obtained_marks') . lang('bf_form_label_required'), 'obtained_marks', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='obtained_marks' type='text' required='required' name='obtained_marks' maxlength='100' value="<?php echo set_value('obtained_marks', isset($qualification->obtained_marks) ? $qualification->obtained_marks : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('obtained_marks'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('pass_year') ? ' error' : ''; ?>">
                <?php echo form_label(lang('qualification_field_pass_year') . lang('bf_form_label_required'), 'pass_year', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='pass_year' type='text' required='required' name='pass_year' maxlength='30' value="<?php echo set_value('pass_year', isset($qualification->pass_year) ? $qualification->pass_year : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('pass_year'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('registration_no') ? ' error' : ''; ?>">
                <?php echo form_label(lang('qualification_field_registration_no') . lang('bf_form_label_required'), 'registration_no', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='registration_no' type='text' required='required' name='registration_no' maxlength='30' value="<?php echo set_value('registration_no', isset($qualification->registration_no) ? $qualification->registration_no : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('registration_no'); ?></span>
                </div>
            </div>
        </fieldset>
        <fieldset class='form-actions'>
            <input type='submit' name='save' class='btn btn-primary' value="<?php echo lang('qualification_action_edit'); ?>" />
            <?php echo lang('bf_or'); ?>
            <?php echo anchor(SITE_AREA . '/settings/qualification', lang('qualification_cancel'), 'class="btn btn-warning"'); ?>
            
            <?php if ($this->auth->has_permission('Qualification.Settings.Delete')) : ?>
                <?php echo lang('bf_or'); ?>
                <button type='submit' name='delete' formnovalidate class='btn btn-danger' id='delete-me' onclick="return confirm('<?php e(js_escape(lang('qualification_delete_confirm'))); ?>');">
                    <span class='icon-trash icon-white'></span>&nbsp;<?php echo lang('qualification_delete_record'); ?>
                </button>
            <?php endif; ?>
        </fieldset>
    <?php echo form_close(); ?>
</div>