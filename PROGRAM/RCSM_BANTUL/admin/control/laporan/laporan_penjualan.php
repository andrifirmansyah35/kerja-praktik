<?php

$tahunTransaksiAll = query_result_array("SELECT tahun_pembayaran FROM pembelian WHERE status_pembelian = 'selesai' GROUP BY tahun_pembayaran");
// var_dump($_SESSION);
$input_bulan = [
  ['no_bulan' => '01', 'nama_bulan' => 'Januari'],
  ['no_bulan' => '02', 'nama_bulan' => 'Febuari'],
  ['no_bulan' => '03', 'nama_bulan' => 'Maret'],
  ['no_bulan' => '04', 'nama_bulan' => 'April'],
  ['no_bulan' => '05', 'nama_bulan' => 'Mei'],
  ['no_bulan' => '06', 'nama_bulan' => 'Juni'],
  ['no_bulan' => '07', 'nama_bulan' => 'Juli'],
  ['no_bulan' => '08', 'nama_bulan' => 'Agustus'],
  ['no_bulan' => '09', 'nama_bulan' => 'September'],
  ['no_bulan' => '10', 'nama_bulan' => 'Oktober'],
  ['no_bulan' => '11', 'nama_bulan' => 'November'],
  ['no_bulan' => '12', 'nama_bulan' => 'Desember']
];

?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">

      <div class="row">
        <div class="col-sm-6">
          <h1>Penjualan</h1>
        </div>
      </div>

      <div class="row">
        <div class="card">
          <?php if ($_POST) {


            $tgl1 = $_POST['tanggal1'];
            $tgl2 = $_POST['tanggal2'];

            $_SESSION['laporan_tgl1'] = $tgl1;
            $_SESSION['laporan_tgl2'] = $tgl2;

            $penjualan = query_result_array("SELECT produk.nama,SUM(pembelian_detail.jumlah_barang) AS jumlah_terjual
                                              FROM pembelian_detail 
                                              LEFT JOIN produk ON pembelian_detail.id_produk = produk.id 
                                              LEFT JOIN pembelian ON pembelian_detail.id_pembelian = pembelian.id_pembelian
                                              WHERE pembelian.status_pembelian = 'selesai' AND
                                              tanggal_pembayaran BETWEEN '$tgl1' AND '$tgl2' 
                                              GROUP BY produk.nama
                                              ORDER BY jumlah_terjual DESC");


            $profit = query_result("SELECT SUM(pembelian_detail.keuntungan_perproduk) AS profit_bulanan
            FROM pembelian_detail 
            LEFT JOIN produk ON pembelian_detail.id_produk = produk.id 
            LEFT JOIN pembelian ON pembelian_detail.id_pembelian = pembelian.id_pembelian
            WHERE pembelian.status_pembelian = 'selesai' AND
            tanggal_pembayaran BETWEEN '$tgl1' AND '$tgl2' ")['profit_bulanan'];
          } ?>
        </div>
      </div>

      <div class="row mt-3">
        <div class="card col-md-12">
          <div class="card-body">
            <div class="card-title"><STRONG>Tanggal Range transaksi</STRONG></div>
            <br>
            <!-- form untuk mengubah data jadwal transaksi -->
            <form action="" method="POST">

              <div class="input-group mt-3">
                <input type="date" class="form-control" name="tanggal1" required value="<?= @$_SESSION['laporan_tgl1']; ?>">
                <input type="date" class="form-control" name="tanggal2" required value="<?= @$_SESSION['laporan_tgl2']; ?>">
              </div>

              <div class="input-group mt-2">
                <small class="text-info">*masukkan range tanggal laporan penjualan yang akan dicetak</small>
              </div>

              <div class="input-group mt-3">
                <button type="submit" class="btn btn-primary d-inline-block mr-2" name="penjualan_waktu">submit</button>
                <?php if (@$penjualan) : ?>

                  <a href="../admin/cetak/laporan_penjualan.php" target="_blank" class="btn btn-success d-inline-block">print</a>
                <?php endif; ?>
              </div>

            </form>

          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-12">

          <?php if (isset($penjualan)) : ?>
            <div class="card">
              <div class="card-body table-responsive p-0">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama produk</th>
                      <th>Jumlah</th>
                    </tr>
                  </thead>
                  <?php if ($penjualan) { ?>
                    <tbody>
                      <?php $nmr = 1; ?>
                      <?php foreach ($penjualan as $p) : ?>
                        <tr>
                          <td><?= $nmr; ?></td>
                          <td><?= $p['nama']; ?></td>
                          <td><?= $p['jumlah_terjual']; ?>pcs</td>
                        </tr>
                        <?php $nmr++; ?>
                      <?php endforeach; ?>
                    </tbody>
                  <?php } else { ?>
                    <tr>
                      <td colspan="3" class="text-center">Kosong</td>
                    </tr>
                  <?php } ?>
                </table>
              </div><!-- /.card-body -->
            </div><!-- /.card -->
          <?php endif; //table penjualan 
          ?>

        </div>
      </div>
      <?php if (isset($penjualan)) : ?>
        <div class="row">
          <div class="col-md-12">
            <div class="alert alert-success">
              <h4><strong>Profit</strong> : Rp <?= $profit; ?></h4>
            </div>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>
</div>