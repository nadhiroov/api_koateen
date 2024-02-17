<?php

namespace App\Controllers\Api;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class FoodJournal extends ResourceController
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

    public function getConsumption($id = null, $day = null)
    {
        $data = $this->model->select('food_journal.*, B.name')->join('koafood B', 'B.id = foodId')->where(['food_journal.userId' => $id, 'day' => $day])->findAll();
        return $this->respond(['status' => 1, 'data' => $data]);
    }

    public function summary($id = null)
    {
        $data = $this->model
            ->select('day, sum(cal) as totalCal')
            ->where(['userId' => $id])
            ->orderBy('day', 'asc')
            ->groupBy('day')
            ->findAll();

        $days = array_column($data, 'day');
        $latestDay = max($days);
        $startDay = max(1, $latestDay - 6);
        $endDay = $latestDay;
        $result = array_filter($data, function ($record) use ($startDay, $endDay) {
            return $record['day'] >= $startDay && $record['day'] <= $endDay;
        });
        return $this->respond(['status' => 1, 'data' => array_values($result)]);
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
            'weight'    => 'required',
            'cal'       => 'required',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->failValidationErrors($validation->getErrors());
        }

        $data = $this->request->getPost();
        $check = $this->model->where(['userId' => $data['userId'], 'type' => $data['type'], 'day' => 'day'])->find();
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
        $data = $this->request->getRawInput();
        $this->model->update($id, $data);

        return $this->respond(['status' => 1, 'message' => 'Data updated']);
    }

    public function delete($id = null)
    {
        $this->model->delete($id);
        return $this->respond(['status' => 1, 'message' => 'Data deleted']);
    }
}
