<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\TaskModel;
use App\Models\TaskDetailModel;
use App\Models\AcceptedTaskModel;
use App\Models\ChatRoomModel;
use App\Models\MessageModel;

class Dashboard extends BaseController
{

    public function index()
    {
        helper(['form']);
        $data = ['title' => 'Dashboard'];

        $model = new UserModel();

        // Retrieve user data
        $user = $model->where('id_user', session()->get('id'))->first();

        if (!$user) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("User not found.");
        }

        // Handle profile form submission
        if ($this->request->getMethod() == 'POST') {
            $rules = [
                'username' => 'required|min_length[3]|max_length[20]',
            ];

            if ($this->request->getPost('password') != '') {
                $rules['password'] = 'required|min_length[8]|max_length[255]';
                $rules['password_confirm'] = 'matches[password]';
            }

            if (!$this->validate($rules)) {
                $data['validation'] = $this->validator;
                $data['old_input'] = $this->request->getPost();
            } else {
                $newData = [
                    'id_user' => session()->get('id'),
                    'username' => $this->request->getVar('username'),
                ];

                if ($this->request->getPost('password') != '') {
                    $newData['password'] = password_hash($this->request->getVar('password'), PASSWORD_DEFAULT);
                }

                $model->update(session()->get('id'), $newData);

                session()->setFlashdata('success', 'Profile updated successfully');
                return redirect()->to(base_url('/dashboard'));
            }
        }

        $data['user'] = $user;

        echo view('templates/header', $data);
        echo view('dashboard', $data); 
        echo view('templates/footer');
    }

    public function postCommission()
    {
        $taskModel = new TaskModel();
        $taskDetailModel = new TaskDetailModel();

        if ($this->request->getMethod() == 'POST') {
            $rules = [
                'taskTitle' => 'required|max_length[255]',
                'briefDescription' => 'required|max_length[500]',
                'testTags' => 'required',
                'detailedDescription' => 'required',
            ];

            if (!$this->validate($rules)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'errors' => $this->validator->getErrors()
                ]);
            }

            $taskData = [
                'task_title' => $this->request->getPost('taskTitle'),
                'brief_desc' => $this->request->getPost('briefDescription'),
                'task_tags' => $this->request->getPost('testTags'),
                'id_user' => session()->get('id'), 
                'status' => 'not_accepted', 
            ];

            $taskId = $taskModel->insert($taskData);

            if ($taskId) {
                $taskDetailData = [
                    'id_task' => $taskId,
                    'task_description' => $this->request->getPost('detailedDescription'),
                ];

                if ($taskDetailModel->insert($taskDetailData)) {
                    return $this->response->setJSON([
                        'status' => 'success',
                        'message' => 'Commission posted successfully.'
                    ]);
                } else {
                    return $this->response->setJSON([
                        'status' => 'error',
                        'message' => 'Failed to insert task details.'
                    ]);
                }
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Failed to post commission.'
                ]);
            }
        }
    }

    public function getCommissions() {
        $model = new TaskModel();
        $commissions = $model->getCommissionsWithUser(); 
    
        return $this->response->setJSON($commissions);
    }


    public function acceptTask()
    {
        $taskId = $this->request->getPost('id_task');

        $taskModel = new TaskModel();
        $acceptedTaskModel = new AcceptedTaskModel();

        $task = $taskModel->find($taskId);

        if (!$task) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Task not found.']);
        }
        
        $chatRoomModel = new ChatRoomModel();

        $chatData = [
            'commission_id'   => $taskId,
            'commissioner_id' => $task['id_user'],
            'freelancer_id'   => session()->get('id') 
        ];

        $chatRoomModel->insert($chatData);
        $taskModel->update($taskId, ['status' => 'accepted']);

        $acceptedTaskModel->insert([
            'id_task' => $taskId,
            'id_user' => session()->get('id'), 
            'status' => 'on_progress'
        ]);

        return $this->response->setJSON(['status' => 'success']);
    }

    public function getAcceptedTask() {
        $model = new AcceptedTaskModel();
        $acceptedtask = $model->getAcceptedTask([
            'id_user' => session()->get('id'),
        ]); 
        
        return $this->response->setJSON($acceptedtask);
    }

    public function getChatRoom() {
        $model = new ChatRoomModel();
        $chatRooms = $model->getChatRooms([
            'id_user' => session()->get('id'),
        ]);

        return $this->response->setJSON($chatRooms);
    }

    public function getMessages($roomId)
    {
        $messageModel = new \App\Models\MessageModel();
        
        $messages = $messageModel->where('room_id', $roomId)->orderBy('created_at', 'ASC')->findAll();

        return $this->response->setJSON($messages);
    }

    public function markChatAsRead($roomId)
    {
        $messageModel = new MessageModel(); 
        $userId = session()->get('id');

        $messageModel->where('room_id', $roomId)
                    ->where('sender_id !=', $userId) 
                    ->set(['is_read' => 1])
                    ->update();

        return $this->response->setJSON(['status' => 'success']);
    }

    public function finishTask()
    {
        $acceptId = $this->request->getPost('id_accept');

        if (!$acceptId) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ID Accept not provided']);
        }

        $acceptedTaskModel = new AcceptedTaskModel();

        log_message('debug', 'Finishing task with ID: ' . $acceptId);

        $updateResult = $acceptedTaskModel->update($acceptId, ['status' => 'finished']);

        if ($updateResult) {
            return $this->response->setJSON(['status' => 'success']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Update failed']);
        }
    }




}
