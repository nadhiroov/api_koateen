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
        if ($data['units'] == 'US Standard') {
            $data['weight'] = $data['weight'] * 0.453592;
            $data['height'] = $data['height'] * 12 + $data['height2'];
            $data['height'] = $data['height'] * 2.54;
        }

        // count BMI
        $bmi = $this->countBMI($data['height'], $data['weight'], $data['age']);
        $data['bmi'] = $bmi['bmi'];
        $data['bmiLevel'] = $bmi['level'];
        $data['recommendation'] = $bmi['recommendation'];

        // count BMR
        $data['bmr'] = $this->countBMR($data['gender'], $data['weight'], $data['height'], $data['age']);

        // count need calories
        $data['needCalories'] = $this->countNeedCal($data['level'], $data['gender'], $data['bmr'], $data['bmi']);

        $check = $this->model->where('userId', $data['userId'])->find();
        if (!empty($check)) {
            $this->model->update($check[0]['id'], $data);
            return $this->respondUpdated([
                'status'    => 1,
                'message'   => 'succes',
                'data'      => $data
            ]);
        }
        $data['dayDate'] = date('Y-m-d');

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
        $data = $this->request->getRawInput();
        $this->model->update($id, $data);

        return $this->respond(['status' => 1, 'message' => 'Data updated']);
    }

    public function delete($id = null)
    {
        $this->model->delete($id);
        return $this->respond(['status' => 1, 'message' => 'Data deleted']);
    }

    public function countBMI($tinggi_cm, $berat_kg, $usia_tahun)
    {
        $tinggi_m = $tinggi_cm / 100;
        $bmi = $berat_kg / ($tinggi_m * $tinggi_m);

        if ($usia_tahun < 18) {
            if ($bmi < 18.5) {
                $level = "Underweight";
                $recom = "Increase Weight";
            } elseif ($bmi >= 18.5 && $bmi < 24.9) {
                $level = "Normal weight";
                $recom = "Maintain Weight";
            } elseif ($bmi >= 25 && $bmi < 29.9) {
                $level = "Overweight";
                $recom = "Lose Weight";
            } else {
                $level = "Obesity";
                $recom = "Lose Weight";
            }
        } else {
            if ($bmi < 18.5) {
                $level = "Underweight";
                $recom = "Increase Weight";
            } elseif ($bmi >= 18.5 && $bmi < 24.9) {
                $level = "Normal weight";
                $recom = "Maintain Weight";
            } elseif ($bmi >= 25 && $bmi < 29.9) {
                $level = "Overweight";
                $recom = "Lose Weight";
            } else {
                $level = "Obesity";
                $recom = "Lose Weight";
            }
        }
        return ["bmi" => number_format($bmi, 2), "level" => $level, "recommendation" => $recom];
    }

    private function countBMR($gender, $weight, $height, $age)
    {
        if ($gender == 'Male') {
            $bmr = 66.4730 + (13.7516 * $weight) + (5.0033 * $height) - (6.7550 * $age);
        } else {
            $bmr = 655.0955 + (9.5634 * $weight) + (1.8496 * $height) - (4.6756 * $age);
        }
        return number_format($bmr, 2, '.', '');
    }

    private function countNeedCal($act, $gender,  $bmr, $bmi)
    {
        if ($act == 'Lightly Active') {
            $factor = $gender == 'Male' ? 1.4 : 1.2;
        } elseif ($act == 'Moderately Active') {
            $factor = $gender == 'Male' ? 1.7 : 1.5;
        } else {
            $factor = $gender == 'Male' ? 2.0 : 1.8;
        }
        $needCal = $bmr * $factor;
        if ($bmi < 18.5) {
            $needCal += 500;
        }
        return ceil($needCal);
    }
}
