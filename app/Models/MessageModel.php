<?php

namespace App\Models;

use CodeIgniter\Model;

class MessageModel extends Model
{
    protected $table            = 'messages';
    protected $primaryKey       = 'message_id'; // CHANGED from 'id'
    protected $allowedFields    = ['room_id', 'sender_id', 'message_text', 'is_read'];

    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = '';

    public function markMessagesAsRead(int $roomId, int $userId)
    {
        return $this->where('room_id', $roomId)
                    ->where('sender_id !=', $userId)
                    ->set(['is_read' => 1])
                    ->update();
    }
}