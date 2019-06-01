<div class="image_loader">
	<img src="<?php echo site_url();?>assets/loading.gif"/>
</div>

<?php

if (validation_errors()) :
?>
<div class='alert alert-block alert-error fade in'>
    <a class='close' data-dismiss='alert'>&times;</a>
    <h4 class='alert-heading'>
        <?php echo lang('student_registration_errors_message'); ?>
    </h4>
    <?php echo validation_errors(); ?>
</div>
<?php
endif;

$id = isset($student_registration->id) ? $student_registration->id : '';

?>
<div class='admin-box'>
    <h3>Student Admission</h3>
    <?php echo form_open_multipart($this->uri->uri_string(), 'class="form"'); ?>
        <input type='hidden' id="ci_csrf_token" name="ci_csrf_token" value='<?php echo $this->security->get_csrf_hash(); ?>'>
        
        <fieldset>
            <div class="span6 student_image">
                <!--Student photo upload -->
                <?php $image_name = !empty($admission->student_photo)?$admission->student_photo:'default_user.png'?>
                <img   id="blah" class="photo" src="<?php echo site_url();?>assets/student_photo/<?php echo $image_name; ?>" alt="student image" />
                <?php if($image_name!='default_user.png') { ?>
                <span  data-reg_id="<?php echo !empty($admission->registration_id)?$admission->registration_id:''?>" class="icon-remove remove_student_photo"></span>
                <?php } ?>
                <input type="file"  style="display:none;" name="photo_image" id="imgInp">
                <input type="button" class="btn btn-primary photo_btn" id="upload_image" value="Upload image">
              </div>
            <div class="span6 student_signature">  
                <!--Student signature upload -->
                <?php $signature_name = !empty($admission->student_signature)?$admission->student_signature:'default_signature.png'?>
                <img   id="blahSignature" class="signature" src="<?php echo site_url();?>assets/student_signature/<?php echo $signature_name; ?>" alt="student signature" />
                <?php if($signature_name!='default_signature.png') { ?>
                <span  data-reg_id="<?php echo !empty($admission->registration_id)?$admission->registration_id:''?>" class="icon-remove remove_student_signature"></span>
                <?php } ?>
                <input type="file"  style="display:none;" name="signature_image" id="imgInpSignature">
                <input type="button" class="btn btn-primary signature_btn" id="upload_signature" value="Upload signature">
            </div>
        </fieldset>

        <fieldset>
        <div class="span4">

            <div class="control-group<?php echo form_error('registration_no') ? ' error' : ''; ?>">
                <?php echo form_label(lang('student_registration_field_reg_no') . lang('bf_form_label_required'), 'registration_no', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='registration_no' type='text' required='required' name='registration_no' maxlength='100' value="<?php echo set_value('registration_no', isset($student_registration->registration_no) ? $student_registration->registration_no : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('registration_no'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('gender') ? ' error' : ''; ?>">
                <?php echo form_label(lang('student_registration_field_gender') . lang('bf_form_label_required'), '', array('class' => 'control-label', 'id' => 'gender_label')); ?>
                <div class='controls' aria-labelled-by='gender_label'>
                    <label class='radio' for='gender_option1'>
                        <input id='gender_option1' name='gender' type='radio' required='required' value='male' <?php echo set_radio('gender', 'option1', isset($student_registration->gender) && $student_registration->gender == 'male'); ?> />
                        Male
                    </label>
                    <label class='radio' for='gender_option2'>
                        <input id='gender_option2' name='gender' type='radio' required='required' value='female' <?php echo set_radio('gender', 'option2', isset($student_registration->gender) && $student_registration->gender == 'female'); ?> />
                        Female
                    </label>
                    <span class='help-inline'><?php echo form_error('gender'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('dob') ? ' error' : ''; ?>">
                <div class='controls'>
                <?php echo form_label(lang('student_registration_field_dob') . lang('bf_form_label_required'), 'dob', array('class' => 'control-label')); ?>
                    <input id='dob' type='text' required='required' name='dob' maxlength='50' value="<?php echo set_value('dob', isset($student_registration->dob) ? $student_registration->dob : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('dob'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('birth_place') ? ' error' : ''; ?>">
                <?php echo form_label(lang('student_registration_field_birth_place') . lang('bf_form_label_required'), 'birth_place', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='birth_place' type='text' required='required' name='birth_place' maxlength='30' value="<?php echo set_value('birth_place', isset($admission->birth_place) ? $admission->birth_place : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('birth_place'); ?></span>
                </div>
            </div>

            <?php // Change the values in this array to populate your dropdown as required
                $options = array(
                    '' => 'Please select stream',
                    'science' => 'Science',
                    'arts' => 'Arts',
                );
                echo form_dropdown(array('name' => 'stream_or_branch', 'required' => 'required'), $options, set_value('stream_or_branch', isset($admission->stream_or_branch) ? $admission->stream_or_branch : ''), lang('student_admission_field_stream_or_branch') . lang('bf_form_label_required'));
            ?>

            <?php // Change the values in this array to populate your dropdown as required
                $options = array(
                    10 => 10,
                    20 => 20,
                    30 => 30,
                    40 => 40,
                    50 => 50,
                    60 => 60,
                    70 => 70,
                );
                echo form_dropdown(array('name' => 'status'), $options, set_value('status', isset($admission->status) ? $admission->status : ''), lang('student_admission_field_status'));
            ?>

            <?php // Change the values in this array to populate your dropdown as required
                $nationality_options = array('' => 'Please Select Nationality');
                foreach($countries as $row){
                    $nationality_options[$row->id] = $row->name; 
                }
                echo form_dropdown(array('name' => 'nationality', 'required' => 'required'), $nationality_options, set_value('nationality', isset($student_registration->nationality) ? $student_registration->nationality : ''), lang('student_registration_field_nationality') . lang('bf_form_label_required'));
            ?>

            <?php // Change the values in this array to populate your dropdown as required
                $relegion_options = array(
                                    "" => 'Please Select Relegion',
                                    "Buddhism" => 'Buddhism',
                                    "Hinduism"=>'Hinduism',
                                    "Islam"=>'Islam',
                                    "Jainism"=>'Jainism',
                                    "Judaism"=>'Judaism',
                                    "Nonreligious"=>'Nonreligious',
                                    "Secular"=>'Secular',
                                    "Sikhism"=>'Sikhism',
                                    "primal-indigenous"=>'primal-indigenous',
                                    "Other"=>'Other',
                );
                echo form_dropdown(array('name' => 'relegion', 'required' => 'required'), $relegion_options, set_value('relegion', isset($student_registration->relegion) ? $student_registration->relegion : ''), lang('student_registration_field_relegion') . lang('bf_form_label_required'));
            ?>

            <div class="control-group<?php echo form_error('caste') ? ' error' : ''; ?>">
                <?php echo form_label(lang('student_registration_field_caste') . lang('bf_form_label_required'), 'caste', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='caste' type='text' required='required' name='caste' maxlength='30' value="<?php echo set_value('caste', isset($student_registration->caste) ? $student_registration->caste : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('caste'); ?></span>
                </div>
            </div>

            <?php // Change the values in this array to populate your dropdown as required
                $options = array(
                    '' => 'Please Select Cast Category',
                    'OBC' => 'OBC',
                    'SC' => 'SC',
                    'ST' => 'ST',
                    'GENERAL' => 'GENERAL',
                );
                echo form_dropdown(array('name' => 'cast_category', 'required' => 'required'), $options, set_value('cast_category', isset($student_registration->cast_category) ? $student_registration->cast_category : ''), lang('student_registration_field_cast_category') . lang('bf_form_label_required'));
            ?>

            <?php // Change the values in this array to populate your dropdown as required
                $options_11 = array(
                    '' => 'Please Select Sub Category',
                    'Minority' => 'Minority',
                    'Handicapped' => 'Handicapped',
                    'Freedom Fighter' => 'Freedom Fighter',
                );
                echo form_dropdown(array('name' => 'sub_category', 'required' => 'required'), $options_11, set_value('sub_category', isset($student_registration->sub_category) ? $student_registration->sub_category : ''), lang('student_registration_field_sub_category') . lang('bf_form_label_required'));
            ?>

            <?php // Change the values in this array to populate your dropdown as required
                $options_1[''] = 'Please select fee category';
                if(!empty($fee_cat)){
                    foreach($fee_cat as $row){
                        $options_1[$row->id] = $row->fee_head_name;
                    }
                }
                echo form_dropdown(array('name' => 'fee_category', 'required' => 'required'), $options_1, set_value('fee_category', isset($student_registration->fee_category) ? $student_registration->fee_category : ''), lang('student_registration_field_fee_category') . lang('bf_form_label_required'));
            ?>

        </div>

        <div class="span4">

            <div class="control-group<?php echo form_error('disability') ? ' error' : ''; ?>">
                <?php echo form_label(lang('student_admission_field_disability'), '', array('class' => 'control-label', 'id' => 'disability_label')); ?>
                <div class='controls' aria-labelled-by='disability_label'>
                    <label class='radio' for='disability_option1'>
                        <input id='disability_option1' name='disability' type='radio' value='yes' <?php echo set_radio('disability', 'yes', isset($admission->disability) && $admission->disability == 'yes'); ?> />
                        Yes
                    </label>
                    <label class='radio' for='disability_option2'>
                        <input id='disability_option2' name='disability' type='radio' value='no' <?php echo set_radio('disability', 'no', isset($admission->disability) && $admission->disability == 'no'); ?> />
                        No
                    </label>
                    <span class='help-inline'><?php echo form_error('disability'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('mark_of_identification') ? ' error' : ''; ?>">
                <?php echo form_label(lang('student_admission_field_mark_of_identification') . lang('bf_form_label_required'), 'mark_of_identification', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='mark_of_identification' type='text' required='required' name='mark_of_identification' maxlength='30' value="<?php echo set_value('mark_of_identification', isset($admission->mark_of_identification) ? $admission->mark_of_identification : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('mark_of_identification'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('id') ? ' error' : ''; ?>">
                <?php echo form_label(lang('student_admission_field_id'), 'id', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='student_id' type='text' name='student_id' maxlength='30' value="<?php echo set_value('student_id', isset($admission->student_id) ? $admission->student_id : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('id'); ?></span>
                </div>
            </div>

            <?php // Change the values in this array to populate your dropdown as required
                $options0[''] = 'Please select subject';
                if(!empty($subject)){
                    foreach($subject as $row){
                        $options0[$row->id] = $row->title;
                    }
                }

                echo form_dropdown(array('name' => 'student_subjects[]', 'required' => 'required'), $options0, set_value('student_subjects', isset($student_subject[0]->subject_id) ? $student_subject[0]->subject_id: ''), lang('student_registration_field_subject_1') . lang('bf_form_label_required'));
            ?>

            <?php // Change the values in this array to populate your dropdown as required
                $options1[''] = 'Please select subject';
                if(!empty($subject)){
                    foreach($subject as $row){
                        $options1[$row->id] = $row->title;
                    }
                }

                echo form_dropdown(array('name' => 'student_subjects[]', 'required' => 'required'), $options1, set_value('student_subjects', isset($student_subject[1]->subject_id) ? $student_subject[1]->subject_id: ''), lang('student_registration_field_subject_2') . lang('bf_form_label_required'));
            ?>

            <?php // Change the values in this array to populate your dropdown as required
                $options2[''] = 'Please select subject';
                if(!empty($subject)){
                    foreach($subject as $row){
                        $options2[$row->id] = $row->title;
                    }
                }

                echo form_dropdown(array('name' => 'student_subjects[]', 'required' => 'required'), $options2, set_value('student_subjects', isset($student_subject[2]->subject_id) ? $student_subject[2]->subject_id: ''), lang('student_registration_field_subject_3') . lang('bf_form_label_required'));
            ?>

            <?php // Change the values in this array to populate your dropdown as required
                $options3[''] = 'Please select subject';
                if(!empty($subject)){
                    foreach($subject as $row){
                        $options3[$row->id] = $row->title;
                    }
                }
                
                echo form_dropdown(array('name' => 'student_subjects[]', 'required' => 'required'), $options3, set_value('student_subjects', isset($student_subject[3]->subject_id) ? $student_subject[3]->subject_id: ''), lang('student_registration_field_subject_4') . lang('bf_form_label_required'));
            ?>

            <div class="control-group<?php echo form_error('sr_no') ? ' error' : ''; ?>">
                <?php echo form_label(lang('student_admission_field_sr_no') . lang('bf_form_label_required'), 'sr_no', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='sr_no' type='text' required='required' name='sr_no' maxlength='30' value="<?php echo set_value('sr_no', isset($admission->sr_no) ? $admission->sr_no : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('sr_no'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('student_name') ? ' error' : ''; ?>">
                <?php echo form_label(lang('student_registration_field_student_name') . lang('bf_form_label_required'), 'student_name', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='student_name' type='text' required='required' name='student_name' maxlength='30' value="<?php echo set_value('student_name', isset($student_registration->student_name) ? $student_registration->student_name : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('student_name'); ?></span>
                </div>
            </div>

            <?php // Change the values in this array to populate your dropdown as required
                $option_1[''] = 'Please select course';
                if(!empty($course)){
                    foreach($course as $row){
                        $option_1[$row->id] = $row->course_name;
                    }
                }
                echo form_dropdown(array('name' => 'standard', 'id'=>'course', 'required' => 'required'), $option_1, set_value('standard', isset($admission->course) ? $admission->course : ''), lang('student_registration_field_standard') . lang('bf_form_label_required'));
            ?>

            <?php // Change the values in this array to populate your dropdown as required
                $options_2[''] = 'Please select year';
                if(!empty($year_sem)){
                    foreach($year_sem as $row){
                        $options_2[$row->id] = $row->year_or_semester_name;
                    }
                }
                echo form_dropdown(array('name' => 'year_sem', 'required' => 'required'), $options_2, set_value('year_semester', isset($admission->year_sem) ? $admission->year_sem : ''), lang('student_registration_field_year_semester') . lang('bf_form_label_required'));
            ?>

            <?php // Change the values in this array to populate your dropdown as required
                $options_medium = array(
                    '' => 'Please select fee medium',
                    'Hindi' => 'Hindi',
                    'English' => 'English',
                );
                echo form_dropdown(array('name' => 'medium', 'required' => 'required'), $options_medium, set_value('medium', isset($admission->medium) ? $admission->medium: ''), lang('student_admission_field_medium') . lang('bf_form_label_required'));
            ?>

            <div class="control-group<?php echo form_error('admission_date') ? ' error' : ''; ?>">
                <div class='controls'>
                <?php echo form_label(lang('student_admission_field_admission_date') . lang('bf_form_label_required'), 'admission_date', array('class' => 'control-label')); ?>
                    <input id='dob' type='text' required='required' name='admission_date' maxlength='50' value="<?php echo set_value('admission_date', isset($admission->admission_date) ? $admission->admission_date : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('admission_date'); ?></span>
                </div>
            </div>

        </div>

        <div class="span4">
    
            <div class="control-group<?php echo form_error('pass_out') ? ' error' : ''; ?>">
                <div class='controls'>
                <?php echo form_label(lang('student_registration_field_pass_out') . lang('bf_form_label_required'), 'pass_out', array('class' => 'control-label')); ?>
                    <input id='dob' type='text' required='required' name='pass_out' maxlength='50' value="<?php echo set_value('pass_out', isset($admission->pass_out) ? $admission->pass_out : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('pass_out'); ?></span>
                </div>
            </div>

            <div class="control-group">
                <div class='controls'>
                    <input type="checkbox" required='required' name="tc_issued" <?php echo !empty($admission->tc_issued)?($admission->tc_issued=='issued'?'checked':''):''?> value="issued"> <?php echo lang('student_registration_field_tc_issued') ?>
              &nbsp;<input type="checkbox" required='required' name="promoted" <?php echo !empty($admission->promoted)?($admission->promoted=='promoted'?'checked':''):''?> value="promoted"> <?php echo lang('student_registration_field_promoted') ?>
                </div>
            </div>

            <div class="control-group<?php echo form_error('last_standard') ? ' error' : ''; ?>">
                <div class='controls'>
                <?php echo form_label(lang('student_registration_field_last_standard') . lang('bf_form_label_required'), 'last_standard', array('class' => 'control-label')); ?>
                    <input id='last_standard' type='text' required='required' name='last_standard'  value="<?php echo set_value('last_standard', isset($student_registration->last_standard) ? $student_registration->last_standard : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('last_standard'); ?></span>
                </div>
            </div>

            <?php // Change the values in this array to populate your dropdown as required
                $options_last_school[''] = 'Please select last school';
                if(!empty($last_school)){
                    foreach($last_school as $row){
                        $options_last_school[$row->id] = $row->institute_name;
                    }
                }
                echo form_dropdown(array('name' => 'last_school', 'required' => 'required'), $options_last_school, set_value('last_school', isset($student_registration->last_school) ? $student_registration->last_school : ''), lang('student_registration_field_last_school') . lang('bf_form_label_required'));
            ?>

            <div class="control-group<?php echo form_error('street_address_permanent') ? ' error' : ''; ?>">
                <?php echo form_label(lang('student_registration_field_street_address') . lang('bf_form_label_required'), 'street_address', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <?php echo form_textarea(array('name' => 'street_address_permanent', 'id' => 'street_address_permanent', 'rows' => '5', 'cols' => '80', 'value' => set_value('street_address_permanent', isset($address->street_address) ? $address->street_address : ''), 'required' => 'required')); ?>
                    <span class='help-inline'><?php echo form_error('street_address'); ?></span>
                </div>
            </div>
            
            <?php // Change the values in this array to populate your dropdown as required
                $options11 = array('' => 'Please Select Country');
                foreach($countries as $row){
                    $options11[$row->id] = $row->name; 
                }
                echo form_dropdown(array('name' => 'country_permanent', 'required' => 'required'), $options11, set_value('country_permanent', isset($address->country) ? $address->country : ''), lang('student_registration_field_country') . lang('bf_form_label_required'));
            ?>

            <?php // Change the values in this array to populate your dropdown as required
                $options111 = array('' => 'Please Select State');
                foreach($state as $row){
                    $options111[$row->id] = $row->name; 
                }
                echo form_dropdown(array('name' => 'state_permanent', 'required' => 'required'), $options111, set_value('state_permanent', isset($address->state) ? $address->state : ''), lang('student_registration_field_state') . lang('bf_form_label_required'));
            ?>

            <?php // Change the values in this array to populate your dropdown as required
                $options1111 = array('' => 'Please Select City');
                foreach($city as $row){
                    $options1111[$row->id] = $row->name; 
                }
                echo form_dropdown(array('name' => 'city_permanent', 'required' => 'required'), $options1111, set_value('city_permanent', isset($address->city) ? $address->city : ''), lang('student_registration_field_city') . lang('bf_form_label_required'));
            ?>

            <div class="control-group<?php echo form_error('zip_code_permanent') ? ' error' : ''; ?>">
                <?php echo form_label(lang('student_registration_field_code') . lang('bf_form_label_required'), 'zip_code_permanent', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='zip_code_permanent' type='text' required='required' name='zip_code_permanent' maxlength='30' value="<?php echo set_value('zip_code_permanent', isset($address->zip_code) ? $address->zip_code : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('zip_code_permanent'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('mobile_number') ? ' error' : ''; ?>">
                <div class='controls'>
                <?php echo form_label(lang('student_registration_field_mobile_number'), 'mobile_number', array('class' => 'control-label')); ?>
                    <input id='mobile_number' type='text' name='mobile_number'  value="<?php echo set_value('mobile_number', isset($student_registration->mobile_number) ? $student_registration->mobile_number : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('mobile_number'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('alternate_number') ? ' error' : ''; ?>">
                <div class='controls'>
                <?php echo form_label(lang('student_registration_field_alternate_mobile_number'), 'alternate_mobile_number', array('class' => 'control-label')); ?>
                    <input id='alternate_number' type='text' name='alternate_number'  value="<?php echo set_value('alternate_number', isset($student_registration->alternate_number) ? $student_registration->alternate_number : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('alternate_number'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('email') ? ' error' : ''; ?>">
                <div class='controls'>
                <?php echo form_label(lang('student_registration_field_email'), 'email', array('class' => 'control-label')); ?>
                    <input id='email' type='text' name='email'  value="<?php echo set_value('email', isset($admission->email) ? $admission->email : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('email'); ?></span>
                </div>
            </div>

        </div>

        </fieldset>

        <fieldset class='form-actions'>
            <input type='submit' name='save' class='btn btn-primary' value="<?php echo lang('student_registration_action_create'); ?>" />
            <?php echo lang('bf_or'); ?>
            <?php echo anchor(SITE_AREA . '/content/student_registration', lang('student_registration_cancel'), 'class="btn btn-warning"'); ?>
            
        </fieldset>
    <?php echo form_close(); ?>
</div>
<style>
    .form-horizontal .control-group {
        border-bottom: 1px solid #e5e5e5 !important;
        padding-bottom: 0px !important;
        border-bottom: 0px !important;
        padding-top: 0px !important;
        margin-bottom: 0 !important;
    }

    label, input, button, select, textarea {
        font-size: 12px;
        font-weight: normal;
        line-height: 20px;
    }
    span.heading_modules {
        margin-left: 0;
        font-size: 17px;
        color: #0088cc;
    } 
    .registration_form .span4 {
        width: 30.33%;
        float: left;
    } 
    label {
        font-size: 12px;
        font-weight: 600;
        line-height: 20px;
    }
    .registration_form .controls label {
        text-align: left !important;
        font-weight: 600;
    }
    
    #blah {
        width: 88px;
        height: 84px;
        border: 1px solid;
        border-radius: 7px;
        margin-bottom: 5px;
    }
    #blahSignature { 
        width: 88px;
        height: 84px;
        border: 1px solid;
        border-radius: 7px;
        margin-bottom: 5px;
    }
    .student_image {
        display: flex;
        justify-content: center;
        flex-direction: column;
        align-items: center;
        margin-bottom: 5px;
        position: relative;
    }
    .student_signature {
        display: flex;
        justify-content: center;
        flex-direction: column;
        align-items: center;
        margin-bottom: 5px;
        position: relative;
    }
    table {
        background-color: transparent;
        border-collapse: collapse;
        border-spacing: 0;
        width: 100%;
    }
    .custom_select {
        width: 130px;
    }  
    .custom_input {
        width: 100px;
    }
    label.radio {
        display: inline-block;
    }
    .course{
        width: 93px;
    }
    .photo{
        margin-left:480px;
    }
    .photo_btn{
        margin-left:480px;
    }
    .signature{
        margin-right:451px;
    }
    .signature_btn{
        margin-right:451px;
    }
    .remove_student_photo {
        cursor: pointer;
        top: 2px;
        position: absolute;
        right: 3px;
    }
    .remove_student_signature{
        cursor: pointer;
        top: 2px;
        position: absolute;
        left: 87px;
    }
    .image_loader {
        width: 100%;
        height: 100%;
        display: none;
        justify-content: center;
        align-items: center;
        margin: auto;
        position: fixed;
    }
    .image_loader img {
        width: 200px;
        height: 200px;
        margin: auto;
    }
    .image_loader::after {
        content: '';
        width: 100%;
        height: 100%;
        bottom: 0;
        top: 0;
        right: 0;
        left: 0;
        background-color: #0000003b;
        z-index: 99;
        position: fixed;
    }
}
</style>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script>

$(function(){
$('.admission_course').parent().addClass('parent_course');
});


    //Write code show image of student when we select a image
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#blah').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);

        }
    }
    
    $('#upload_image').click(function(){
       $('#imgInp').trigger('click'); 
    });

    $("#imgInp").change(function(){
        readURL(this);
    });

    //Write code show signature of student when we select a image
    function readURLSignature(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#blahSignature').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);

        }
    }
    
    $('#upload_signature').click(function(){
       $('#imgInpSignature').trigger('click'); 
    });

    $("#imgInpSignature").change(function(){
        readURLSignature(this);
    });

    var csrf_token = '<?php echo $this->security->get_csrf_hash(); ?>';

    //Remove student photo from database (jquery ajax code)

    $('.remove_student_photo').click(function() {

        var reg_id = $(this).data('reg_id');
        
        if(reg_id!='')
        {
            $.ajax({
                    type:'POST',
                    dataType:'json',
                    url: '<?php echo site_url(SITE_AREA) ?>/content/student_registration/removeStudentProfileImage',
                    data: {'ci_csrf_token':csrf_token,'reg_id':reg_id},
                    beforeSend: function(response){
                        $(".image_loader").css({"display":"flex"});
                    },
                    success:function(response)
                    {
                        if(response.msg=='success'){
                            setTimeout(function(){ 
                                location.reload(); 
                            }, 1500);
                        }
                        csrf_token = response.token;
                        $('#ci_csrf_token').val(csrf_token);
                    }
            });
        }
    });

    //Remove student signature from database (jquery ajax code)

    $('.remove_student_signature').click(function() {

    var reg_id = $(this).data('reg_id');

    if(reg_id!='')
    {
        $.ajax({
                type:'POST',
                dataType:'json',
                url: '<?php echo site_url(SITE_AREA) ?>/content/student_registration/removeStudentSignature',
                data: {'ci_csrf_token':csrf_token,'reg_id':reg_id},
                beforeSend: function(response){
                    $(".image_loader").css({"display":"flex"});
                },
                success:function(response)
                {
                    if(response.msg=='success'){
                        setTimeout(function(){ 
                            location.reload(); 
                        }, 1500);
                    }
                    csrf_token = response.token;
                    $('#ci_csrf_token').val(csrf_token);
                }
        });
    }
    });

    /* Get State*/ 

    $('#country_permanent').on('change', function() {
        var country_id = $(this).find(":selected").val();
        var htm = '';
        $('#state').html('');
        
        if(country_id!='')
        {
            $.ajax({
                    type:'POST',
                    dataType:'json',
                    url: '<?php echo site_url(SITE_AREA) ?>/content/student_registration/getStateByCountryId',
                    data: {'ci_csrf_token':csrf_token,'country_id':country_id},
                    success:function(response)
                    {
                        $(response.data).each(function( index, element ) {

                            htm += '<option value='+element.id+'>'+element.name+'</option>';

                        });
                        csrf_token = response.token;
                        $('#state_permanent').html(htm);
                        $('#ci_csrf_token').val(csrf_token);
                    }
            });
        }
    });
    
    /* Get City*/

    $('#state_permanent').on('change', function() {
        var state_id = $(this).find(":selected").val();
        var htm = '';
        $('#city').html('');
        if(state_id!='')
        {
            $.ajax({
                    type:'POST',
                    dataType:'json',
                    url: '<?php echo site_url(SITE_AREA) ?>/content/student_registration/getCityByStateId',
                    data: {'ci_csrf_token':csrf_token,'state_id':state_id},
                    success:function(response)
                    {
                        $(response.data).each(function( index, element ) {

                            htm += '<option value='+element.id+'>'+element.name+'</option>';

                        });
                        csrf_token = response.token;
                        $('#city_permanent').html(htm);
                        $('#ci_csrf_token').val(csrf_token);
                    }
            });
        }
    });


    $('#course').on('change', function() {
        var course = $(this).find(":selected").val();
        $('#student_subject_list').html('');
        var htm_htm = '';
        $('#year_sem').html('');
        
        if(course!='')
        {
            $.ajax({
                    type:'POST',
                    dataType:'json',
                    url: '<?php echo site_url(SITE_AREA) ?>/master/course_wise_subjects/getYearOrSemester',
                    data: {'ci_csrf_token':csrf_token,'course_id':course},
                    success:function(response)
                    {
                        $(response.data).each(function( index, element ) {

                            htm_htm += '<option value='+element.id+'>'+element.year_or_semester_name+'</option>';

                        });
                        csrf_token = response.token;
                        $('#year_sem').html(htm_htm);
                        $('#ci_csrf_token').val(csrf_token);
                    }
            });
        }
    });
</script>