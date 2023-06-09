<?php
namespace App\Models;
use CodeIgniter\Model;

class BuyModel extends Model
{
    // Nama Tabel
    protected $table = 'buy';
    protected $useTimestamps = true;
    protected $allowedFields = ['buy_id', 'user_id', 'supplier_id'];

    public function getReport($tgl_awal, $tgl_akhir)
    {
        return $this->db->table('buy_detail as sd')->select('s.buy_id, s.created_at tgl_transaksi, us.id user_id, us.firstname, us.lastname, , us.user_name, c.supplier_id, c.name name_supp, c.no_supplier, SUM(sd.total_price) total')
    ->join('buy s', 'buy_id')
    ->join('pengguna us', 'us.id = s.user_id')
    ->join('supplier c', 'supplier_id', 'left')
    // ->join('book b', 'b.book_id = sd.book_id')
    ->where('date(s.created_at) >=', $tgl_awal)
    ->where('date(s.created_at) <=', $tgl_akhir)
    ->groupBy('s.buy_id')->get()->getResultArray();
    }

//     public function getReport($tgl_awal, $tgl_akhir)
// {
//     return $this->db->table('buy_detail as sd')
//         ->select('s.buy_id, s.created_at tgl_transaksi, us.id user_id, us.firstname, us.lastname, us.user_name, c.supplier_id, c.name name_supp, c.no_supplier, SUM(sd.total_price) total, b.title judul_buku, sd.quantity jumlah_buku, sd.price harga')
//         ->join('buy s', 's.buy_id = sd.buy_id')
//         ->join('pengguna us', 'us.id = s.user_id')
//         ->join('supplier c', 'c.supplier_id = s.supplier_id', 'left')
//         ->join('book b', 'b.book_id = sd.book_id')
//         ->where('date(s.created_at) >=', $tgl_awal)
//         ->where('date(s.created_at) <=', $tgl_akhir)
//         ->groupBy('s.buy_id')
//         ->get()
//         ->getResultArray();
// }

// public function getReport($tgl_awal, $tgl_akhir)
// {
//     return $this->db->table('buy_detail as sd')
//         ->select('s.buy_id, s.created_at tgl_transaksi, us.id user_id, us.firstname, us.lastname, b.title, sd.stock, b.price, c.supplier_id, c.name name_supp, c.no_supplier, SUM(sd.total_price) total')
//         ->join('buy s', 'buy_id')
//         ->join('pengguna us', 'us.id = s.user_id')
//         ->join('supplier c', 'supplier_id', 'left')
//         ->join('book b', 'b.book_id = sd.book_id')
//         ->where('date(s.created_at) >=', $tgl_awal)
//         ->where('date(s.created_at) <=', $tgl_akhir)
//         ->groupBy('s.buy_id')
//         ->get()
//         ->getResultArray();
// }


}