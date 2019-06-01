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
    <h3>Student Registration</h3>
    <?php echo form_open_multipart($this->uri->uri_string(), 'class="form"'); ?>
        <input type='hidden' id="ci_csrf_token" name="ci_csrf_token" value='<?php echo $this->security->get_csrf_hash(); ?>'>

        <fieldset>
        <div class="span4">

            <div class="control-group<?php echo form_error('v_no') ? ' error' : ''; ?>">
                <?php echo form_label(lang('student_registration_field_v_no') . lang('bf_form_label_required'), 'v_no', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='v_no' type='text' required='required' name='v_no' maxlength='100' value="<?php echo set_value('v_no', isset($student_registration->v_no) ? $student_registration->v_no : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('v_no'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('registration_no') ? ' error' : ''; ?>">
                <?php echo form_label(lang('student_registration_field_registration_no') . lang('bf_form_label_required'), 'registration_no', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='registration_no' type='text' required='required' name='registration_no' maxlength='100' value="<?php echo set_value('registration_no', isset($student_registration->registration_no) ? $student_registration->registration_no : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('registration_no'); ?></span>
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
                $course_option[''] = 'Please select standard';
                if(!empty($course)) { 
                    foreach($course as $row) { 
                        $course_option[$row->id] = $row->course_name;
                    }
                }
                echo form_dropdown(array('name' => 'standard', 'required' => 'required'), $course_option, set_value('standard', isset($student_registration->standard) ? $student_registration->standard : ''), lang('student_registration_field_standard') . lang('bf_form_label_required'));
            ?>

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

            <?php // Change the values in this array to populate your dropdown as required
                $nationality_options = array('' => 'Please Select Country');
                foreach($countries as $row){
                    $nationality_options[$row->id] = $row->name; 
                }
                echo form_dropdown(array('name' => 'nationality', 'required' => 'required'), $nationality_options, set_value('nationality', isset($student_registration->nationality) ? $student_registration->nationality : ''), lang('student_registration_field_nationality') . lang('bf_form_label_required'));
            ?>

            <?php // Change the values in this array to populate your dropdown as required
                $relegion_options = array(
                                    '' => 'Please Select Relegion',
                                    'Buddhism' => 'Buddhism',
                                    'Hinduism'=>'Hinduism',
                                    'Islam'=>'Islam',
                                    'Jainism'=>'Jainism',
                                    'Judaism'=>'Judaism',
                                    'Nonreligious'=>'Nonreligious',
                                    'Secular'=>'Secular',
                                    'Sikhism'=>'Sikhism',
                                    'primal-indigenous'=>'primal-indigenous',
                                    'Other'=>'Other',
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

            <div class="control-group<?php echo form_error('father_name') ? ' error' : ''; ?>">
                <?php echo form_label(lang('student_registration_field_father_name') . lang('bf_form_label_required'), 'father_name', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='father_name' type='text' required='required' name='father_name' maxlength='30' value="<?php echo set_value('father_name', isset($student_registration->father_name) ? $student_registration->father_name : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('father_name'); ?></span>
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

            <div class="control-group<?php echo form_error('date') ? ' error' : ''; ?>">
                <div class='controls'>
                <?php echo form_label(lang('student_registration_field_date') . lang('bf_form_label_required'), 'date', array('class' => 'control-label')); ?>
                    <input id='date' type='text' required='required' name='date' maxlength='50' value="<?php echo set_value('date', isset($student_registration->date) ? $student_registration->date : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('date'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('test_date') ? ' error' : ''; ?>">
                <div class='controls'>
                <?php echo form_label(lang('student_registration_field_test_date') . lang('bf_form_label_required'), 'test_date', array('class' => 'control-label')); ?>
                    <input id='test_date' type='text' required='required' name='test_date' maxlength='50' value="<?php echo set_value('date', isset($student_registration->test_date) ? $student_registration->test_date : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('test_date'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('dob') ? ' error' : ''; ?>">
                <div class='controls'>
                <?php echo form_label(lang('student_registration_field_dob') . lang('bf_form_label_required'), 'dob', array('class' => 'control-label')); ?>
                    <input id='dob' type='text' required='required' name='dob' maxlength='50' value="<?php echo set_value('dob', isset($student_registration->dob) ? $student_registration->dob : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('dob'); ?></span>
                </div>
            </div>

        </div>

        <div class="span4">

            <?php // Change the values in this array to populate your dropdown as required
                $options0[''] = 'Please select subject';
                if(!empty($subject)){
                    foreach($subject as $row){
                        $options0[$row->id] = $row->title;
                    }
                }

                echo form_dropdown(array('name' => 'test_subjects[]', 'required' => 'required'), $options0, set_value('test_subjects', isset($student_subject[0]) ? $student_subject[0]: ''), lang('student_registration_field_subject_1') . lang('bf_form_label_required'));
            ?>

            <?php // Change the values in this array to populate your dropdown as required
                $options1[''] = 'Please select subject';
                if(!empty($subject)){
                    foreach($subject as $row){
                        $options1[$row->id] = $row->title;
                    }
                }

                echo form_dropdown(array('name' => 'test_subjects[]', 'required' => 'required'), $options1, set_value('test_subjects', isset($student_subject[1]) ? $student_subject[1]: ''), lang('student_registration_field_subject_2') . lang('bf_form_label_required'));
            ?>

            <?php // Change the values in this array to populate your dropdown as required
                $options2[''] = 'Please select subject';
                if(!empty($subject)){
                    foreach($subject as $row){
                        $options2[$row->id] = $row->title;
                    }
                }

                echo form_dropdown(array('name' => 'test_subjects[]', 'required' => 'required'), $options2, set_value('test_subjects', isset($student_subject[2]) ? $student_subject[2]: ''), lang('student_registration_field_subject_3') . lang('bf_form_label_required'));
            ?>

            <?php // Change the values in this array to populate your dropdown as required
                $options3[''] = 'Please select subject';
                if(!empty($subject)){
                    foreach($subject as $row){
                        $options3[$row->id] = $row->title;
                    }
                }
                
                echo form_dropdown(array('name' => 'test_subjects[]', 'required' => 'required'), $options3, set_value('test_subjects', isset($student_subject[3]) ? $student_subject[3]: ''), lang('student_registration_field_subject_4') . lang('bf_form_label_required'));
            ?>

            <input type="hidden" name="subjects" value="">

            <div class="control-group<?php echo form_error('mother_name') ? ' error' : ''; ?>">
                <?php echo form_label(lang('student_registration_field_mother_name') . lang('bf_form_label_required'), 'mother_name', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='mother_name' type='text' required='required' name='mother_name' maxlength='30' value="<?php echo set_value('mother_name', isset($student_registration->mother_name) ? $student_registration->mother_name : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('mother_name'); ?></span>
                </div>
            </div>

            <?php // Change the values in this array to populate your dropdown as required
                $options_Last_Standard = array(
                    '' => 'Please Select Last Standard',
                    '12th' => '12th',
                    'B.A' => 'B.A',
                    'B.Sc' => 'B.Sc',
                );
                echo form_dropdown(array('name' => 'last_standard', 'required' => 'required'), $options_Last_Standard, set_value('last_standard', isset($student_registration->last_standard) ? $student_registration->last_standard : ''), lang('student_registration_field_last_standard') . lang('bf_form_label_required'));
            ?>

            <div class="control-group<?php echo form_error('registration_fee') ? ' error' : ''; ?>">
                <div class='controls'>
                <?php echo form_label(lang('student_registration_field_registration_fee'), 'registration_fee', array('class' => 'control-label')); ?>
                    <input id='registration_fee' type='text' name='registration_fee' maxlength='100' value="<?php echo set_value('registration_fee', isset($student_registration->registration_fee) ? $student_registration->registration_fee : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('registration_fee'); ?></span>
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

            <div class="control-group<?php echo form_error('annual_income') ? ' error' : ''; ?>">
                <?php echo form_label(lang('student_registration_field_annual_income'), 'annual_income', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='annual_income' type='text' name='annual_income' maxlength='255' value="<?php echo set_value('annual_income', isset($student_registration->annual_income) ? $student_registration->annual_income : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('annual_income'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('aadhar_number') ? ' error' : ''; ?>">
                <div class='controls'>
                <?php echo form_label(lang('student_registration_field_aadhar_number') . lang('bf_form_label_required'), 'aadhar_number', array('class' => 'control-label')); ?>
                    <input id='aadhar_number' type='text' required='required' name='aadhar_number'  value="<?php echo set_value('aadhar_number', isset($student_registration->aadhar_number) ? $student_registration->aadhar_number : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('aadhar_number'); ?></span>
                </div>
            </div>

        </div>

        </fieldset>

        <fieldset>
        <div class="span12">

            <span class="heading_modules"><?php echo lang('school_institute_field_qualification');?></span>
            
            <table>
                <thead>
                    <tr>
                        <th>Class</th>
                        <th>Stream</th>
                        <th>Organization name</th>
                        <th>Board/Univ.</th>
                        <th>Roll No.</th>
                        <th>Max Mark</th>
                        <th>Obtained Mark</th>
                        <th>%(Percentage)</th>
                        <th>Year</th>
                    </tr>
                </thead>
                <tbody>

                    <tr>
                    <td>
                    <?php 
                        // Change the values in this array to populate your dropdown as required
                        $options = array(
                            ''            => 'Please select class',
                            'High School' => 'High School',
                            'Intermediate'=> 'Intermediate',
                            'Diploma'     => 'Diploma',
                        );
                       echo form_dropdown(array('name' => 'class[]', 'id'=>'class', 'required' => 'required','class'=>'custom_select'), $options, set_value('class', isset($qualification[0]->class) ? $qualification[0]->class : ''));
                    ?>
                    </td>
                    <td>
                    <?php 
                        // Change the values in this array to populate your dropdown as required
                        $options = array(
                            ''        => 'Please select stream',
                            'science' => 'science',
                            'arts'    => 'arts',
                        );
                       echo form_dropdown(array('name' => 'stream[]', 'required' => 'required','class'=>'custom_select'), $options, set_value('stream', isset($qualification[0]->stream) ? $qualification[0]->stream : ''));
                    ?>
                    </td>
                    <td>
                    <?php 
                        // Change the values in this array to populate your dropdown as required
                        $organization_options[''] = 'Please select organization';
                        if(!empty($organization)){
                            foreach($organization as $row){
                                $organization_options[$row->id] = $row->organization_name;
                            }
                        }
                       echo form_dropdown(array('name' => 'organization[]', 'required' => 'required','class'=>'custom_select'), $organization_options, set_value('organization', isset($qualification[0]->organization) ? $qualification[0]->organization : ''));
                    ?>
                    </td>
                    <td>
                    <?php 
                        // Change the values in this array to populate your dropdown as required
                        $board_options[''] = 'Please select board or university';
                        if(!empty($board)){
                            foreach($board as $row){
                                $board_options[$row->id] = $row->board;
                            }
                        }
                        echo form_dropdown(array('name' => 'board[]', 'id'=>'board', 'required' => 'required','class'=>'custom_select'), $board_options, set_value('board', isset($qualification[0]->board) ? $qualification[0]->board : ''));
                    ?>
                    </td>
                    <td><input id='roll_no' class="custom_input" type='text' required='required' name='roll_no[]'  value="<?php echo set_value('roll_no', isset($qualification[0]->roll_no) ? $qualification[0]->roll_no : ''); ?>" /></td>
                    <td><input id='total_marks' class="custom_input" type='text' required='required' name='total_marks[]'  value="<?php echo set_value('total_marks', isset($qualification[0]->total_marks) ? $qualification[0]->total_marks : ''); ?>" /></td>
                    <td><input id='obtained_mark' class="custom_input" type='text' required='required' name='obtained_mark[]'  value="<?php echo set_value('obtained_mark', isset($qualification[0]->obtained_marks) ? $qualification[0]->obtained_marks : ''); ?>" /></td>
                    <td><input id='percentage' class="custom_input" type='text' required='required' name='percentage[]'  value="<?php echo set_value('percentage', isset($qualification[0]->percentage) ? $qualification[0]->percentage : ''); ?>" /></td>
                    <td><input id='pass_year' class="custom_input" type='text' required='required' name='pass_year[]'  value="<?php echo set_value('pass_year', isset($qualification[0]->pass_year) ? $qualification[0]->pass_year : ''); ?>" /></td>
                    </tr>


                    <tr>
                    <td>
                    <?php 
                        // Change the values in this array to populate your dropdown as required
                        $options = array(
                            ''            => 'Please select class',
                            'High School' => 'High School',
                            'Intermediate'=> 'Intermediate',
                            'Diploma'     => 'Diploma',
                        );
                       echo form_dropdown(array('name' => 'class[]', 'id'=>'class', 'required' => 'required','class'=>'custom_select'), $options, set_value('class', isset($qualification[1]->class) ? $qualification[1]->class : ''));
                    ?>
                    </td>
                    <td>
                    <?php 
                        // Change the values in this array to populate your dropdown as required
                        $options = array(
                            ''        => 'Please select stream',
                            'science' => 'science',
                            'arts'    => 'arts',
                        );
                       echo form_dropdown(array('name' => 'stream[]', 'required' => 'required','class'=>'custom_select'), $options, set_value('stream', isset($qualification[1]->stream) ? $qualification[1]->stream : ''));
                    ?>
                    </td>
                    <td>
                    <?php 
                        // Change the values in this array to populate your dropdown as required
                        $organization_options[''] = 'Please select organization';
                        if(!empty($organization)){
                            foreach($organization as $row){
                                $organization_options[$row->id] = $row->organization_name;
                            }
                        }
                       echo form_dropdown(array('name' => 'organization[]', 'required' => 'required','class'=>'custom_select'), $organization_options, set_value('organization', isset($qualification[1]->organization) ? $qualification[1]->organization : ''));
                    ?>
                    </td>
                    <td>
                    <?php 
                        // Change the values in this array to populate your dropdown as required
                        $board_options[''] = 'Please select board or university';
                        if(!empty($board)){
                            foreach($board as $row){
                                $board_options[$row->id] = $row->board;
                            }
                        }
                        echo form_dropdown(array('name' => 'board[]', 'id'=>'board', 'required' => 'required','class'=>'custom_select'), $board_options, set_value('board', isset($qualification[1]->board) ? $qualification[1]->board : ''));
                    ?>
                    </td>
                    <td><input id='roll_no' class="custom_input" type='text' required='required' name='roll_no[]'  value="<?php echo set_value('roll_no', isset($qualification[1]->roll_no) ? $qualification[1]->roll_no : ''); ?>" /></td>
                    <td><input id='total_marks' class="custom_input" type='text' required='required' name='total_marks[]'  value="<?php echo set_value('total_marks', isset($qualification[1]->total_marks) ? $qualification[1]->total_marks : ''); ?>" /></td>
                    <td><input id='obtained_mark' class="custom_input" type='text' required='required' name='obtained_mark[]'  value="<?php echo set_value('obtained_mark', isset($qualification[1]->obtained_marks) ? $qualification[1]->obtained_marks : ''); ?>" /></td>
                    <td><input id='percentage' class="custom_input" type='text' required='required' name='percentage[]'  value="<?php echo set_value('percentage', isset($qualification[1]->percentage) ? $qualification[1]->percentage : ''); ?>" /></td>
                    <td><input id='pass_year' class="custom_input" type='text' required='required' name='pass_year[]'  value="<?php echo set_value('pass_year', isset($qualification[1]->pass_year) ? $qualification[1]->pass_year : ''); ?>" /></td>
                    </tr>

                    <tr>
                    <td>
                    <?php 
                        // Change the values in this array to populate your dropdown as required
                        $options = array(
                            ''            => 'Please select class',
                            'High School' => 'High School',
                            'Intermediate'=> 'Intermediate',
                            'Diploma'     => 'Diploma',
                        );
                       echo form_dropdown(array('name' => 'class[]', 'id'=>'class', 'required' => 'required','class'=>'custom_select'), $options, set_value('class', isset($qualification[2]->class) ? $qualification[2]->class : ''));
                    ?>
                    </td>
                    <td>
                    <?php 
                        // Change the values in this array to populate your dropdown as required
                        $options = array(
                            ''        => 'Please select stream',
                            'science' => 'science',
                            'arts'    => 'arts',
                        );
                       echo form_dropdown(array('name' => 'stream[]', 'required' => 'required','class'=>'custom_select'), $options, set_value('stream', isset($qualification[2]->stream) ? $qualification[2]->stream : ''));
                    ?>
                    </td>
                    <td>
                    <?php 
                        // Change the values in this array to populate your dropdown as required
                        $organization_options[''] = 'Please select organization';
                        if(!empty($organization)){
                            foreach($organization as $row){
                                $organization_options[$row->id] = $row->organization_name;
                            }
                        }
                       echo form_dropdown(array('name' => 'organization[]', 'required' => 'required','class'=>'custom_select'), $organization_options, set_value('organization', isset($qualification[2]->organization) ? $qualification[2]->organization : ''));
                    ?>
                    </td>
                    <td>
                    <?php 
                        // Change the values in this array to populate your dropdown as required
                        $board_options[''] = 'Please select board or university';
                        if(!empty($board)){
                            foreach($board as $row){
                                $board_options[$row->id] = $row->board;
                            }
                        }
                        echo form_dropdown(array('name' => 'board[]', 'id'=>'board', 'required' => 'required','class'=>'custom_select'), $board_options, set_value('board', isset($qualification[2]->board) ? $qualification[2]->board : ''));
                    ?>
                    </td>
                    <td><input id='roll_no' class="custom_input" type='text' required='required' name='roll_no[]'  value="<?php echo set_value('roll_no', isset($qualification[2]->roll_no) ? $qualification[2]->roll_no : ''); ?>" /></td>
                    <td><input id='total_marks' class="custom_input" type='text' required='required' name='total_marks[]'  value="<?php echo set_value('total_marks', isset($qualification[2]->total_marks) ? $qualification[2]->total_marks : ''); ?>" /></td>
                    <td><input id='obtained_mark' class="custom_input" type='text' required='required' name='obtained_mark[]'  value="<?php echo set_value('obtained_mark', isset($qualification[2]->obtained_marks) ? $qualification[2]->obtained_marks : ''); ?>" /></td>
                    <td><input id='percentage' class="custom_input" type='text' required='required' name='percentage[]'  value="<?php echo set_value('percentage', isset($qualification[2]->percentage) ? $qualification[2]->percentage : ''); ?>" /></td>
                    <td><input id='pass_year' class="custom_input" type='text' required='required' name='pass_year[]'  value="<?php echo set_value('pass_year', isset($qualification[2]->pass_year) ? $qualification[2]->pass_year : ''); ?>" /></td>
                    </tr>


                    <tr>
                    <td>
                    <?php 
                        // Change the values in this array to populate your dropdown as required
                        $options = array(
                            ''            => 'Please select class',
                            'High School' => 'High School',
                            'Intermediate'=> 'Intermediate',
                            'Diploma'     => 'Diploma',
                        );
                       echo form_dropdown(array('name' => 'class[]', 'id'=>'class', 'required' => 'required','class'=>'custom_select'), $options, set_value('class', isset($qualification[3]->class) ? $qualification[3]->class : ''));
                    ?>
                    </td>
                    <td>
                    <?php 
                        // Change the values in this array to populate your dropdown as required
                        $options = array(
                            ''        => 'Please select stream',
                            'science' => 'science',
                            'arts'    => 'arts',
                        );
                       echo form_dropdown(array('name' => 'stream[]', 'required' => 'required','class'=>'custom_select'), $options, set_value('stream', isset($qualification[3]->stream) ? $qualification[3]->stream : ''));
                    ?>
                    </td>
                    <td>
                    <?php 
                        // Change the values in this array to populate your dropdown as required
                        $organization_options[''] = 'Please select organization';
                        if(!empty($organization)){
                            foreach($organization as $row){
                                $organization_options[$row->id] = $row->organization_name;
                            }
                        }
                       echo form_dropdown(array('name' => 'organization[]', 'required' => 'required','class'=>'custom_select'), $organization_options, set_value('organization', isset($qualification[3]->organization) ? $qualification[3]->organization : ''));
                    ?>
                    </td>
                    <td>
                    <?php 
                        // Change the values in this array to populate your dropdown as required
                        $board_options[''] = 'Please select board or university';
                        if(!empty($board)){
                            foreach($board as $row){
                                $board_options[$row->id] = $row->board;
                            }
                        }
                        echo form_dropdown(array('name' => 'board[]', 'id'=>'board', 'required' => 'required','class'=>'custom_select'), $board_options, set_value('board', isset($qualification[3]->board) ? $qualification[3]->board : ''));
                    ?>
                    </td>
                    <td><input id='roll_no' class="custom_input" type='text' required='required' name='roll_no[]'  value="<?php echo set_value('roll_no', isset($qualification[3]->roll_no) ? $qualification[3]->roll_no : ''); ?>" /></td>
                    <td><input id='total_marks' class="custom_input" type='text' required='required' name='total_marks[]'  value="<?php echo set_value('total_marks', isset($qualification[3]->total_marks) ? $qualification[3]->total_marks : ''); ?>" /></td>
                    <td><input id='obtained_mark' class="custom_input" type='text' required='required' name='obtained_mark[]'  value="<?php echo set_value('obtained_mark', isset($qualification[3]->obtained_marks) ? $qualification[3]->obtained_marks : ''); ?>" /></td>
                    <td><input id='percentage' class="custom_input" type='text' required='required' name='percentage[]'  value="<?php echo set_value('percentage', isset($qualification[3]->percentage) ? $qualification[3]->percentage : ''); ?>" /></td>
                    <td><input id='pass_year' class="custom_input" type='text' required='required' name='pass_year[]'  value="<?php echo set_value('pass_year', isset($qualification[3]->pass_year) ? $qualification[3]->pass_year : ''); ?>" /></td>
                    </tr>

                </tbody>
            </table>
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
    .student_image {
    display: flex;
    justify-content: center;
    flex-direction: column;
    align-items: center;
    margin-bottom: 5px;
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
</style>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script>

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

    var csrf_token = '<?php echo $this->security->get_csrf_hash(); ?>';

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

    $('#country_local').on('change', function() {
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
                        $('#state_local').html(htm);
                        $('#ci_csrf_token').val(csrf_token);
                    }
            });
        }
    });
    
    /* Get City*/

    $('#state_local').on('change', function() {
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
                        $('#city_local').html(htm);
                        $('#ci_csrf_token').val(csrf_token);
                    }
            });
        }
    });

    $('#country_school').on('change', function() {
        var country_id = $(this).find(":selected").val();
        var htm = '';
        $('#state_school').html('');
        
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
                        $('#state_school').html(htm);
                        $('#ci_csrf_token').val(csrf_token);
                    }
            });
        }
    });
    
    /* Get City*/

    $('#state_school').on('change', function() {
        var state_id = $(this).find(":selected").val();
        var htm = '';
        $('#city_school').html('');
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
                        $('#city_school').html(htm);
                        $('#ci_csrf_token').val(csrf_token);
                    }
            });
        }
    });

    $('#year_semester').on('change', function() {
        var year_semester = $(this).find(":selected").val();
        var course = $('#course').find(":selected").val();
        var htm = '';
        $('#student_subject_list').html('');
        if(year_semester!='' && course!='')
        {
            $.ajax({
                    type:'POST',
                    dataType:'json',
                    url: '<?php echo site_url(SITE_AREA) ?>/content/student_registration/getCourseWiseSubject',
                    data: {'ci_csrf_token':csrf_token,'year_semester':year_semester,'course':course},
                    success:function(response)
                    {
                        $(response.data).each(function( index, element ) {
                            htm += element.title+'&nbsp<input type="checkbox" name="student_subject[]" id="student_subject" value='+element.subject_id+'>';
                        });
                        csrf_token = response.token;
                        $('#student_subject_list').html(htm);
                        $('#ci_csrf_token').val(csrf_token);
                    }
            });
        }
    });

    $('#course').on('change', function() {
        var course = $(this).find(":selected").val();
        $('#student_subject_list').html('');
        var htm_htm = '';
        $('#year_semester').html('');
        
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
                        $('#year_semester').html(htm_htm);
                        $('#ci_csrf_token').val(csrf_token);
                    }
            });
        }
    });
</script>