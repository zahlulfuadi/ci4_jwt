<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class Api extends ResourceController
{
  public function index()
  {
    $output = [
      'status' => 200,
      'message' => "This is just Hello Word API",
    ];
    return $this->respond($output, 200);
  }
}