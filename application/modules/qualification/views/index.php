<?php

$hiddenFields = array('id', 'created_by', 'modified_by',);
?>
<h1 class='page-header'>
    <?php echo lang('qualification_area_title'); ?>
</h1>
<?php if (isset($records) && is_array($records) && count($records)) : ?>
<table class='table table-striped table-bordered'>
    <thead>
        <tr>
            
            <th>Class</th>
            <th>Stream</th>
            <th>Organization</th>
            <th>Board</th>
            <th>Roll No.</th>
            <th>Max Mark</th>
            <th>Obtained Marks</th>
            <th>Pass Year</th>
            <th>Registration No.</th>
            <th><?php echo lang('qualification_column_created'); ?></th>
            <th><?php echo lang('qualification_column_modified'); ?></th>
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
                    e(($value > 0) ? lang('qualification_true') : lang('qualification_false'));
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