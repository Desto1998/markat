<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<h4 class="mbot15"><?php echo _l('tasks_summary'); ?></h4>
<div class="row" id="status-tasks">
    <?php   $tasks_my_where = 'id IN(SELECT taskid FROM ' . db_prefix() . 'task_assigned WHERE staffid=' . get_staff_user_id() . ')';

        $sqlProjectTasksWhere = ' AND CASE
            WHEN rel_type="project" AND rel_id IN (SELECT project_id FROM ' . db_prefix() . 'project_settings WHERE project_id=rel_id AND name="hide_tasks_on_main_tasks_table" AND value=1)
            THEN rel_type != "project"
            ELSE 1=1
            END';
        $tasks_my_where .= $sqlProjectTasksWhere;
    ?>
    <div class="col-md-2 col-xs-6 border-right">
        <h3 class="bold no-mtop"><?php echo total_rows(db_prefix() . 'tasks') ?></h3>
        <p style="color:#000" class="font-medium no-mbot">
            Alle Aufgaben
        </p>
        <p class="font-medium-xs no-mbot text-muted">
            <?php echo _l('tasks_view_assigned_to_user'); ?>: <?php echo total_rows(db_prefix() . 'tasks', $tasks_my_where) ?>
        </p>
    </div>
    <?php foreach (tasks_summary_data((isset($rel_id) ? $rel_id : null), (isset($rel_type) ? $rel_type : null)) as $summary) { ?>
        <div class="col-md-2 col-xs-6 border-right">
            <h3 class="bold no-mtop"><?php echo $summary['total_tasks']; ?></h3>
            <p style="color:<?php echo $summary['color']; ?>" class="font-medium no-mbot">
                <?php echo $summary['name']; ?>
            </p>
            <p class="font-medium-xs no-mbot text-muted">
                <?php echo _l('tasks_view_assigned_to_user'); ?>: <?php echo $summary['total_my_tasks']; ?>
            </p>
        </div>
    <?php } ?>
</div>
<hr class="hr-panel-heading"/>
