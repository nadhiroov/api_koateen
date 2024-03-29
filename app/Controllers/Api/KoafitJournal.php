<?php

namespace App\Controllers\Api;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class KoafitJournal extends ResourceController
{
    use ResponseTrait;

    protected $modelName = 'App\Models\M_koafitjournal';
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

    public function summary($id = '')
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

    public function activity($id = '', $day = ''){
        $data = $this->model->select('koafit_journal.*, B.sport')->join('koafit B', 'B.id = koafitId')->where(['koafit_journal.userId' => $id, 'day' => $day])->findAll();
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

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return ResponseInterface
     */
    public function create()
    {
        $validation =  \Config\Services::validation();
        $validation->setRules([
            'userId'    => 'required',
            'koafitId'  => 'required',
            'day'       => 'required',
            'time'      => 'required',
            'percent'   => 'required',
            'cal'       => 'required',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->failValidationErrors($validation->getErrors());
        }

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
