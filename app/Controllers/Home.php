<?php

namespace App\Controllers;
use \App\Models\BerandaModel;

class Home extends BaseController
{
    public function __construct()
    {
        $this->beranda = new BerandaModel();
    }
     public function index()
    {
        $data = [
            'title' => 'Beranda'
        ];
         return view ('beranda', $data);

    //      public function index()
    // {
    //     $data = [
    //         'title' => 'Dashboard'
    //     ];
         return view ('admin/overview', $data);
        //  echo view ('admin/overview');
        //  return view ('Home');
        //   return view ('welcome_message');
        //  echo view('layout/header');
        //  echo view('layout/topbar');
        //  echo view('layout/sidebar');
        //  echo view('admin/overview');
        //  echo view('layout/footer');
         
     }
    

    // public function about($nama = null, $umur = 0)
    //  {
    //      echo "Hi, nama saya adalah $nama. Usia saya $umur tahun";
    //  }
    
//    public function about()
//    {
//        return view ('bio');
//    }

//    public function about()
//    {
//     return view('bio');
//    }

    public function Tugascontainer()
    {
        return view ('admin/Tugascontainer');
        return view ('admin/Tugas2');
    }

    public function showChartTransaksi()
    {
        $tahun = date('Y');
        $reportTrans = $this->beranda->reportTransaksi($tahun);
        $response = [
            'status' => false,
            'data'   => $reportTrans
        ];
        echo json_encode($response);
    }

    public function showChartCustomer()
    {
        $tahun = $this->request->getVar('tahun');
        $reportCust = $this->beranda->reportCustomer($tahun);
        $response = [
            'status' => false,
            'data'   => $reportCust
        ];
        echo json_encode($response);
    }

    public function showChartPembelian()
    {
        $tahun = $this->request->getVar('tahun');
        $reportBeli = $this->beranda->reportPembelian($tahun);
        $response = [
            'status' => false,
            'data' => $reportBeli
        ];
        echo json_encode($response);
    }

    public function showChartSupplier()
    {
        $tahun = $this->request->getVar('tahun');
        $reportSupp = $this->beranda->reportSupplier($tahun);
        $response = [
            'status' => false,
            'data' => $reportSupp
        ];
        echo json_encode($response);
    }
}
