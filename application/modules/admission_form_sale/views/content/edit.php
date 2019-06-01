<?php

if (validation_errors()) :
?>
<div class='alert alert-block alert-error fade in'>
    <a class='close' data-dismiss='alert'>&times;</a>
    <h4 class='alert-heading'>
        <?php echo lang('admission_form_sale_errors_message'); ?>
    </h4>
    <?php echo validation_errors(); ?>
</div>
<?php
endif;

$id = isset($admission_form_sale->id) ? $admission_form_sale->id : '';

?>
<div class='admin-box'>
    <h3>Admission Form Sale</h3>
    <?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
        <fieldset>
            
        <div class="span6">
            <div class="control-group<?php echo form_error('academic_year') ? ' error' : ''; ?>">
                <?php echo form_label(lang('admission_form_sale_field_academic_year') . lang('bf_form_label_required'), 'academic_year', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='academic_year' type='text' required='required' name='academic_year' maxlength='100' value="<?php echo set_value('academic_year', isset($admission_form_sale->academic_year) ? $admission_form_sale->academic_year : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('academic_year'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('student_name') ? ' error' : ''; ?>">
                <?php echo form_label(lang('admission_form_sale_field_student_name') . lang('bf_form_label_required'), 'student_name', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='student_name' type='text' required='required' name='student_name' maxlength='100' value="<?php echo set_value('student_name', isset($admission_form_sale->student_name) ? $admission_form_sale->student_name : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('student_name'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('mobile_no') ? ' error' : ''; ?>">
                <?php echo form_label(lang('admission_form_sale_field_mobile_no') . lang('bf_form_label_required'), 'mobile_no', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='mobile_no' type='text' required='required' name='mobile_no'  value="<?php echo set_value('mobile_no', isset($admission_form_sale->mobile_no) ? $admission_form_sale->mobile_no : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('mobile_no'); ?></span>
                </div>
            </div>

            <?php // Change the values in this array to populate your dropdown as required
                if(!empty($course)){
                    $options['']='Please Select Course';
                    foreach($course as $row){
                        $options[$row->id] = $row->course_name;
                    }
                }
                echo form_dropdown(array('name' => 'course', 'required' => 'required'), $options, set_value('course', isset($admission_form_sale->course) ? $admission_form_sale->course : ''), lang('admission_form_sale_field_course') . lang('bf_form_label_required'));
            ?>
        </div>
        <div class="span6">
            <div class="control-group<?php echo form_error('date') ? ' error' : ''; ?>">
                <?php echo form_label(lang('admission_form_sale_field_date') . lang('bf_form_label_required'), 'date', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='date' type='text' required='required' name='date'  value="<?php echo set_value('date', isset($admission_form_sale->date) ? $admission_form_sale->date : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('date'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('father_name') ? ' error' : ''; ?>">
                <?php echo form_label(lang('admission_form_sale_field_father_name') . lang('bf_form_label_required'), 'father_name', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='father_name' type='text' required='required' name='father_name' maxlength='100' value="<?php echo set_value('father_name', isset($admission_form_sale->father_name) ? $admission_form_sale->father_name : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('father_name'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('form_no') ? ' error' : ''; ?>">
                <?php echo form_label(lang('admission_form_sale_field_form_no') . lang('bf_form_label_required'), 'form_no', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='form_no' type='text' required='required' name='form_no'  value="<?php echo set_value('form_no', isset($admission_form_sale->form_no) ? $admission_form_sale->form_no : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('form_no'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('amount') ? ' error' : ''; ?>">
                <?php echo form_label(lang('admission_form_sale_field_amount') . lang('bf_form_label_required'), 'amount', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='amount' type='text' required='required' readonly name='amount' maxlength='255' value="250" />
                    <span class='help-inline'><?php echo form_error('amount'); ?></span>
                </div>
            </div>
        </div>
        </fieldset>
        <fieldset class='form-actions'>
            <input type='submit' name='save' class='btn btn-primary' value="<?php echo lang('admission_form_sale_action_edit'); ?>" />
            <?php echo lang('bf_or'); ?>
            <?php echo anchor(SITE_AREA . '/content/admission_form_sale', lang('admission_form_sale_cancel'), 'class="btn btn-warning"'); ?>
            
            <?php if ($this->auth->has_permission('Admission_Form_Sale.Content.Delete')) : ?>
                <?php echo lang('bf_or'); ?>
                <button type='submit' name='delete' formnovalidate class='btn btn-danger' id='delete-me' onclick="return confirm('<?php e(js_escape(lang('admission_form_sale_delete_confirm'))); ?>');">
                    <span class='icon-trash icon-white'></span>&nbsp;<?php echo lang('admission_form_sale_delete_record'); ?>
                </button>
            <?php endif; ?>
        </fieldset>
    <?php echo form_close(); ?>
</div>