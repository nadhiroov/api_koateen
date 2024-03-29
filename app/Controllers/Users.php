<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class Users extends ResourceController
{
    use ResponseTrait;

    protected $modelName = 'App\Models\M_users';
    protected $format    = 'json';

    // Index method (GET) - Retrieve all users
    public function index()
    {
        $users = $this->model->findAll();
        return $this->respond(['status' => 1, 'data' => $users]);
    }

    // Show method (GET) - Retrieve a single user by ID
    public function show($id = null)
    {
        $data = $this->model->find($id);

        if (!$data) {
            return $this->failNotFound('User not found');
        }

        return $this->respond(['status' => 1, 'data' => $data]);
    }

    // Create method (POST) - Create a new user
    public function create()
    {
        $data = $this->request->getJSON();

        $validation = \Config\Services::validation();
        $validation->setRules([
            'username' => 'required|min_length[3]|is_unique[users.username]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[8]',
        ]);

        if (!$validation->run($data)) {
            return $this->fail($validation->getErrors(), 400);
        }

        $data->password = password_hash($data->password, PASSWORD_DEFAULT);

        $userId = $this->model->insert($data);

        return $this->respondCreated(['id' => $userId, 'message' => 'User created successfully']);
    }

    // Update method (PUT) - Update a user by ID
    public function update($id = null)
    {
        $data = $this->request->getJSON();

        $validation = \Config\Services::validation();
        $validation->setRules([
            'username' => 'required|min_length[3]|is_unique[users.username,id,' . $id . ']',
            'email' => 'required|valid_email|is_unique[users.email,id,' . $id . ']',
            'password' => 'required|min_length[8]',
        ]);

        if (!$validation->run($data)) {
            return $this->fail($validation->getErrors(), 400);
        }

        $data->password = password_hash($data->password, PASSWORD_DEFAULT);

        $this->model->update($id, $data);

        return $this->respond(['message' => 'User updated successfully']);
    }

    // Delete method (DELETE) - Delete a user by ID
    public function delete($id = null)
    {
        $user = $this->model->find($id);

        if (!$user) {
            return $this->failNotFound('User not found');
        }

        $this->model->delete($id);

        return $this->respondDeleted(['message' => 'User deleted successfully']);
    }
}
