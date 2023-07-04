<?php

namespace App\Controllers;

use App\Models\TasksModel;
use CodeIgniter\Controller;

class Tasks extends Controller
{
    public function index()
    {
        $model = new TasksModel();
        $data['tasks'] = $model->findAll();
        $data['judul'] = 'tasks';

        echo view('templates/header',$data);
        echo view('templates/sidebar');
        echo view('templates/topbar');
        echo view('tasks/index',$data);
        echo view('templates/footer');
    }

    public function datatable()
    {
        $model = new TasksModel();
    
        $draw = $this->request->getVar('draw');
        $columns = ['id', 'judul', 'status']; // Kolom yang ingin ditampilkan dalam DataTables
    
        $totalRecords = $model->countAllResults();
    
        $searchValue = $this->request->getPost('search')['value'] ?? '';
    
        $builder = $model->select($columns);
        if (!empty($searchValue)) {
            $builder->like('judul', $searchValue); // Kolom yang ingin di-filter berdasarkan kata kunci pencarian
        }
    
        $totalFiltered = $builder->countAllResults(false);
    
        $start = $this->request->getPost('start');
        $length = $this->request->getPost('length');
        $builder->limit($length, $start);
    
        $tasks = $builder->get()->getResultArray();
    
        foreach ($tasks as &$task) {
            $task['action'] = '<a href="' . base_url('delete-task/' . $task['id']) . '" class="btn btn-danger btn-sm">Delete</a>' .
                              '<a href="' . base_url('/edit-task/' . $task['id']) . '" class="btn btn-primary btn-sm">Edit</a>';
        }
    
        $data = [
            "draw" => $draw,
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $totalFiltered,
            "data" => $tasks
        ];
    
        return $this->response->setJSON($data);
    }
    
    



    public function create()
    {
        $data['judul'] = 'create tasks';

        
        echo view('templates/header',$data);
        echo view('templates/sidebar');
        echo view('templates/topbar');
        echo view('tasks/create');
        echo view('templates/footer');
    }

    public function store()
    {
        $model = new TasksModel();

        $data = [
            'judul' => $this->request->getPost('judul'),
            'status' => $this->request->getPost('status')
        ];

        $model->insert($data);

        return redirect()->to('/tasks');
    }

    public function edit($id)
    {
        $model = new TasksModel();

        $data['task'] = $model->find($id);

        $data['judul'] = 'edit tasks';

        
        echo view('templates/header',$data);
        echo view('templates/sidebar');
        echo view('templates/topbar');
        echo view('tasks/edit',$data);
        echo view('templates/footer');
    }

    public function update($id)
    {
        $model = new TasksModel();

        $data = [
            'judul' => $this->request->getPost('judul'),
            'status' => $this->request->getPost('status')
        ];

        $model->update($id, $data);

        return redirect()->to('/tasks');
    }

    public function delete($id)
    {
        $model = new TasksModel();

        $model->delete($id);

        return redirect()->to('/tasks');
    }
}
