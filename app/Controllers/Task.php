<?php namespace App\Controllers;

use App\Models\TaskModel;
use CodeIgniter\Controller;

class Task extends Controller
{
    public function index()
    {
        return view('tasks');
    }

    public function list()
    {
        $model = new TaskModel();
        $data['tasks'] = $model->findAll();
        return $this->response->setJSON($data);
    }

    public function create()
    {
        $model = new TaskModel();
        $data = [
            'judul' => $this->request->getPost('judul'),
            'status' => 0
        ];
        $model->insert($data);
        return $this->response->setJSON(['status' => 'success']);
    }

    public function update()
    {
        $model = new TaskModel();
        $id = $this->request->getPost('id');
        $data = [
            'judul' => $this->request->getPost('judul'),
            'status' => $this->request->getPost('status')
        ];
        $model->update($id, $data);
        return $this->response->setJSON(['status' => 'success']);
    }

    public function delete($id)
    {
        $model = new TaskModel();
        $model->delete($id);
        return $this->response->setJSON(['status' => 'success']);
    }
}