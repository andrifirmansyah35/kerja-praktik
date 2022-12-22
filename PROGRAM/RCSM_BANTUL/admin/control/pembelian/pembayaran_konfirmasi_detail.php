<?php
// error_reporting(0);
// konfirmasi terkirim
if (isset($_POST['konfirmasi_pembelian_terkirim'])) {
  $id_pembelian_k = $_POST['id_pembelian'];
  query("UPDATE pembelian SET status_pembelian ='selesai' WHERE id_pembelian = $id_pembelian_k");
}

if (isset($_POST['konfirmasi_pembelian_terkemas'])) {
  $id_pembelian_k = $_POST['id_pembelian'];
  query("UPDATE pembelian SET status_pembelian ='pesanan dikirim' WHERE id_pembelian = $id_pembelian_k");
}


// Aksi Konfirmasi ----------------------------------------
if (isset($_POST['konfirmasi_pembayaran'])) {
  $status_pesanan = $_POST['status_pesanan'];
  $id_pembelian = $_POST['id_pembelian'];

  if ($status_pesanan == 'pesanan dikemas') {
    query("UPDATE pembelian SET status_pembelian ='$status_pesanan' WHERE id_pembelian = $id_pembelian");
  } else if ($status_pesanan == 'pesanan batal') {
    pesanan_dibatalkan($id_pembelian);
  }

  // echo "<script>
  //   document.location.href = 'index.php?page=pembelian_konfirmasi'
  // </script>";
}

//Aksi pengiriman -----------------------------------------

if (isset($_GET['id_pembelian']) || $_GET['id_pembelian'] != "") {
  $get_id_pembelian = $_GET['id_pembelian'];
  $data_pembelian = query_result("SELECT * FROM pembelian WHERE id_pembelian = $get_id_pembelian");
  if (@$data_pembelian['id_pelangan']) {
    $id_pelangan = $data_pembelian['id_pelangan'];
    $data_pelangan = query_result("SELECT * FROM pelangan WHERE id_pelangan = $id_pelangan");
  }

  if (@$data_pembelian['id_pembelian']) {
    $id_pembelian = $data_pembelian['id_pembelian'];
    $data_pembelian_detail = query_result_array("SELECT * FROM pembelian_detail WHERE id_pembelian = $id_pembelian");
  }
} else {
  echo "<script>
  document.location.href = 'index.php?page=pembelian_konfirmasi'
  </script>";
}



