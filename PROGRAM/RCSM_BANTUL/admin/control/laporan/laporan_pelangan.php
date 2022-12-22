<?php
$pelangan = pelangan();
error_reporting(0);
?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6">
          <h1>Pelangan</h1>
        </div>
      </div>
      <div class="row">
        <div class="card-body">
          <a href="../admin/cetak/laporan_pelangan.php" target="_blank" class="btn btn-success">print</a>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-body table-responsive p-0">
                  <table class="table table-hover text-nowrap">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Telp</th>
                        <!-- <th>Aksi</th> -->
                      </tr>
                    </thead>
                    <tbody>
                      <?php $nmr = 1; ?>
                      <?php foreach ($pelangan as $p) : ?>
                        <tr>
                          <td><?= $nmr; ?></td>
                          <td><?= $p['nama']; ?></td>
                          <td><?= $p['email']; ?></td>
                          <td><?= $p['telp']; ?></td>
                          <!-- <td>
                                                        <a href="index.php?page=kategorihapus&id=?= $k['id']; ?>" class="badge badge-danger" onclick=" return confirm('yakin');">hapus</a>
                                                    </td> -->
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