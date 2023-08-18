<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class Students extends ResourceController
{
    use ResponseTrait;
    private $studentModel;
    
    public function __construct()
    {
        $this->studentModel = new \App\Models\Students();
    }

    public function listStudent($id = null)
    {
        $perPage = 10; // Número de registros por página
        $page = $this->request->getGet('page'); // Página atual

        if(is_null($id)){
            $data = $this->studentModel->paginate($perPage, 'default', $page);
            $pager = $this->studentModel->pager;
            $response = [
                'data' => $data,
                'pager' => [
                    'currentPage' => $pager->getCurrentPage(),
                    'perPage' => $perPage,
                    'total' => $pager->getTotal(),
                    'lastPage' => $pager->getLastPage()
                ]
            ];
        }
        else{
            $data = $this->studentModel->find($id);

            if(is_null($data)){
                return $this->respondNoContent();
            }
            $response = ['data' => $data];
        }

        return  $this->respond($response, 200);
    }


    public function createStudent(){
        $response = [];
        $data = [
            'name' => $this->request->getVar('name'),
            'email' => $this->request->getVar('email'),
            'fone' => $this->request->getVar('fone'),
            'address' => $this->request->getVar('address'),
            'picture' => $this->request->getVar('picture')
        ];

        try {
            if($this->studentModel->insert($data)){
                $response = [
                    'status' => 'success',
                    'message' => 'Student created successfuly'
                ];
                return $this->respondCreated($response);
            }else{
                $response = [
                    'status' => 'fail',
                    'errors' => $this->studentModel->errors()
                ];
                return $this->fail($response);
            }
        } catch (\Exception $e) {
           $response = [
                    'status' => 'error',
                    'erros' => $e
            ];
            return $this->fail($response);
        }
    }

    public function updateStudent($id)
    {
        $response = [];
        $data = $this->request->getVar();
        try {
            if ($this->studentModel->update($id, $data)) {
                $response = [
                    'status' => 'success',
                    'message' => 'Student updated successfully'
                ];
                return $this->respond($response);
            } else {
                $response = [
                    'status' => 'fail',
                    'errors' => $this->studentModel->errors()
                ];
                return $this->fail($response);
            }
        } catch (\Exception $e) {
            $response = [
                'status' => 'error',
                'erros' => $e
            ];
            return $this->fail($response);
        }
    }


    public function deleteStudent($id)
    {
        $response = [];

        try {
            if ($this->studentModel->delete($id)) {
                $response = [
                    'status' => 'success',
                    'message' => 'Student deleted successfully'
                ];
                return $this->respondDeleted($response);
            } else {
                $response = [
                    'status' => 'fail',
                    'errors' => $this->studentModel->errors()
                ];
                return $this->fail($response);
            }
        } catch (\Exception $e) {
            $response = [
                'status' => 'error',
                'erros' => $e
            ];
            return $this->fail($response);
        }
    }

}