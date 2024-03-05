<?php

namespace App\Controllers;

use App\Models\M_users;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class Auth extends ResourceController
{

    public function __construct()
    {
        $this->model = new M_users();
    }

    public function register()
    {
        $data = $this->request->getPost();
        $validation = \Config\Services::validation();
        $validation->setRules([
            'fullname' => 'required',
            'username' => 'required|min_length[5]|is_unique[m_users.username]|alpha_dash',
            'email' => 'required|valid_email|is_unique[m_users.email]',
            'password' => 'required|min_length[8]',
        ]);

        if (!$validation->run($data)) {
            return $this->fail($validation->getErrors(), 400);
        }
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        try {
            $this->model->insert($data);
            return $this->respondCreated(['status' => 1, 'message' => 'User registered successfully']);
        } catch (\Exception $er) {
            return $this->failServerError($er->getMessage());
        }
    }

    public function login()
    {
        $data = $this->request->getPost();
        $user = $this->model->where('username', $data['username'])->where('deleted_at', null)->first();
        if ($user && password_verify($data['password'], $user['password'])) {
            return $this->respond(
                [
                    'status'    => 1,
                    'message'   => 'Login successful',
                    'data'      => $user
                ]
            );
        } else {
            return $this->failUnauthorized('Invalid email or password');
        }
    }

    public function index()
    {
        //
    }

    /**
     * Return the properties of a resource object
     *
     * @return ResponseInterface
     */
    public function show($id = null)
    {
        //
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return ResponseInterface
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return ResponseInterface
     */
    public function create()
    {
        //
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return ResponseInterface
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return ResponseInterface
     */
    public function update($id = null)
    {
        //
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return ResponseInterface
     */
    public function delete($id = null)
    {
        //
    }
}
