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
        $page = $this->request->getVar('page') ? (int) $this->request->getVar('page') : 1;
        $perPage =
            $this->request->getVar('limit') ? (int) $this->request->getVar('limit') : 10;
        $offset = ($page - 1) * $perPage;
        $exercises = $this->model->paginate($perPage, 'group1', $offset);
        $pager = $this->model->pager;
        return $this->respond(['data' => $exercises, 'pager' => $pager]);
    }

    public function show($id = null)
    {
        $exercise = $this->model->find($id);
        if (!$exercise) {
            return $this->failNotFound('Exercise not found');
        }
        return $this->respond($exercise);
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

        // Update an existing exercise
        $data = $this->request->getJSON();
        $this->model->update($id, $data);

        return $this->respond(['message' => 'Exercise updated']);
    }

    public function delete($id = null)
    {
        // Delete an exercise by ID
        $this->model->delete($id);

        return $this->respond(['message' => 'Exercise deleted']);
    }
}
