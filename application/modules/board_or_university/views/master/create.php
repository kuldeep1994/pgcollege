<?php

if (validation_errors()) :
?>
<div class='alert alert-block alert-error fade in'>
    <a class='close' data-dismiss='alert'>&times;</a>
    <h4 class='alert-heading'>
        <?php echo lang('board_or_university_errors_message'); ?>
    </h4>
    <?php echo validation_errors(); ?>
</div>
<?php
endif;

$id = isset($board_or_university->id) ? $board_or_university->id : '';

?>
<div class='admin-box'>
    <h3>Board or University</h3>
    <?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
        <fieldset>
            

            <div class="control-group<?php echo form_error('board') ? ' error' : ''; ?>">
                <?php echo form_label(lang('board_or_university_field_board') . lang('bf_form_label_required'), 'board', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='board' type='text' required='required' name='board' maxlength='255' value="<?php echo set_value('board', isset($board_or_university->board) ? $board_or_university->board : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('board'); ?></span>
                </div>
            </div>
        </fieldset>
        <fieldset class='form-actions'>
            <input type='submit' name='save' class='btn btn-primary' value="<?php echo lang('board_or_university_action_create'); ?>" />
            <?php echo lang('bf_or'); ?>
            <?php echo anchor(SITE_AREA . '/master/board_or_university', lang('board_or_university_cancel'), 'class="btn btn-warning"'); ?>
            
        </fieldset>
    <?php echo form_close(); ?>
</div>