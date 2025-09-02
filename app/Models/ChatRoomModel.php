<?php

namespace App\Models;

use CodeIgniter\Model;

class ChatRoomModel extends Model
{
    protected $table            = 'chat_rooms';
    protected $primaryKey       = 'room_id';
    protected
 
$allowedFields    = ['commission_id', 'commissioner_id', 'freelancer_id'];

    public function getChatRooms($params = null): array
    {
        if ($params === null || !isset($params['id_user'])) {
            return [];
        }

        $lastMessageSubquery = '(SELECT message_text FROM messages WHERE room_id = chat_rooms.room_id ORDER BY created_at DESC LIMIT 1)';

        $unreadCountSubquery = '(SELECT COUNT(*) FROM messages WHERE room_id = chat_rooms.room_id AND is_read = 0 AND sender_id != ' . $this->db->escape($params['id_user']) . ')';

        $builder = $this->db->table($this->table);
        
        $builder->select('
            chat_rooms.room_id, 
            tasks.task_title, 
            commissioner.username as commissioner_name, 
            freelancer.username as freelancer_name,
            chat_rooms.commissioner_id,
            chat_rooms.freelancer_id,
            ' . $lastMessageSubquery . ' as last_message,
            ' . $unreadCountSubquery . ' as unread_count
        ');
        
        $builder->join('tasks', 'tasks.id_task = chat_rooms.commission_id', 'left');
        $builder->join('users as commissioner', 'commissioner.id_user = chat_rooms.commissioner_id', 'left');
        $builder->join('users as freelancer', 'freelancer.id_user = chat_rooms.freelancer_id', 'left');

        $builder->where('chat_rooms.commissioner_id', $params['id_user']);
        $builder->orWhere('chat_rooms.freelancer_id', $params['id_user']);
        
        $query = $builder->get();

        return $query->getResultArray();
    }
}