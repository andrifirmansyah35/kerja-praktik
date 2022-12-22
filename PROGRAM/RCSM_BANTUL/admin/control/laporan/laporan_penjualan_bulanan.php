<?php

$tahunTransaksiAll = query_result_array("SELECT tahun_pembayaran FROM pembelian WHERE status_pembelian = 'selesai' GROUP BY tahun_pembayaran");
?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">

      <div class="row">
        <div class="col-sm-6">
          <h1>Penjualan Perbulan</h1>
        </div>
      </div>

      <div class="row">
        <div class="card">
          <?php if ($_POST) {
            $tahun_laporan_penjualan = $_POST['tahun'];
            $_SESSION['tahun_laporan_penjualan'] = $tahun_laporan_penjualan;
            $bulan_tahun_laporan_penjualan = query_result_array("SELECT bulan_pembayaran,tahun_pembayaran FROM pembelian WHERE tahun_pembayaran = '$tahun_laporan_penjualan' GROUP BY bulan_pembayaran;");
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
                <select class="form-control" name="tahun" required>
                  <option value="">---Pilih Tahun---</option>
                  <?php foreach ($tahunTransaksiAll as $tahun) : ?>
                    <option <?php if (isset($_SESSION['tahun_laporan_penjualan'])) {
                              if ($_SESSION['tahun_laporan_penjualan'] == $tahun['tahun_pembayaran']) {
                                echo "selected";
                              }
                            } ?> value="<?= $tahun['tahun_pembayaran']; ?>"><?= $tahun['tahun_pembayaran']; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="input-group mt-2">
                <small class="text-info">*masukkan range tanggal laporan penjualan yang akan dicetak</small>
              </div>

              <div class="input-group mt-3">
                <button type="submit" class="btn btn-primary d-inline-block mr-2" name="penjualan_waktu">submit</button>
                <?php if (@$bulan_tahun_laporan_penjualan) : ?>

                  <a href="../admin/cetak/laporan_penjualan_bulanan.php" target="_blank" class="btn btn-success d-inline-block">print</a>
                <?php endif; ?>
              </div>

            </form>

          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-12">
          <?php if (@$tahun_laporan_penjualan) : ?>
            <div class="card">
              <div class="card-body table-responsive p-0">
                <table class="table table-bordered">
                  <?php foreach ($bulan_tahun_laporan_penjualan as $bulan) : ?>
                    <tr>
                      <td colspan="3">Penjualan : <?= date('F', mktime(0, 0, 0, $bulan['bulan_pembayaran'], 10)); ?> <?= $_SESSION['tahun_laporan_penjualan']; ?></td>
                    </tr>
                    <?php
                    $penjualan = produk_terjual($bulan['bulan_pembayaran'], $_SESSION['tahun_laporan_penjualan']);
                    ?>
                    <?php $nmr = 1; ?>
                    <?php foreach ($penjualan as $p) : ?>
                      <tr>
                        <td><?= $nmr; ?></td>
                        <td><?= $p['nama']; ?></td>
                        <td><?= $p['jumlah_terjual']; ?>pcs</td>
                      </tr>
                      <?php $nmr++; ?>
                    <?php endforeach; ?>
                    <tr>
                      <td>Profit : </td>
                      <td><?= profit_penjualan($bulan['bulan_pembayaran'], $_SESSION['tahun_laporan_penjualan'])['profit_bulanan']; ?></td>
                    </tr>
                  <?php endforeach; ?>
                </table>
              </div>
            </div>
          <?php endif; ?>
        </div>
      </div>

    </div>
  </div>
</div>
</div>