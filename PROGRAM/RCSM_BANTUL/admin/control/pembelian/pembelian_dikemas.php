<?php
$pembelian_dikemas = query_result_array("SELECT pembelian.id_pembelian, pelangan.nama AS pelangan_nama,pembelian.ekspedisi_kota AS ekspedisi_kota,pembelian.total_pembayaran AS total_pembayaran 
                                      FROM pembelian JOIN pelangan ON pembelian.id_pelangan = pelangan.id_pelangan 
                                      WHERE pembelian.status_pembelian = 'pesanan dikemas'
                                      ORDER BY pembelian.id_pembelian DESC");
error_reporting(0);

?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6">
          <h1>Pesanan Dikemas</h1>
        </div>
      </div>
      <div class="row">

      </div>
      <div class="row mt-3">
        <div class="col-sm-12">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-body table-responsive p-0">
                  <table class="table table-hover text-nowrap">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Nama Pelangan</th>
                        <th>Kota Pengiriman</th>
                        <th>Total Pembayaran</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>

                      <?php if (!$pembelian_dikemas) : ?>
                        <tr>
                          <td colspan="5" class="text-center text-danger">
                            Pembayaran Konfirmasi Kosong
                          </td>
                        </tr>
                      <?php endif; ?>

                      <?php $nmr = 1; ?>
                      <?php foreach ($pembelian_dikemas as $p) : ?>
                        <tr>
                          <td><?= $nmr; ?></td>
                          <td><?= $p['pelangan_nama']; ?></td>
                          <td><?= $p['ekspedisi_kota']; ?></td>
                          <td><?= $p['total_pembayaran']; ?></td>
                          <td>
                            <a href="index.php?page=pembayaran_konfirmasi_detail&id_pembelian=<?= $p['id_pembelian']; ?>" class="badge badge-info">Cek Detail</a>
                          </td>
                        </tr>
                        <?php $nmr++; ?>
                      <?php endforeach; ?>

                    </tbody>
                  </table>
                </div><!-- /.card-body -->
              </div><!-- /.card -->
            </div>
          </div><!-- /.row -->
        </div>
      </div>
    </div>
  </div>
</div>
</div>