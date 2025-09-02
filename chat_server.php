<?php

use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\WebSocket\WsServer;

define('FCPATH', __DIR__ . '/public/');

chdir(__DIR__);

require __DIR__ . '/app/Config/Paths.php';
$paths = new Config\Paths();

require rtrim($paths->systemDirectory, '\\/ ') . '/Boot.php';

$app = CodeIgniter\Boot::bootSpark($paths);


class Chat implements MessageComponentInterface
{
    protected $clients;
    protected $rooms;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
        $this->rooms = [];
        echo "Chat Server Started successfully.\n";
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);
        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        $data = json_decode($msg);

        if (isset($data->type) && $data->type === 'register') {
            $this->rooms[$from->resourceId] = $data->roomId;
            echo "User {$data->userId} registered to room {$data->roomId}\n";
            return;
        }
        
        if (isset($data->type) && $data->type === 'message') {
            
            $messageModel = new \App\Models\MessageModel();
            $dataToSave = [
                'room_id' => $data->roomId,
                'sender_id' => $data->userId,
                'message_text' => $data->message
            ];

            if ($messageModel->insert($dataToSave)) {
                echo ">>> SUCCESS: Message from user {$data->userId} in room {$data->roomId} saved to DB.\n";
            } else {
                echo ">>> ERROR: FAILED to save message to DB for room {$data->roomId}.\n";
            }

            $senderRoomId = $this->rooms[$from->resourceId] ?? null;
            foreach ($this->clients as $client) {
                $clientRoomId = $this->rooms[$client->resourceId] ?? null;
                if ($from !== $client && $senderRoomId === $clientRoomId) {
                    $client->send($msg);
                }
            }
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);
        unset($this->rooms[$conn->resourceId]);
        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }
}

// Run the server
$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new Chat()
        )
    ),
    8080
);

$server->run();