<?php

if (validation_errors()) :
?>
<div class='alert alert-block alert-error fade in'>
    <a class='close' data-dismiss='alert'>&times;</a>
    <h4 class='alert-heading'>
        <?php echo lang('local_address_errors_message'); ?>
    </h4>
    <?php echo validation_errors(); ?>
</div>
<?php
endif;

$id = isset($local_address->id) ? $local_address->id : '';

?>
<div class='admin-box'>
    <h3>Local Address</h3>
    <?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
        <fieldset>
            
            <input id='address_type' type='hidden' name='address_type' value="local"/>
            <input id='ci_csrf_token' type='hidden' value="<?php echo $this->security->get_csrf_hash(); ?>" name='ci_csrf_token' value="local"/>
            <div class="control-group<?php echo form_error('street_address') ? ' error' : ''; ?>">
                <?php echo form_label(lang('local_address_field_street_address') . lang('bf_form_label_required'), 'street_address', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <?php echo form_textarea(array('name' => 'street_address', 'id' => 'street_address', 'rows' => '5', 'cols' => '80', 'value' => set_value('street_address', isset($local_address->street_address) ? $local_address->street_address : ''), 'required' => 'required')); ?>
                    <span class='help-inline'><?php echo form_error('street_address'); ?></span>
                </div>
            </div>

            <?php // Change the values in this array to populate your dropdown as required
                $options = array('' => 'Please Select Country');
                foreach($countries as $row){
                    $options[$row->id] = $row->name; 
                }
                echo form_dropdown(array('name' => 'country', 'required' => 'required'), $options, set_value('country', isset($local_address->country) ? $local_address->country : ''), lang('local_address_field_country') . lang('bf_form_label_required'));
            ?>

            <?php // Change the values in this array to populate your dropdown as required
                $options = array('' => 'Please Select State');
                echo form_dropdown(array('name' => 'state', 'required' => 'required'), $options, set_value('state', isset($local_address->state) ? $local_address->state : ''), lang('local_address_field_state') . lang('bf_form_label_required'));
            ?>
            <?php // Change the values in this array to populate your dropdown as required
                $options = array('' => 'Please Select City');
                echo form_dropdown(array('name' => 'city', 'required' => 'required'), $options, set_value('city', isset($local_address->city) ? $local_address->city : ''), lang('local_address_field_city') . lang('bf_form_label_required'));
            ?>

            <div class="control-group<?php echo form_error('zip_code') ? ' error' : ''; ?>">
                <?php echo form_label(lang('local_address_field_zip_code') . lang('bf_form_label_required'), 'zip_code', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='zip_code' type='text' required='required' name='zip_code' maxlength='30' value="<?php echo set_value('zip_code', isset($local_address->zip_code) ? $local_address->zip_code : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('zip_code'); ?></span>
                </div>
            </div>

        </fieldset>
        <fieldset class='form-actions'>
            <input type='submit' name='save' class='btn btn-primary' value="<?php echo lang('local_address_action_create'); ?>" />
            <?php echo lang('bf_or'); ?>
            <?php echo anchor(SITE_AREA . '/content/local_address', lang('local_address_cancel'), 'class="btn btn-warning"'); ?>
            
        </fieldset>
    <?php echo form_close(); ?>
</div>


<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script>

    var csrf_token = '<?php echo $this->security->get_csrf_hash(); ?>';

    /* Get State*/

    $('#country').on('change', function() {
        var country_id = $(this).find(":selected").val();
        var htm = '';
        $('#state').html('');
        
        if(country_id!='')
        {
            $.ajax({
                    type:'POST',
                    dataType:'json',
                    url: '<?php echo site_url(SITE_AREA) ?>/master/local_address/getStateByCountryId',
                    data: {'ci_csrf_token':csrf_token,'country_id':country_id},
                    success:function(response)
                    {
                        $(response.data).each(function( index, element ) {

                            htm += '<option value='+element.id+'>'+element.name+'</option>';

                        });
                        csrf_token = response.token;
                        $('#state').html(htm);
                        $('#ci_csrf_token').val(csrf_token);
                    }
            });
        }
    });
    
    /* Get City*/

    $('#state').on('change', function() {
        var state_id = $(this).find(":selected").val();
        var htm = '';
        $('#city').html('');
        if(state_id!='')
        {
            $.ajax({
                    type:'POST',
                    dataType:'json',
                    url: '<?php echo site_url(SITE_AREA) ?>/master/local_address/getCityByStateId',
                    data: {'ci_csrf_token':csrf_token,'state_id':state_id},
                    success:function(response)
                    {
                        $(response.data).each(function( index, element ) {

                            htm += '<option value='+element.id+'>'+element.name+'</option>';

                        });
                        csrf_token = response.token;
                        $('#city').html(htm);
                        $('#ci_csrf_token').val(csrf_token);
                    }
            });
        }
    });
</script>