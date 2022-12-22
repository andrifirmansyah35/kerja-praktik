<?php
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

$tahunTransaksiAll = query_result_array("SELECT tahun_pembayaran FROM pembelian WHERE status_pembelian = 'selesai' GROUP BY tahun_pembayaran");

// 
if (@$_POST) {
  // Middleware
  date_default_timezone_set('Asia/Jakarta');

  $tgl1 = $_POST['tanggal1'];
  $tgl2 = $_POST['tanggal2'];

  $_SESSION['laporan_tgl1'] = $tgl1;
  $_SESSION['laporan_tgl2'] = $tgl2;


  $pembelian = query_result_array("SELECT * FROM pembelian WHERE tanggal_pembayaran BETWEEN '$tgl1' AND '$tgl2'");
}
?>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">

      <div class="row">
        <div class="col-sm-6">
          <h1>Transaksi</h1>
        </div>
      </div>

      <div class="row mt-3">
        <div class="card col-md-12">
          <div class="card-body">
            <div class="card-title"><STRONG>Tanggal Transaksi</STRONG></div>
            <br>
            <!-- form untuk mengubah data jadwal transaksi -->
            <form action="" method="POST">

              <div class="input-group mt-3">
                <input type="date" class="form-control" name="tanggal1" required value="<?= @$_SESSION['laporan_tgl1']; ?>">
                <input type="date" class="form-control" name="tanggal2" required value="<?= @$_SESSION['laporan_tgl2']; ?>">
              </div>

              <div class="input-group mt-3">
                <button type="submit" class="btn btn-primary d-inline-block mr-2" name="penjualan_waktu">submit</button>
                <?php if (@$pembelian) : ?>
                  <a href="../admin/cetak/laporan_transaksi.php" target="_blank" class="btn btn-success d-inline-block">print</a>
                <?php endif; ?>
              </div>

            </form>

          </div>
        </div>
      </div>

      <!-- data transaksi start ------------------------------------------------------------------------------------------- -->
      <?php if (isset($pembelian)) : ?>
        <?php if ($pembelian) { ?>
          <div class="row">
            <div class="col-sm-12">
              <div class="card">
                <div class="card-body table-responsive p-0">
                  <table class="table table-bordered">
                    <tbody>
                      <?php $nmr = 1; ?>
                      <?php foreach ($pembelian as $p) : ?>
                        <tr class="bg-light">
                          <?php
                          $id_pelangan = $p['id_pelangan'];
                          $data_pelangan = query_result("SELECT * FROM pelangan WHERE id_pelangan = $id_pelangan");
                          ?>
                          <td colspan="3"><strong class="text-primary">Transaksi Oleh : </strong> <?= $data_pelangan['nama'] . " (" . $data_pelangan['email'] . ") -" . $data_pelangan['telp']; ?> (<a href="index.php?page=pembayaran_konfirmasi_detail&id_pembelian=<?= $p['id_pembelian']; ?>">details</a>)</td>
                        </tr>
                        <tr>
                          <td><strong>Tanggal Pembayaran</strong> : <?= $p['tanggal_pembayaran']; ?></td>

                          <td colspan="2"><strong>Total Pembayaran :</strong> Rp.<?= $p['total_pembayaran']; ?></td>
                        </tr>
                        <tr>
                          <td><strong>Paket Pengiriman : </strong><?= $p['ekspedisi_paket']; ?>(<?= $p['ekspedisi']; ?>)</td>
                          <td><strong>total berat : </strong><?= $p['berat']; ?>gram</td>
                          <td><strong>biaya pengiriman : </strong>Rp.<?= $p['biaya_pengiriman']; ?></td>
                        </tr>
                        <tr>
                          <td colspan="3" class="text-center bg-light">
                            <strong>---------------------Detail Produk Dibeli---------------------</strong>
                          </td>
                        </tr>

                        <?php $id_pembelian = $p['id_pembelian']; ?>
                        <?php $data_pembelian_detail = query_result_array("SELECT produk.nama,pembelian_detail.jumlah_barang,pembelian_detail.total_harga FROM pembelian_detail 
                                                                        INNER JOIN produk ON pembelian_detail.id_produk=produk.id 
                                                                        WHERE pembelian_detail.id_pembelian = $id_pembelian;"); ?>

                        <?php foreach ($data_pembelian_detail as $d) : ?>
                          <tr>
                            <td><?= $d['nama']; ?></td>
                            <td><?= $d['jumlah_barang']; ?>pcs</td>
                            <td>Rp.<?= $d['total_harga']; ?></td>
                          </tr>
                        <?php endforeach; ?>

                        <?php $nmr++; ?>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div><!-- /.card-body -->
              </div><!-- /.card -->
            </div>
          </div>
        <?php } else { ?>
          <div class="row">
            <div class="col-sm-12">
              <div class="card">
                <div class="card-body table-responsive p-3">
                  <h3 class="text-center"><strong>Data Kosong</strong></h3>
                </div>
              </div>
            </div>
          </div>
        <?php } ?>
      <?php endif; ?>
      <!-- data transaksi end ------------------------------------------------------------------------------------------- -->

    </div>
  </div>
</div>