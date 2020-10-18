<?php

namespace App\Models;

use CodeIgniter\Model;

class Mahasiswa_Model extends Model
{

    protected $table = "mahasiswa";

    public function addMahasiswa($data)
    {
        return $this->db->table($this->table)->insert($data);
    }

    public function getMahasiswa($id = null)
    {
        if ($id == null) {
            $query = $this->table($this->table)->findAll();
            return $query;
        } else {
            $query = $this->table($this->table)->where('id', $id)->findAll();
            return $query;
        }
    }

    public function deleteMahasiswa($id)
    {
        return $this->db->table($this->table)->delete(['id' => $id]);
    }

    public function updateMahasiswa($id, $data)
    {
        return $this->db->table($this->table)->update($data, ['id' => $id]);
    }
}