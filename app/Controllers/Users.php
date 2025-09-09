<?php

namespace App\Controllers;

use App\Models\UserModel;

class Users extends BaseController
{

    public function __construct()
    {
        $this->session = \Config\Services::session();
    }

    public function index()
    {
        helper(['form']);
        $data = ['title' => 'Login'];

        if($this->request->getMethod() == 'POST')
        {
            $rules = [
                'email' => 'required|min_length[6]|max_length[50]|valid_email',
                'password' => 'required|min_length[8]|max_length[255]|validateUser[email, password]',
            ];

            $errors = [
                'password' => [
                    'validateUser' => 'Email or Password don\'t match'
                ]
            ];

            if(!$this->validate($rules, $errors))
            {
                $data['validation'] = $this->validator;
                $data['old_input'] = $this->request->getPost();
            }
            else
            {
                $model = new UserModel();

                $user = $model->where('user_email', $this->request->getVar('email'))
                              ->first();

                $this->setUserMethod($user);

                return redirect()->to(base_url('/dashboard'));
            }
        }

        echo view('login', $data);
    }

    private function setUserMethod($user)
    {
        $data = [
            'id' => $user['id_user'],
            'username' => $user['username'],
            'email' => $user['user_email'],
            'isLoggedIn' => true
        ];

        $this->session->set($data);
        return true;
    }


    public function register()
    {
        helper(['form']);
        $data = ['title' => 'Register'];

        if ($this->request->getMethod() == 'POST') {
            $rules = [
                'username' => 'required|min_length[3]|max_length[20]',
                'email' => [
                    'label' => 'Email',
                    'rules' => 'required|min_length[6]|max_length[50]|valid_email|is_unique[users.user_email]',
                    'errors' => [
                        'is_unique' => 'This email has already been used.'
                    ]
                ],
                'password' => 'required|min_length[8]|max_length[255]',
                'password_confirm' => [
                    'rules' => 'matches[password]',
                    'label' => 'Confirm Password',
                ],
                'profile_picture' => [
                    'rules' => 'is_image[profile_picture]|mime_in[profile_picture,image/jpg,image/jpeg,image/png]|max_size[profile_picture,2048]',
                    'errors' => [
                        'is_image' => 'Please upload a valid image file (jpg, jpeg, png).',
                        'mime_in' => 'Your image must be a jpg, jpeg, or png file.',
                        'max_size' => 'Your image is too large. Maximum size is 2MB.'
                    ]
                ]
            ];

            if (!$this->validate($rules)) {
                if ($this->request->isAJAX()) {
                    return $this->response
                        ->setStatusCode(400)
                        ->setJSON(['errors' => $this->validator->getErrors()]);
                } else {
                    $data['validation'] = $this->validator;
                    $data['old_input'] = $this->request->getPost();
                }
            } else {
                $img = $this->request->getFile('profile_picture');
                $newName = 'default_avatar.png';

                if ($img && $img->isValid() && !$img->hasMoved()) {
                    $newName = $img->getRandomName();
                    $img->move('./assets/uploads/avatars', $newName);
                }

                $model = new UserModel();
                $newData = [
                    'username' => $this->request->getVar('username'),
                    'user_email' => $this->request->getVar('email'),
                    'password' => $this->request->getVar('password'),
                    'profile_picture' => $newName
                ];

                $model->save($newData);

                if ($this->request->isAJAX()) {
                    return $this->response->setJSON(['status' => 'success']);
                }

                $session = session();
                $session->setFlashdata('success', 'Successful Registration');
                return redirect()->to(base_url('/login'));
            }
        }

        echo view('register', $data);
    }
    
    public function profile()
    {
        helper(['form']);
        $data = ['title' => 'Profile'];

        $model = new UserModel();

        $user = $model->where('id_user', session()->get('id'))->first();

        if (!$user) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("User not found.");
        }

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
                return redirect()->to(base_url('/profile'));
            }
        }

        $data['user'] = $user;
        echo view('templates/header', $data);
        echo view('profile', $data);
        echo view('templates/footer');
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to(base_url('/login'));
    }
    
}

?>