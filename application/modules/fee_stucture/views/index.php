<?php

$hiddenFields = array('id', 'created_by', 'modified_by',);
?>
<h1 class='page-header'>
    <?php echo lang('fee_stucture_area_title'); ?>
</h1>
<?php if (isset($records) && is_array($records) && count($records)) : ?>
<table class='table table-striped table-bordered'>
    <thead>
        <tr>
            
            <th>Fee Head</th>
            <th>Class</th>
            <th>Year or Semester</th>
            <th>Frequency</th>
            <th>Amount</th>
            <th><?php echo lang('fee_stucture_column_created'); ?></th>
            <th><?php echo lang('fee_stucture_column_modified'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($records as $record) :
        ?>
        <tr>
            <?php
            foreach($record as $field => $value) :
                if ( ! in_array($field, $hiddenFields)) :
            ?>
            <td>
                <?php
                if ($field == 'deleted') {
                    e(($value > 0) ? lang('fee_stucture_true') : lang('fee_stucture_false'));
                } else {
                    e($value);
                }
                ?>
            </td>
            <?php
                endif;
            endforeach;
            ?>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php

    echo $this->pagination->create_links();
endif; ?>