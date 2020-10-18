<?php

namespace App\Models;

use CodeIgniter\Model;

class Admin_Model extends Model
{

    protected $table = "admin";

    public function register($data)
    {
        $query = $this->db->table($this->table)->insert($data);
        // ini akan error ketika ada username yang sana
        if (!$query || $this->db->error()["code"] == 1062) return false;
        return true;
    }

    public function checkLogin($username)
    {
        $query = $this->table($this->table)->where('username', $username)->countAll();

        if ($query >  0) {
            $result = $this->table($this->table)->where('username', $username)->limit(1)->get()->getRowArray();
        } else {
            $result = array();
        }
        return $result;
    }
}