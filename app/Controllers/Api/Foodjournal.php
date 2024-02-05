<?php

namespace App\Controllers\Api;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class Foodjournal extends ResourceController
{
    use ResponseTrait;

    protected $modelName = 'App\Models\M_foodjournal';
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
    
    public function getConsumption($id = null, $day = null) {
        $data = $this->model->select('food_journal.*, B.name, B.cal')->join('koafood B', 'B.id = foodId')->where(['userId' => $id, 'day' => $day])->findAll();
        return $this->respond(['status' => 1, 'data' => $data]);
    }

    public function show($id = null)
    {
        $data = $this->model->find($id);
        if (!$data) {
            return $this->failNotFound('data not found');
        }
        return $this->respond(['status' => 1, 'data' => $data]);
    }

    public function create()
    {
        $validation =  \Config\Services::validation();
        $validation->setRules([
            'userId'    => 'required',
            'foodId'    => 'required',
            'type'      => 'required',
            'day'       => 'required',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->failValidationErrors($validation->getErrors());
        }

        $data = $this->request->getPost();
        $check = $this->model->where(['userId' => $data['userId'], 'type' => $data['type']])->find();
        if (!empty($check)) {
            $this->model->update($check[0]['id'], $data);
            return $this->respondUpdated([
                'status'    => 1,
                'message'   => 'succes'
            ]);
        }

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
        $validation =  \Config\Services::validation();
        $validation->setRules([
            'userId'    => 'required',
            'foodId'    => 'required',
            'type'      => 'required',
            'day'       => 'required',
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
