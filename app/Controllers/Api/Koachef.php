<?php

namespace App\Controllers\Api;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class Koachef extends ResourceController
{
    use ResponseTrait;

    protected $modelName = 'App\Models\M_koachef';
    protected $format    = 'json';
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return ResponseInterface
     */
    public function index()
    {
        $filter = $this->request->getGet('filter');
        $query = $this->model->orderBy('created_at', 'DESC');

        $target = $this->request->getGet('target');
        if ($target != null && $target != '') {
            $query->where('target', $target);
        }

        if ($filter != null && $filter != '') {
            $query->where('type', $filter);
        }
        $data = $query->findAll();

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
            'type'         => 'required',
            'title'         => 'required',
            'ingredients'   => 'required',
            'nutrisions'    => 'required',
            'cook'          => 'required',
            'calories'      => 'required',
            'target'      => 'required',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->failValidationErrors($validation->getErrors());
        }

        $image = $this->request->getFile('image');
        if (!$image->isValid() || !in_array($image->getExtension(), ['jpg', 'jpeg', 'png', 'gif'])) {
            return $this->fail('Invalid file type. Only JPG, JPEG, PNG, or GIF files are allowed.');
        }
        $imageName = $image->getRandomName();
        try {
            $img = \Config\Services::image();
            $image->move("./image/koachef/", $imageName);
            $img->withFile("./image/koachef/$imageName")->resize(1080, 1280, true)->save("./image/koachef/$imageName", 80);
        } catch (\Exception $er) {
            $data = [
                'status'    => 0,
                'title'     => 'error',
                'message'   => $er->getMessage(),
            ];
        }

        $data = $this->request->getPost();
        $data['image'] = $imageName;
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
        $data = $this->request->getRawInput();
        try {
            $this->model->update($id, $data);
            return $this->respond(['status' => 1, 'message' => 'Data updated']);
        } catch (\Exception $er) {
            return $this->fail(['status' => 0, 'message' => $er->getMessage()]);
        }
    }

    public function editImage()
    {
        $image = $this->request->getFile('image');
        $param = $this->request->getPost();
        if (!$image->isValid() || !in_array($image->getExtension(), ['jpg', 'jpeg', 'png', 'gif'])) {
            return $this->fail('Invalid file type. Only JPG, JPEG, PNG, or GIF files are allowed.');
        }
        $imageName = $image->getRandomName();
        try {
            $img = \Config\Services::image();
            $image->move("./image/koachef/", $imageName);
            $img->withFile("./image/koachef/$imageName")->resize(1080, 1280, true)->save("./image/koachef/$imageName", 80);
        } catch (\Exception $er) {
            $data = [
                'status'    => 0,
                'title'     => 'error',
                'message'   => $er->getMessage(),
            ];
        }
        $data['image'] = $imageName;
        try {
            $this->model->update($param['id'], $data);
            return $this->respond(['status' => 1, 'message' => 'Data updated']);
        } catch (\Exception $er) {
            return $this->fail(['status' => 0, 'message' => $er->getMessage()]);
        }
    }

    public function delete($id = null)
    {
        $this->model->delete($id);
        return $this->respond(['status' => 1, 'message' => 'Data deleted']);
    }
}
