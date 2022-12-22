<?php
session_start();
include('../function.php');
// require_once('function.php');

// Middleware
if (!isset($_SESSION['login']) || $_SESSION['login'] != "admin" || isset($_SESSION['id_pelangan'])) {
  echo "";
}
// Middleware
if (isset($_SESSION['login']) && $_SESSION['login'] == "admin") {
  $pelangan = pelangan();
}

if (isset($pelangan)) {
  if ($pelangan) {
?>
    <!doctype html>
    <html lang="en">

    <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
      <!-- <link rel="stylesheet" href="css/bootstrap.css"> -->
      <title>Laporan Pelangan <?= date('d M Y'); ?></title>
      <style>
        @media print {
          .button-print {
            display: none;
          }
        }
      </style>
    </head>

    <body>
      <!-- Content Header (Page header) -->
      <div class="container-fluid">
        <div class="row text-center">
          <div class="col">
            <img src="../gambar/LOGO RCSM.png" width="70px" class="d-inline-block">
            <h1>Data Pelangan</h1>
            <?php date_default_timezone_set('Asia/Jakarta'); ?>
            <p>Tanggal cetak : <?= date('d M Y'); ?></p>
          </div>
        </div>
        <div class="row button-print">
          <div class="card-body">
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-default">
              Print or Save
            </button>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-body table-responsive p-0">
                    <table class="table table-bordered">
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

      <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
      <!-- <script src="js/bootstrap.js"></script> -->

    </body>
    <script>
      window.print()

      const buttonPrint = document.querySelector('.button-print');

      buttonPrint.addEventListener('click', function() {
        window.print();
      })
    </script>

    </html>

<?php }
} ?>