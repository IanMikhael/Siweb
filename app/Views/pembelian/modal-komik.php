<div class="modal fade" id="modalKomik" aria-hidden="true" 
aria-labelledby="exampleModalToggleLabel" tabindex="-l">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalToggleLabel">DATA KOMIK</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
  <!-- Tabel Komik -->
  <table id="datatablesSimple">
    <thead>
      <tr>
        <th width="5%">No</th>
        <th width="10%">Sampul</th>
        <th width="30%">Judul</th>
        <th width="15%">Tahun</th>
        <th width="15%">Harga</th>
        <th width="10%">Stok</th>
        <th width="15%">Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php $no = 1;
      foreach ($dataKomik as $value) : ?>
        <tr>
          <td><?= $no++ ?></td>
          <td>
            <img src="img/<?= $value['cover'] ?>" alt="" width="100">
          </td>
          <td><?= $value['judul'] ?></td>
          <td><?= $value['tahun_rilis'] ?></td>
          <td><?= $value['harga'] ?></td>
          <td><?= $value['stok'] ?></td>

          <td>
            <button onclick="add_cart('<?= $value['komik_id'] ?>','<?= $value['judul'] ?>', '<?= $value['harga'] ?>','<?= $value['diskon'] ?>')"  class="btn btn-success"><i class="fa fa-cart-plus"></i>Tambahkan</button>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <!-- -->
</div>


      <div class="modal-footer">
        <button class="btn btn-primary" data-bs-dismiss="modal">tutup</button>
      </div>
    </div>
  </div>
</div>
<script>


    function add_cart(id, name, price, discount){
        $.ajax({
            url: "<?= base_url('beli') ?>",
            method: "POST",
            data: {
                id: id,
                name: name,
                qty: 1,
                price: price,
                discount: discount,
            },
            success: function(data){
                load()
            }
        });
    }
</script>

<div class="modal fade" id="modalUbah" aria-hidden="true"
aria-labelledby="exampleModalToggle" tabindex="-1">
<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-l">

    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalToggleLable">UBAH JUMLAH PRODUK</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <div class="row mt-3">
          <div class="col-sm-7">
            <input type="hidden" id="rowid">
            <input type="number" id="qty" class="form-control"
            placeholder="Masukkan Jumlah Produk" min="1" value="1">
          </div>

          <div class="col-sm-5">
            <button class="btn btn-primary" onclick="update_cart()">Simpan</button>
          </div>
        </div>
      </div>

      <script>
         function update_cart()
    {
      var rowid = $('#rowid').val();
      var qty   = $('#qty').val();

      $.ajax(
        {
          url: "<?= base_url('beli/update') ?>",
          method: "POST",
          data: {
            rowid: rowid,
            qty: qty,
          },
          success: function(data)
        {
          load();
          $('#modalUbah').modal('hide');
        }
        });
    }
    
    </script>

    </div>
</div>
</div>


<!-- <style> 
.modal-content {
  background-image: linear-gradient(to bottom right, #4c6bed, #69c1ff);
  background-color: #4c6bed;
}
</style -->
 <!-- <td>
            <button class="btn btn-success">
              <i class="fa fa-cart-plus"></i>Tambahkan
            </button>
          </td> -->


          

