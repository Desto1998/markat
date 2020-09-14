<?php

defined('BASEPATH') or exit('No direct script access allowed');

include_once(__DIR__ . '/App_pdf.php');

class Task_pdf extends App_pdf
{
    protected $task;
    protected $tags;

    public function __construct($task, $tag = '')
    {
        $GLOBALS['task_pdf'] = $task;

        parent::__construct();

        if (!class_exists('Tasks_model', false)) {
            $this->ci->load->model('Tasks_model');
        }
        $this->tags = $tag;
        $this->task = $task;
        $this->SetTitle($task->id);
    }

    public function prepare()
    {
        $this->set_view_vars([
            'task_tag' => $this->tags,
            'task' => $this->task,
        ]);

        return $this->build();
    }

    protected function type()
    {
        return 'task';
    }

    protected function file_path()
    {
        return APPPATH . 'views/themes/' . active_clients_theme() . '/views/task_pdf.php';
    }
}