?>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">

      <div class="row">
        <div class="col-sm-6 mb-2">
          <h1>Detail Pembelian Konfirmasi</h1>
        </div>
      </div>

      <?php if (!$data_pembelian) : ?>
        <div class="row mt-3">
          <div class="col-sm-12">
            <div class="alert alert-secondary">
              <h3 class="text-center my-5">Data Pembelian Tidak Ditemukan</h3>
            </div>
          </div>
        </div>
      <?php endif; ?>



      <?php if ($data_pembelian) : ?>

        <?php if ($data_pembelian['status_pembelian'] == 'menungu konfirmasi') : ?>
          <div class="row">
            <div class="col-sm-12">
              <div class="card">
                <div class="card-body">
                  <h5>Pengesahan Pembayaran</h5>
                  <form action="" method="POST">
                    <div class="input-group input-group-lg">
                      <select class="custom-select" required name="status_pesanan">
                        <option value="pesanan dikemas">Pembayaran Sah(Kemas Pesanan)</option>
                        <option value="pesanan batal">pembayaran Tidak Sah(Batalkan Pesanan pelangan)</option>
                      </select>
                      <input type="hidden" name="id_pembelian" value="<?= $id_pembelian; ?>">
                      <div class="input-group-append">
                        <button class="btn btn-primary" type="submit" name="konfirmasi_pembayaran">submit</button>
                      </div>
                  </form>

                </div>
              </div>
            </div>
          </div>
        <?php endif; ?>


        <!-- KONFIRMASI PENGIRIMAN ================ -->
        <div class="modal fade" id="konfirmasi-kirim-<?= $data_pembelian['id_pembelian']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Pengiriman Pesanan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <table>
                  <tr>
                    <th>nama</th>
                    <td>:</td>
                    <td><?= query_result("SELECT nama FROM pelangan WHERE id_pelangan = $data_pembelian[id_pelangan]")['nama']; ?></td>
                  </tr>
                  <tr>
                    <th>Tanggal Pembelian</th>
                    <td><span style="margin-left: 2px; margin-right: 2px;">:</span></td>
                    <td><?= date('d M Y', strtotime($data_pembelian['tanggal_pembayaran'])); ?></td>
                  </tr>
                </table>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <form action="" method="POST">
                  <input type="hidden" name="id_pembelian" value="<?= $data_pembelian['id_pembelian']; ?>">
                  <button type="submit" class="btn btn-primary" name="konfirmasi_pembelian_terkirim">terkirim</button>
                </form>
              </div>
            </div>
          </div>
        </div>

        <!-- KONFIRMASI PENGEMASAN ================ -->
        <div class="modal fade" id="konfirmasi-pengemasan-<?= $data_pembelian['id_pembelian']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Pengemasan Pesanan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <table>
                  <tr>
                    <th>nama</th>
                    <td>:</td>
                    <td><?= query_result("SELECT nama FROM pelangan WHERE id_pelangan = $data_pembelian[id_pelangan]")['nama']; ?></td>
                  </tr>
                  <tr>
                    <th>Tanggal Pembelian</th>
                    <td><span style="margin-left: 2px; margin-right: 2px;">:</span></td>
                    <td><?= date('d M Y', strtotime($data_pembelian['tanggal_pembayaran'])); ?></td>
                  </tr>
                </table>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <form action="" method="POST">
                  <input type="hidden" name="id_pembelian" value="<?= $data_pembelian['id_pembelian']; ?>">
                  <button type="submit" class="btn btn-primary" name="konfirmasi_pembelian_terkemas">terkemas</button>
                </form>
              </div>
            </div>
          </div>
        </div>

        <?php if ($data_pembelian['status_pembelian'] == 'pesanan dikirim') : ?>
          <div class="row mt-3">
            <div class="col-sm-12">
              <div class="card">
                <div class="card-body text-center">
                  <h5>Pengesahan Pembelian Sudah Diterima Pelangan</h5>

                  <button class="btn btn-success w-80" data-toggle="modal" data-target="#konfirmasi-kirim-<?= $data_pembelian['id_pembelian']; ?>">Pesanan Telah Terkirim</button>

                </div>
              </div>
            </div>
          </div>
        <?php endif; ?>

        <?php if ($data_pembelian['status_pembelian'] == 'pesanan dikemas') : ?>
          <div class="row mt-3">
            <div class="col-sm-12">
              <div class="card">
                <div class="card-body text-center">
                  <h5>Pengesahan Pembelian Sudah Dikemas</h5>

                  <button class="btn btn-success btn-lg w-80" data-toggle="modal" data-target="#konfirmasi-pengemasan-<?= $data_pembelian['id_pembelian']; ?>">Pesanan Telah Dikemas</button>

                </div>
              </div>
            </div>
          </div>
        <?php endif; ?>


        <div class="row">
          <div class="col-md-4">
            <h4>Pesanan</h4>
            <table cellspacing="0" cellpadding="0" style="border: none;">
              <tr>
                <td>Tanggal Bayar</td>
                <td><span style="padding: 0 4px;">:</span></td>
                <td><?= $data_pembelian['tanggal_pembayaran']; ?></td>
              </tr>
              <tr>
                <td>Berat</td>
                <td><span style="padding: 0 4px;">:</span></td>
                <td><strong><?= $data_pembelian['berat']; ?> g</strong></td>
              </tr>
              <tr>
                <td>Total Tagihan</td>
                <td><span style="padding: 0 4px;">:</span></td>
                <td class="text-primary"><strong>RP.<?= $data_pembelian['total_pembayaran']; ?></strong></td>
              </tr>
              <tr>
                <td>Alamat Kirim</td>
                <td><span style="padding: 0 4px;">:</span></td>
                <td><?= $data_pembelian['alamat_pengiriman']; ?></td>
              </tr>
              <tr>
                <td>Status</td>
                <td><span style="padding: 0 4px;">:</span></td>
                <td class="text-info"><strong><?= $data_pembelian['status_pembelian']; ?></strong></td>
              </tr>
            </table>
          </div>

          <div class="col-md-4">
            <h4>Pelangan</h4>
            <table cellspacing="0" cellpadding="0" style="border: none;">
              <tr>
                <td>Nama</td>
                <td><span style="padding: 0 4px;">:</span></td>
                <td><?= $data_pelangan['nama']; ?></td>
              </tr>
              <tr>
                <td>Email</td>
                <td><span style="padding: 0 4px;">:</span></td>
                <td><?= $data_pelangan['email']; ?></td>
              </tr>
              <tr>
                <td>Telp</td>
                <td><span style="padding: 0 4px;">:</span></td>
                <td><?= $data_pelangan['telp']; ?></td>
              </tr>
            </table>
          </div>

          <div class="col-md-4">
            <h4>Pengiriman</h4>
            <table cellspacing="0" cellpadding="0" style="border: none;">
              <!-- <tr>
                <td>Ongkir Provinsi</td>
                <td><span style="padding: 0 4px;">:</span></td>
                <td></?= $; ?></td>
              </tr> -->
              <tr>
                <td>Ekspedisi</td>
                <td><span style="padding: 0 4px;">:</span></td>
                <td><?= $data_pembelian['ekspedisi']; ?></td>
              </tr>
              <tr>
                <td>Ekspedisi kota</td>
                <td><span style="padding: 0 4px;">:</span></td>
                <td><?= $data_pembelian['ekspedisi_kota']; ?></td>
              </tr>
              <tr>
                <td>Ekspedisi paket</td>
                <td><span style="padding: 0 4px;">:</span></td>
                <td><?= $data_pembelian['ekspedisi_paket']; ?></td>
              </tr>

            </table>
          </div>
        </div>


        <!-- Detail Pembayaran -->
        <div class="row mt-5">

          <div class="col-md-5">
            <h4>Bukti Pembayaran </h4>
            <img src="gambar_transaksi/<?= $data_pembelian['bukti_pembayaran']; ?>" class=" img-fluid" alt="<?= $data_pembelian['bukti_pembayaran']; ?>">
          </div>

          <div class="col-md-6">
            <h4>Detail Produk</h4>
            <table class="table table-bordered ">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">produk</th>
                  <th scope="col">harga</th>
                  <th scope="col">Jumlah</th>
                  <th scope="col">Sub Harga</th>
                </tr>
              </thead>
              <tbody>

                <?php
                $nomor = 1;
                foreach ($data_pembelian_detail as $detail) :
                  $id_produk = $detail['id_produk'];
                  $data_produk_pembelian = query_result("SELECT * FROM produk WHERE id = $id_produk");
                ?>
                  <tr>
                    <th scope="row"><?= $nomor; ?></th>
                    <td><?= $data_produk_pembelian['nama']; ?></td>
                    <td><?= $data_produk_pembelian['harga']; ?></td>
                    <td><?= $detail['jumlah_barang']; ?></td>
                    <td><?= $detail['total_harga']; ?></td>
                  </tr>
                <?php
                  $nomor++;
                endforeach;
                ?>


              </tbody>
            </table>
          </div>
        </div>
      <?php
      endif; //($data_pembelian) 
      ?>



    </div>
  </div>
</div>