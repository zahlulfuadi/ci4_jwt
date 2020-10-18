<?php

namespace App\Model;

use CodeIgniter\Model;

class Auth_Model extends Model {
    
    protected $table = "users";

    public function register($data)
    {
        $query = $this->db->table($this->table)->insert($data);
        return $query ? true : false;
    }
}