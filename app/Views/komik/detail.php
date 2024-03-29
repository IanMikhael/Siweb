<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">DATA KOMIK </h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">
                Pengelolaan Data Komik
            </li>
        </ol>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                <?= $judul ?>

            </div>
            <div class="card-body">
                <!--Tabel Buku-->
                <div class="card mb-3">
                    <div class="row g-0">
                        <div class="col-md-4">
                        <div class="d-flex align-items-center justify-content-center GAP-y-0">
                            <img src="<?= base_url('img/' . $result['cover'])?>" alt="" width="50%">
                        </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title"><?= $result['judul'] ?></h5>
                                <p class="card-text">Penulis:<?= $result['penulis'] ?></p>
                                <p class="card-text">Tahun Rilis:<?= $result['tahun_rilis'] ?></p>
                                <p class="card-text">Stok:<?= $result['stok'] ?></p>
                                <p class="card-text">Harga:<?= $result['harga'] ?></p>
                                <p class="card-text">Diskon:<?= $result['diskon'] ?></p>
                                <div class="d-grid gap-2 d-md-block">
                                    <a class="btn btn-dark" type="button" href="<?= base_url('komik') ?>">Kembali</a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?= $this->endSection() ?>