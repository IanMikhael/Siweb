<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    // Nama Tabel
    protected $table         ='pengguna';
    protected $primarykey    = 'id';
    protected $allowedFields = ['firstname', 'lastname', 'role', 'user_name', 'user_email',
    'user_password', 'user_created_at'];

    public function getUsers($id = false)
    {
        $query = $this->select('*');
        if($id === false) {
            return $query->findAll();
        } else {
            return $query->where(['id' => $id])->first();
        }
    }
}