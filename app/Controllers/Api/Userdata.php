<?php

namespace App\Controllers\Api;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class Userdata extends ResourceController
{
    use ResponseTrait;

    protected $modelName = 'App\Models\M_userdata';
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
            return $this->failNotFound('data not found');
        }
        return $this->respond(['status' => 1, 'data' => $data]);
    }

    public function create()
    {
        $validation =  \Config\Services::validation();
        $validation->setRules([
            'userId'     => 'required',
            'units'      => 'required',
            'gender'     => 'required',
            'weight'     => 'required',
            'age'        => 'required',
            'height'     => 'required',
            'level'      => 'required',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->failValidationErrors($validation->getErrors());
        }

        $data = $this->request->getPost();
        $bmi = $this->hitungBMI($data['height'], $data['weight'], $data['age']);
        $data['bmi'] = $bmi['bmi'];
        $data['bmiLevel'] = $bmi['level'];

        $check = $this->model->where('userId', $data['userId'])->find();
        if (!empty($check)) {
            $this->model->update($check[0]['id'], $data);
            return $this->respondUpdated([
                'status'    => 1,
                'message'   => 'succes',
                'data'      => $data
            ]);
        }

        try {
            $this->model->insert($data);
            $return = [
                'status'    => 1,
                'message'   => 'succes',
                'data'      => $data
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
            'title'     => 'required',
            'content'     => 'required',
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

    public function hitungBMI($tinggi_cm, $berat_kg, $usia_tahun)
    {
        $tinggi_m = $tinggi_cm / 100;
        $bmi = $berat_kg / ($tinggi_m * $tinggi_m);

        if ($usia_tahun < 18) {
            if ($bmi < 18.5) {
                $level = "Underweight";
            } elseif ($bmi >= 18.5 && $bmi < 24.9) {
                $level = "Normal weight";
            } elseif ($bmi >= 25 && $bmi < 29.9) {
                $level = "Overweight";
            } else {
                $level = "Obesity";
            }
        } else {
            if ($bmi < 18.5) {
                $level = "Underweight";
            } elseif ($bmi >= 18.5 && $bmi < 24.9) {
                $level = "Normal weight";
            } elseif ($bmi >= 25 && $bmi < 29.9) {
                $level = "Overweight";
            } else {
                $level = "Obesity";
            }
        }

        return ["bmi" => number_format($bmi, 2), "level" => $level];
    }
}
