<?php

namespace App\Models;

use CodeIgniter\Model;

class Auth_Model extends Model {
    
    protected $table = "users";

    public function register($data)
    {
        $query = $this->db->table($this->table)->insert($data);
        return $query ? true : false;
    }

    public function cek_login($email)
    {
        $query = $this->table($this->table)
                      ->where('email', $email)
                      ->countAll();

        // cek ada data atau tidak
        if($query > 0) {
            // ada data
            $hasil = $this->table($this->table)
                          ->where('email', $email)
                          ->limit(1)
                          ->get()
                          ->getRowArray();
        } else {
            // tidak ada data 
            $hasil = array();
        }

        return $hasil;
    }
}