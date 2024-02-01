<?php

namespace App\Controllers\Api;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class Koafit extends ResourceController
{
    use ResponseTrait;

    protected $modelName = 'App\Models\M_koafit';
    protected $format    = 'json';
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return ResponseInterface
     */
    public function index()
    {
        $data = $this->model->findAll();
        return $this->respond(['status' => 1, 'data' => $data]);
    }

    public function show($id = null)
    {
        $data = $this->model->find($id);
        if (!$data) {
            return $this->failNotFound('Data not found');
        }
        return $this->respond(['status' => 1, 'data' => $data]);
    }

    public function create()
    {
        $validation =  \Config\Services::validation();
        $validation->setRules([
            'sport'     => 'required',
            'level'     => 'required',
            'time'      => 'required',
            'kkal'      => 'required',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->failValidationErrors($validation->getErrors());
        }
        // Insert a new exercise
        $data = $this->request->getPost();
        try {
            $this->model->insert($data);
            $return = [
                'status'    => 1,
                'message'   => 'succes'
            ];
        } catch (\Exception $er) {
            $return = [
                'status'    => 0,
                'message'   => $er->getMessage()
            ];
        }
        return $this->respondCreated($return);
    }

    public function update($id = null)
    {
        // Validate incoming request data
        $validation =  \Config\Services::validation();
        $validation->setRules([
            'sport'     => 'required',
            'level'     => 'required',
            'time'      => 'required',
            'kkal'      => 'required',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->failValidationErrors($validation->getErrors());
        }

        $data = $this->request->getJSON();
        $this->model->update($id, $data);
        return $this->respond(['status' => 1, 'message' => 'Data updated']);
    }

    public function delete($id = null)
    {
        $this->model->delete($id);
        return $this->respond(['status' => 1, 'message' => 'Data deleted']);
    }
}
