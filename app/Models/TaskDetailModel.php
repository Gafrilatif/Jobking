<?php

namespace App\Models;

use CodeIgniter\Model;

class TaskDetailModel extends Model
{
    protected $table = 'tasks_detail';
    protected $primaryKey = 'id_detail';
    protected $allowedFields = ['id_task', 'task_description'];
}
