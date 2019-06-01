<?php

if (validation_errors()) :
?>
<div class='alert alert-block alert-error fade in'>
    <a class='close' data-dismiss='alert'>&times;</a>
    <h4 class='alert-heading'>
        <?php echo lang('course_wise_subjects_errors_message'); ?>
    </h4>
    <?php echo validation_errors(); ?>
</div>
<?php
endif;

$id = isset($course_wise_subjects->id) ? $course_wise_subjects->id : '';

?>
<div class='admin-box'>
    <h3>Course wise subjects</h3>
    <?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
        <fieldset>
        <input type='hidden' id="ci_csrf_token" name="ci_csrf_token" value='<?php echo $this->security->get_csrf_hash(); ?>'>
            <?php // Change the values in this array to populate your dropdown as required
                $options[''] = 'Please select course';
                if(!empty($course)){
                    foreach($course as $row){
                        $options[$row->id] = $row->course_name;
                    }
                }
                echo form_dropdown(array('name' => 'course_id', 'required' => 'required'), $options, set_value('course_id', isset($course_wise_subjects->course_id) ? $course_wise_subjects->course_id : ''), lang('course_wise_subjects_field_course_id') . lang('bf_form_label_required'));
            ?>

            <?php // Change the values in this array to populate your dropdown as required
                $options_1[''] = 'Please select year';
                if(!empty($year_sem)){
                    foreach($year_sem as $row){
                        $options_1[$row->id] = $row->year_or_semester_name;
                    }
                }
                echo form_dropdown(array('name' => 'year_or_semester_id', 'required' => 'required'), $options_1, set_value('year_or_semester_id', isset($course_wise_subjects->year_or_semester_id) ? $course_wise_subjects->year_or_semester_id : ''), lang('course_wise_subjects_field_year_or_semester_id') . lang('bf_form_label_required'));
            ?>

            <?php // Change the values in this array to populate your dropdown as required
                $options_2[''] = 'Please select subject';
                foreach($subject as $row){
                    $options_2[$row->id] = $row->title;
                }
                echo form_dropdown(array('name' => 'subject_id', 'required' => 'required'), $options_2, set_value('subject_id', isset($course_wise_subjects->subject_id) ? $course_wise_subjects->subject_id : ''), lang('course_wise_subjects_field_subject_id') . lang('bf_form_label_required'));
            ?>
        </fieldset>
        <fieldset class='form-actions'>
            <input type='submit' name='save' class='btn btn-primary' value="<?php echo lang('course_wise_subjects_action_edit'); ?>" />
            <?php echo lang('bf_or'); ?>
            <?php echo anchor(SITE_AREA . '/master/course_wise_subjects', lang('course_wise_subjects_cancel'), 'class="btn btn-warning"'); ?>
            
            <?php if ($this->auth->has_permission('Course_wise_subjects.Master.Delete')) : ?>
                <?php echo lang('bf_or'); ?>
                <button type='submit' name='delete' formnovalidate class='btn btn-danger' id='delete-me' onclick="return confirm('<?php e(js_escape(lang('course_wise_subjects_delete_confirm'))); ?>');">
                    <span class='icon-trash icon-white'></span>&nbsp;<?php echo lang('course_wise_subjects_delete_record'); ?>
                </button>
            <?php endif; ?>
        </fieldset>
    <?php echo form_close(); ?>
</div>


<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script>

    var csrf_token = '<?php echo $this->security->get_csrf_hash(); ?>';

    /* Get State*/

    $('#course_id').on('change', function() {
        var course_id = $(this).find(":selected").val();
        var htm = '';
        $('#year_or_semester_id').html('');
        
        if(course_id!='')
        {
            $.ajax({
                    type:'POST',
                    dataType:'json',
                    url: '<?php echo site_url(SITE_AREA) ?>/master/course_wise_subjects/getYearOrSemester',
                    data: {'ci_csrf_token':csrf_token,'course_id':course_id},
                    success:function(response)
                    {
                        $(response.data).each(function( index, element ) {

                            htm += '<option value='+element.id+'>'+element.year_or_semester_name+'</option>';

                        });
                        csrf_token = response.token;
                        $('#year_or_semester_id').html(htm);
                        $('#ci_csrf_token').val(csrf_token);
                    }
            });
        }
    });
</script>