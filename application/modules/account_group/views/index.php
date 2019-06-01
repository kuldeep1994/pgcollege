<?php

$hiddenFields = array('id', 'deleted', 'deleted_by', 'created_by', 'modified_by',);
?>
<h1 class='page-header'>
    <?php echo lang('account_group_area_title'); ?>
</h1>
<?php if (isset($records) && is_array($records) && count($records)) : ?>
<table class='table table-striped table-bordered'>
    <thead>
        <tr>
            
            <th>Group Name</th>
            <th>Description</th>
            <th>Parent Group</th>
            <th><?php echo lang('account_group_column_created'); ?></th>
            <th><?php echo lang('account_group_column_modified'); ?></th>
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
                    e(($value > 0) ? lang('account_group_true') : lang('account_group_false'));
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

endif; ?>