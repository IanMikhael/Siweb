<?php

namespace App\Controllers;

use App\Libraries\GroceryCrud;

class Mahasiswa_1553 extends BaseController
{
    public function index()
    {
        $crud = new GroceryCrud();
        $crud ->setTable('mahasiswa_1553');
        $crud->setLanguage('Indonesian');
        $crud->columns(['nama','tempat_lahir', 'jenis_kelamin', 'hobi',  'kategori_favorit']);
        $crud->unsetColumns(['created_at', 'updated_at']);
        $crud->displayAs(array(
            'nama' => 'Nama',
            'tempat_lahir' =>'Tempat Lahir',
            'jenis_kelamin'=>'Jenis Kelamin',
            'hobi'=> 'Hobi',
        ));
        $crud->where('deleted_at', null);
        $crud->unsetAddFields(['created_at', 'updated_at]']);
        $crud->unsetEditFields(['created_at', 'updated_at]']);
        $crud->setRule('nama', 'Nama', 'Required', ['required' => '{field} harus diisi wey jangan ga diisi!']);
        
        // $crud->unsetAdd();
        // $crud->unsetEdit();
        // $crud->unsetDelete();
        // $crud->unsetExport();
        // $crud->unsetPrint();
        // $crud->setRelation('officeCode', 'offices', 'city');
        
        $crud->setRelation('kategori_favorit','book_category','name_category');
        $crud->setTheme('datatables');

        $output = $crud->render();

        $data = [
            'title' => 'Data Mahasiswa',
            'result'=> $output
        ];
        return view('mahasiswa_1553/index', $data);
    }
}