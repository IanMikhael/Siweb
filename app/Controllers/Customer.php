<?php

namespace App\Controllers;

use App\Libraries\GroceryCrud;

class Customer extends BaseController
{
    public function index()
    {
        $crud = new GroceryCrud();
        $crud ->setTable('customer');
        $crud->setLanguage('Indonesian');
        $crud->columns(['name','no_customer', 'gender', 'address',  'email', 'phone']);
        $crud->unsetColumns(['created_at', 'updated_at']);
        $crud->displayAs(array(
            'name' => 'Nama',
            'gender' =>'L/P',
            'address'=>'Alamat',
            'phone'=> 'Telp',
        ));
        $crud->where('deleted_at', null);
        $crud->unsetAddFields(['created_at', 'updated_at]']);
        $crud->unsetEditFields(['created_at', 'updated_at]']);
        $crud->setRule('name', 'Nama', 'Required', ['required' => '{field} harus diisi wey jangan ga diisi!']);
        
        // $crud->unsetAdd();
        // $crud->unsetEdit();
        // $crud->unsetDelete();
        // $crud->unsetExport();
        // $crud->unsetPrint();
        // $crud->setRelation('officeCode', 'offices', 'city');
        
        $crud->setTheme('datatables');

        $output = $crud->render();

        $data = [
            'title' => 'Data Customer',
            'result'=> $output
        ];
        return view('customer/index', $data);
    }
}