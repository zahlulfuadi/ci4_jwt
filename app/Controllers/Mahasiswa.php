<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\Mahasiswa_Model;

class Mahasiswa extends ResourceController
{
  public function __construct()
  {
    $this->model = new Mahasiswa_Model();
  }

  public function getMahasiswa($id  = null)
  {
    $data = $this->model->getMahasiswa($id);
    if ($data == null || $data == '') {
      $output = [
        'status' => 404,
        'message' => 'No Mahasiswa Found',
        'data' => []
      ];
      return $this->respond($output, 200);
    }

    $output = [
      'status' => 200,
      'message' => 'Successful',
      'data' => [
        'mahasiswa' => $data,
      ]
    ];
    return $this->respond($output, 200);
  }

  public function addMahasiswa()
  {
    $json = $this->request->getJSON();

    $name = $json->nama;
    $asal_sma = $json->asal_sma;

    $data = [
      'nama' => $name,
      'asal_sma' => $asal_sma
    ];

    $insert = $this->model->addMahasiswa($data);

    if ($insert) {
      $output = [
        'status' => 200,
        'message' => 'Insert Mahasiswa Success'
      ];
      return $this->respond($output, 200);
    }
  }

  public function deleteMahasiswa($id  = null)
  {
    $delete = $this->model->deleteMahasiswa($id);
    if ($delete) {
      $output = [
        'status' => 200,
        'message' => 'delete successfull',
        'data' => [
          'id' => $id,
        ]
      ];
      return $this->respond($output, 200);
    }
  }

  public function updateMahasiswa($id = null)
  {
    $mahasiswa = $this->model->getMahasiswa($id);
    if ($mahasiswa == null || $mahasiswa == '') {
      $output = [
        'status' => 404,
        'message' => 'No Mahasiswa Found',
        'data' => []
      ];
      return $this->respond($output, 200);
    }

    $json = $this->request->getJSON();

    $nama = $json->nama;
    $asal_sma = $json->asal_sma;

    $data = [
      'nama' => $nama,
      'asal_sma' => $asal_sma
    ];

    $update = $this->model->updateMahasiswa($id, $data);

    if ($update) {
      $output = [
        'status' => 200,
        'message' => 'Successful',
        'data' => [
          'mahasiswa' => [
            "id" => $id,
            "nama" => $nama,
            "asal_sma" => $asal_sma
          ],
        ]
      ];
      return $this->respond($output, 200);
    }
  }
}