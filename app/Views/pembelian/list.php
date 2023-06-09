<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<main>
    <div class="container-fluid px-5">
        <h1 class="mt-4">DATA TRANSAKSI</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Pembelian Komik</li>
        </ol>
        <div class="card mb-5">
            <div class="card-header">
                <i class="fas fa-table me-5"></i>
                <?= $title ?>
            </div>
            <div class="card-body">
                <!-- Grocery Crud -->
                <div class="row align-items-center mb-3">
                    <div class="col-sm-3">
                        <label class="col-form-label">Tanggal</label>
                        <input type="text" class="form-control" value="<?= date('d/m/y') ?>" disabled>
                    </div>

                    <div class="col-sm-3">
                        <label class="col-form-label">User</label>
                        <input type="text" class="form-control" value="<?= session()->user_name ?>" disabled>
                    </div>

                    <div class="col-sm-3">
                        <label class="col-form-label">Supplier</label>
                        <input type="text" class="form-control" id="nama-supp" disabled>
                        <input type="hidden" id="id-supp" >
                    </div>

                    <div class="col-sm-3">
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary me-2" data-bs-target="#modalKomik" data-bs-toggle="modal">Pilih Komik</button>

                            <button class="btn btn-dark" data-bs-target="#modalSupp" data-bs-toggle="modal">Cari Supplier
                        </div>
                    </div>

                </div>


                <table class="table table-striped table-hover mt-4">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Produk</th>
                            <th>Jumlah</th>
                            <th>Harga Satuan</th>
                            <th>Diskon</th>
                            <th>Subtotal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="detail_cart1"></tbody>
                </table>

                <div class="container">
                    <div class="row">
                        <div class="col-8">
                            <label class="col-form-label">Total Bayar</label>
                            <h1><span id="spanTotal">0</span></h1>
                        </div>

                        <div class="col-4">

                            <div class="mb-3 row">
                                <label class="col-4 col-form-label">Nominal</label>
                                <div class="col-8">
                                    <input type="text" class="form-control" id="nominal" autocomplete="off">
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-4 col-form-label">Kembalian</label>
                                <div class="col-8">
                                    <input type="text" class="form-control" id="kembalian" disabled>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-3 d-md-flex justify-content-md-end">
                        <button onclick="bayar()" class="btn btn-success me-md-2" type="button">Proses Bayar</button>
                        <button onclick="location.reload()" class="btn btn-primary" type="button">Transaksi Baru</button>
                    </div>
                </div>
                <!-- -->
            </div>
        </div>
    </div>
</main>
<?= $this->include('pembelian/modal-komik') ?>
<?= $this->include('pembelian/modal-supplier') ?>
<script>
    function load() {
        $('#detail_cart1').load("<?= base_url('beli/load') ?> ");
        $('#spanTotal').load("<?= base_url('beli/gettotal') ?> ");
    }

    $(document).ready(function() {
        load();
    });

    //ubah jumlah
    $(document).on('click', '.ubah_cart', function(){
        var row_id = $(this).attr("id");
        var qty= $(this).attr("qty");
        $('#rowid').val(row_id);
        $('#qty').val(qty);
        $('#modalUbah').modal('show');
    });

    $(document).on('click', '.hapus_cart', function(){
        var row_id = $(this).attr("id");

        $.ajax({
            url: "<?= base_url('beli') ?>/" + row_id,
            method: "DELETE",
            success: function(data){
                load();
            }
        });
    });

    function bayar(){
        var nominal = $('#nominal').val();
        var idsupp = $('#id-supp').val();
        $.ajax({
            url: "<?= base_url('beli/bayar') ?>/",
            method: "POST",
            data: {
                'nominal': nominal,
                'id-supp': idsupp
            },
            success: function(response){
                var result = JSON.parse(response);
                swal({
                    title: result.msg,
                    icon: result.status ? "success" : "error",
                });
                // alert(result.msg);
                load();
                $('#nominal').val("");
                $('#kembalian').val(result.data.kembalian);
                
            }
        });
    }

</script>
<?= $this->endSection() ?>

<style>
    .form-control {
        border-radius: 10px;
        border: 2px solid #ccc;
        padding: 10px;
        font-size: 16px;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
        transition: border-color 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }

    .form-control:focus {
        outline: none;
        border-color: #6c757d;
        box-shadow: 0 0 5px rgba(108, 117, 125, 0.5);
    }
</style>