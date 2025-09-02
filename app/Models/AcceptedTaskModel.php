<?php

namespace App\Models;

use CodeIgniter\Model;

class AcceptedTaskModel extends Model
{
    protected $table = 'accepted_task';
    protected $primaryKey = 'id_accept';
    protected $allowedFields = ['id_accept', 'id_task', 'id_user', 'status'];

    public function getAcceptedTask($params = NULL) {
    $builder = $this->db->table('accepted_task'); 
    
    $builder->select('accepted_task.*, users.username, tasks.*, tasks_detail.*, chat_rooms.room_id'); 
    
    $builder->join('tasks', 'tasks.id_task = accepted_task.id_task', 'left');
    $builder->join('tasks_detail', 'tasks_detail.id_task = tasks.id_task', 'left');
    $builder->join('users', 'users.id_user = tasks.id_user', 'left');
    
    $builder->join('chat_rooms', 'chat_rooms.commission_id = accepted_task.id_task', 'left');

    $builder->where('accepted_task.id_user', $params['id_user']);
    $builder->where('accepted_task.status', 'on_progress');
    $query = $builder->get();

    return $query->getResult();
}
}
