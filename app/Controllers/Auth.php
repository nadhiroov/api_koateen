<?php

namespace App\Controllers;

use App\Models\M_users;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class Auth extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return ResponseInterface
     */

    public function __construct()
    {
        $this->model = new M_users();
    }

    public function register()
    {
        // Get the request data
        $data = $this->request->getPost('param');

        // Validate the input data (customize this based on your needs)
        $validation = \Config\Services::validation();
        $validation->setRules([
            'username' => 'required|min_length[3]|is_unique[m_users.username]',
            'email' => 'required|valid_email|is_unique[m_users.email]',
            'password' => 'required|min_length[8]',
        ]);

        if (!$validation->run($data)) {
            return $this->fail($validation->getErrors(), 400);
        }

        // Hash the password before saving it to the database
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        // Save the user to the database
        $this->model->insert($data);

        return $this->respondCreated(['status' => 1, 'message' => 'User registered successfully']);
    }

    public function login()
    {
        $data = $this->request->getPost('param');

        $validation = \Config\Services::validation();
        $validation->setRules([
            'username' => 'required|min_length[3]',
            'password' => 'required|min_length[8]',
        ]);

        if (!$validation->run($data)) {
            return $this->fail($validation->getErrors(), 400);
        }

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
