<?php

namespace App\Models;

use CodeIgniter\Model;

class TaskModel extends Model
{
    protected $table = 'tasks';
    protected $primaryKey = 'id_task';
    protected $allowedFields = ['task_title', 'brief_desc', 'task_tags', 'id_user', 'status'];

    public function getCommissionsWithUser() {
        $builder = $this->db->table('tasks'); 
        $builder->select('tasks.*, users.username, users.profile_picture, tasks_detail.task_description'); 
        $builder->join('users', 'users.id_user = tasks.id_user', 'left');
        $builder->join('tasks_detail', 'tasks_detail.id_task = tasks.id_task', 'left');
        $builder->where('tasks.status !=', 'accepted');
        $query = $builder->get();

        return $query->getResult();
    }
}
