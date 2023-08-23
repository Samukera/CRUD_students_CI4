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


        header('Access-Control-Allow-Origin: http://localhost:5173');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
        header('Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding');
    }

    public function listStudent($id = null)
    {
        $perPage = 10; // Número de registros por página
        $page = $this->request->getGet('page'); // Página atual

        if (is_null($id)) {
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
        } else {
            $data = $this->studentModel->find($id);

            if (is_null($data)) {
                return $this->respondNoContent();
            }
            $response = ['data' => $data];
        }

        return  $this->respond($response, 200);
    }


    public function createStudent()
    {
        $response = [];
        $data = [
            'name' => $this->request->getVar('name'),
            'email' => $this->request->getVar('email'),
            'fone' => $this->request->getVar('fone'),
            'address' => $this->request->getVar('address'),
            'picture' => $this->request->getVar('picture'),
        ];

        // Converte a string base64 em um arquivo
        $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data['picture']));

        // Valida o tipo da imagem
        $imageInfo = getimagesizefromstring($imageData);
        if (!in_array($imageInfo[2], [IMAGETYPE_JPEG, IMAGETYPE_PNG])) {
            return $this->failValidationErrors(['picture' => 'A imagem deve ser do tipo JPEG ou PNG']);
        }

        // Valida o tamanho da imagem
        if (strlen($imageData) > 2 * 1024 * 1024) {
            return $this->failValidationErrors(['picture' => 'O tamanho da imagem não deve exceder 2 MB']);
        }

        try {
            if ($this->studentModel->insert($data)) {
                // Salva a imagem no diretório de upload
                // $imagePath = WRITEPATH . 'uploads/' . uniqid() . '.png';
                // file_put_contents($imagePath, $imageData);

                $response = [
                    'status' => 'success',
                    'message' => 'Student created successfully',
                ];
                return $this->respondCreated($response);
            } else {
                $response = [
                    'status' => 'fail',
                    'errors' => $this->studentModel->errors(),
                ];
                return $this->fail($response);
            }
        } catch (\Exception $e) {
            $response = [
                'status' => 'error',
                'errors' => $e,
            ];
            return $this->fail($response);
        }
    }


    public function updateStudent($id)
    {
        $response = [];
        $data = $this->request->getVar();

        // Verifica se uma nova imagem foi enviada

        if (isset($data->picture)) {
            // Converte a string base64 em um arquivo
            $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data->picture));

            // Valida o tipo da imagem
            $imageInfo = getimagesizefromstring($imageData);
            if (!in_array($imageInfo[2], [IMAGETYPE_JPEG, IMAGETYPE_PNG])) {
                return $this->failValidationErrors(['picture' => 'A imagem deve ser do tipo JPEG ou PNG']);
            }

            // Valida o tamanho da imagem
            if (strlen($imageData) > 1024 * 1024) {
                return $this->failValidationErrors(['picture' => 'O tamanho da imagem não deve exceder 2 MB']);
            }
        }


        try {
            if ($this->studentModel->update($id, $data)) {
                // Verifica se uma nova imagem foi enviada
                if (isset($data->picture)) {
                    // Salva a imagem no diretório de upload
                    // $imagePath = WRITEPATH . 'uploads/' . uniqid() . '.png';
                    // file_put_contents($imagePath, $imageData);


                }

                $response = [
                    'status' => 'success',
                    'message' => 'Student updated successfully',
                ];
                return $this->respond($response);
            } else {
                $response = [
                    'status' => 'fail',
                    'errors' => $this->studentModel->errors(),
                ];
                return $this->fail($response);
            }
        } catch (\Exception $e) {
            $response = [
                'status' => 'error',
                'errors' => $e,
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
