<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body _buttons">
                        <h3><span><?php echo get_menu_option(c_menu(), 'Task-Planer') ?></span>
                            <?php if (has_permission('menu', '', 'edit')):
                                ?>
                                <a id="edit-menu" href="#"><i class="fa fa-pencil"></i></a>
                            <?php endif; ?></h3>
                        <hr class="hr-panel-heading"/>
                        <div> <?php if (has_permission('tasks', '', 'create')) { ?>
                                <a href="#" onclick="new_task(<?php if ($this->input->get('project_id')) {
                                    echo "'" . admin_url('tasks/task?rel_id=' . $this->input->get('project_id') . '&rel_type=project') . "'";
                                } ?>); return false;"
                                   class="btn btn-info pull-left new"><?php echo _l('new_task'); ?></a>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="panel-body ">
                        <?php
                        if ($this->session->has_userdata('tasks_kanban_view') && $this->session->userdata('tasks_kanban_view') == 'true') { ?>
                            <div class="kan-ban-tab" id="kan-ban-tab" style="overflow:auto;">
                                <div class="row">
                                    <div id="kanban-params">
                                        <?php echo form_hidden('project_id', $this->input->get('project_id')); ?>
                                    </div>
                                    <div class="container-fluid">
                                        <div id="kan-ban"></div>
                                    </div>
                                </div>
                            </div>

                        <?php } else { ?>
                            <?php $this->load->view('admin/tasks/_summary', array('table' => '.table-tasks')); ?>
                           <!-- <a href="#" data-toggle="modal" data-target="#tasks_bulk_actions"
                               class="hide bulk-actions-btn table-btn"
                               data-table=".table-tasks"><?php /*echo _l('bulk_actions'); */?></a>-->
                            <div class="row " id="tasks-table">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p class="bold"><?php echo _l('filter_by'); ?></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 leads-filter-column">
                                            <?php echo render_select('status', $statuses, array('id', 'name'), '', '', array('data-width' => '100%', 'data-none-selected-text' => 'Status'), array()); ?>
                                        </div>
                                        <div class="col-md-2 leads-filter-column">
                                            <?php echo render_date_input('start_date', '','', array('placeholder' => 'Start Datum')); ?>
                                        </div>
                                        <div class="col-md-2 leads-filter-column">
                                            <?php echo render_date_input('end_date', '', '', array('placeholder' => 'Fälligkeitsdatum')) ?>
                                        </div>
                                        <div class="col-md-3 leads-filter-column">
                                            <?php   echo render_select('member', $staff, array('assigneeid', 'full_name'), '', '', array('data-width' => '100%', 'data-none-selected-text' => 'Mitarbeiter'), array(), '', '', true); ?>
                                        </div>
                                        <div class="col-md-2 leads-filter-column">
                                            <?php echo render_select('priority', get_tasks_priorities(), array('id', 'name'), '', '', array('data-width' => '100%', 'data-none-selected-text' => 'Priorität'), array()); ?>
                                        </div>

                                    </div>
                                </div>

                                <div class="clearfix"></div>
                                <hr class="hr-panel-heading"/>
                            </div>

                                <a href="#" class="bulk-actions-btn table-btn delete-all hide" id="sqdsqd"
                                   data-table=".table-tasks"><?php echo _l('Alle löschen'); ?></a>

                            <?php $this->load->view('admin/tasks/_table'); ?>
                            <?php /*$this->load->view('admin/tasks/_bulk_actions'); */?>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>
<script>
    taskid = '<?php echo $taskid; ?>';
    $(function () {
        tasks_kanban();
    });
</script>
</body>
</html>
