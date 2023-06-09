<?php

namespace App\Controllers;
use \App\Models\KomikModel;
use \App\Models\KomikCategoryModel;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class Komik extends BaseController
{
    private $KomikModel, $catModel;
    public function  __construct()
    {
        $this->KomikModel = new komikModel();
        $this->catModel = new KomikCategoryModel();
    }

    public function index()
    {

        $atakomik = $this->KomikModel->getkomik();
        $data = [
            'judul' => 'Data Komik',
            'result' => $atakomik
        ];

        return view('komik/index', $data);
    }

    public function detail($slug)
    {

        $atakomik = $this->KomikModel->getkomik($slug);
        $data = [
            'judul' => 'Data Komik',
            'result' => $atakomik
        ];

        return view('komik/detail', $data);
    }

    public function create()
    {
        $data = [
            'judul' => 'Tambah Komik',
            'category' => $this->catModel->findAll(),
            'validation' => \config\Services::validation()
        ];
        return view('komik/create', $data);
    }

    public function save()
    {
        if (!$this->validate([
            'judul' => [
                'rules' => 'required|is_unique[komik.judul]',
                'label' => 'Judul',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'is_unique' => '{field} hanya sudah ada'
                ]
            ],
            'penulis' => 'required',
            'tahun_rilis' => 'required|integer',
            'harga' => 'required|numeric',
            'diskon' => 'permit_empty|decimal',
            
            'stok' => [
                'rules' => 'required|integer',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'integer' => '{field} hanya boleh angka'
                ]
            ],
            'cover' =>
            [
                'rules' => 'uploaded[cover]|max_size[cover,1024]|is_image[cover]|mime_in[cover,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Gambar tidak boleh lebih dari 1MB!',
                    'is_image' => 'Yang anda pilih bukan gambar!',
                    'mime_in' => 'Yang anda pilih bukan gambar!',
                ]
            ],
        ])) {

            return redirect()->to('/komik/create')->withInput();
        }

        $fileSampul = $this->request->getFile('cover');
        if ($fileSampul->getError() == 4) {
            $namaFile = $this->defaultImage;
        } else {
            $namaFile = $fileSampul->getRandomName();
            $fileSampul->move('img', $namaFile);
        }
        



        $slug = url_title($this->request->getVar('judul'), '-', true);
        $this->KomikModel->save([
            'judul' => $this->request->getVar('judul'),
            'penulis' => $this->request->getVar('penulis'),
            'tahun_rilis' => $this->request->getVar('tahun_rilis'),
            'harga' => $this->request->getVar('harga'),
            'diskon' => $this->request->getVar('diskon'),
            'stock' => $this->request->getVar('stock'),
            'komik_category_id' => $this->request->getVar('komik_category_id'),
            'slug' => $slug,
            'cover' => $namaFile
        ]);

        session()->setFlashdata("msg", "Data berhasil ditambahkan!");
        return redirect()->to('/komik');
    }

    public function edit($slug)
    {
        $atakomik = $this->KomikModel->getkomik($slug);
        if (empty($atakomik)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Judul Komik $slug tidak ditemukan!");
        }

        $data = [
            'judul' => 'Ubah Komik',
            'category' => $this->catModel->findAll(),
            'validation' => \config\Services::validation(),
            'result' => $atakomik
        ];
        return view('komik/edit', $data);
    }

    public function update($id)
    {
        $dataOld = $this->KomikModel->getkomik($this->request->getVar('slug'));
        if ($dataOld['judul'] == $this->request->getVar('judul')) {
            $rule_title = 'required';
        } else {
            $rule_title = 'required|is_unique[komik.judul]';
        }
        if (!$this->validate([
            'judul' => [
                'rules' => $rule_title,
                'label' => 'Judul',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'is_unique' => '{field} hanya sudah ada'
                ]
            ],
            'penulis' => 'required',
            'tahun_rilis' => 'required|integer',
            'harga' => 'required|numeric',
            'diskon' => 'permit_empty|decimal',
            'stok' => 'required|integer',
            'cover' =>
            [
                'rules' => 'uploaded[cover]|max_size[cover,1024]|is_image[cover]|mime_in[cover,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Gambar tidak boleh lebih dari 1MB!',
                    'is_image' => 'Yang anda pilih bukan gambar!',
                    'mime_in' => 'Yang anda pilih bukan gambar!',


                ]
            ],
        ])) {

            return redirect()->to('/komik/edit/' . $this->request->getVar('slug'))->withInput();
        }
        $fileSampul = $this->request->getFile('cover');
        $namaFileLama = $this->request->getVar('sampullama');

        if ($fileSampul->getError() == 4) {
            $namaFile = $namaFileLama;
        } else {
            $namaFile = $fileSampul->getRandomName();
            $fileSampul->move('img', $namaFile);

            if ($namaFileLama != $this->defaultImage && $namaFileLama !="") {
                unlink('img/' . $namaFileLama);
            }
        }

        $slug = url_title($this->request->getVar('judul'), '-', true);
        $this->KomikModel->save([
            'komik_id' => $id,
            'title' => $this->request->getVar('title'),
            'penulis' => $this->request->getVar('penulis'),
            'tahun_rilis' => $this->request->getVar('tahun_rilis'),
            'harga' => $this->request->getVar('harga'),
            'diskon' => $this->request->getVar('diskon'),
            'stok' => $this->request->getVar('stok'),
            'komik_category_id' => $this->request->getVar('komik_category_id'),
            'slug' => $slug,
            'cover' => $namaFile
        ]);

        session()->setFlashdata("msg", "Data berhasil diubah!");

        return redirect()->to('/komik');

    }

    public function delete($id)
    {
        $datakomik = $this->KomikModel->find($id);
        $this->KomikModel->delete($id);

        if ($datakomik['cover'] !=$this->defaultImage){
            unlink('img/' . $datakomik['cover']);
        }
        session()->setFlashdata("msg", "Data berhasil dihapus!");
        return redirect()->to('/komik');
        // return view('komik/delete', $id);
    }

    public function importData()
    {
        $file = $this->request->getFile("file");
        $ext = $file->getExtension();
        if ($ext == "xls")
            $reader = new Xls();
        else
            $reader = new Xlsx();

        $spreadsheet = $reader->load($file);
        $sheet = $spreadsheet->getActiveSheet()->toArray();

        foreach ($sheet as $key => $value)
        {
            if ($key == 0) continue;

            $namaFile = $this->defaultImage;
            $slug = url_title($value[1], '-', true);

            //cek judul
            $dataOld = $this->KomikModel->getKomik($slug);
            
            if (!isset($dataOld))
            // if ($value[1] != "")
            {
                $this->KomikModel->save([
                    'judul' => $value[1],
                    'penulis' => $value[2],
                    'tahun_rilis' => $value[3],
                    'harga' => $value[4],
                    'diskon' => $value[5] ?? 0,
                    'stok' => $value[6],
                    'komik_category_id' => $value[7],
                    'slug' => $slug,
                    'sampul' => $namaFile
                ]);
            }
        }
        session()->setFlashdata("msg", "Data berhasil diimport!");

        return redirect()->to('/komik');
    }
}