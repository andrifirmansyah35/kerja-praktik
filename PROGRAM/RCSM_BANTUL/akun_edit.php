<?php
session_start();
include "admin/function.php";

// Middle ware
if (!isset($_SESSION['login']) || $_SESSION['login'] == "admin" || !isset($_SESSION['id_pelangan'])) {
  header('Location: logout.php');
}
// middleware


$id_pelangan = $_SESSION['id_pelangan'];
$pelangan = query_result("SELECT * FROM pelangan WHERE id_pelangan = $id_pelangan");

// Aksi Ubah 
if (isset($_POST['pelangan_ubah'])) {
  $alert_nama = false;
  $alert_telp = false;

  $nama_baru = $_POST['nama'];
  $telp_baru = $_POST['telp'];

  // 1. Cek Nama ---------------------------------------
  if (strlen($_POST['nama']) == 0) {
    $alert_nama = true;
    $message_nama = 'nama tidak boleh kosong';
  }

  if (preg_match('/[^A-Za-z_ -]/', $_POST['nama'])) {
    // echo "<h1>Invalid Characters!";
    $alert_nama = true;
    $message_nama = 'nama tidak boleh mengandung karakter dan angka';
  }
  // 1. cek nama end -----------------------------------

  // cek telp
  if ($_POST['telp'] == $_POST['telp_lama'] && !$alert_nama) {
    query("UPDATE pelangan SET nama = '$nama_baru' WHERE id_pelangan = $id_pelangan");
  } else {
    if (strlen($_POST['telp']) < 10) {
      $alert_telp = true;
      $message_telp = 'minimal 11 digit';
    }

    if (!$alert_telp) {
      $telp_baru = $_POST['telp'];
      $cek_telp_data_pelangan = query_result_array("SELECT * FROM pelangan WHERE telp = '$telp_baru'");

      if (count($cek_telp_data_pelangan) > 1) {
        // data ada didalam database(uniq telp)
        $alert_telp = true;
        $message_telp = 'no telp sudah digunakan';
        $alert_nama = true;
        $message_nama = 'nama tidak boleh kosong';
      }
    }

    if (!$alert_nama && !$alert_telp) {
      query("UPDATE pelangan SET nama = '$nama_baru' , telp ='$telp_baru' WHERE id_pelangan = $id_pelangan");
      // refresh data pelangan
      $pelangan = query_result("SELECT * FROM pelangan WHERE id_pelangan = $id_pelangan");
    }
  }
}
// Aksi Ubah

?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

  <title>RCSM Bantul</title>
  <link rel="stylesheet" href="asset/style/navbar.css">
  <link rel="stylesheet" href="asset/style/style.css">
</head>

<body>
  <?php include 'menu.php'; ?>
  <div class="spasi-menu" style="height: 100px;"></div>
  <?php

  ?>
  <div class="container mt-3">
    <div class="row justify-content-center">
      <div class="col-md-7">
        <div class="card bg-light">
          <div class="card-body">
            <table class="table table-borderless">
              <thead>
                <tr>
                  <th scope="col" class="text-right"><i class="fas fa-user-circle mr-1" style="font-size: 26px;"></th>
                  <td scope="col"><span style="font-weight: 600; font-size: 26px;"><?= $pelangan['email']; ?></span></td>
                </tr>
              </thead>
              <tbody>

                <form action="" method="POST">
                  <tr>
                    <th scope="col" class="text-right">Nama</th>
                    <td scope="col">
                      <input name="nama" type="text" class="form-control" value="<?= (isset($_POST['pelangan_ubah'])) ? @$_POST['nama'] : $pelangan['nama']; ?>">
                      <?php if (@$alert_nama) { ?>
                        <small class="text-danger">*<?= @$message_nama; ?></small>
                      <?php } ?>
                    </td>
                  </tr>
                  <tr>
                    <th scope="col" class="text-right">Email</th>
                    <td scope="col"><input type="email" class="form-control" value="<?= $pelangan['email']; ?>" readonly></td>
                  </tr>
                  <tr>
                    <th scope="col" class="text-right">Telp</th>
                    <td scope="col">
                      <input name="telp_lama" type="hidden" class="form-control" value="<?= $pelangan['telp']; ?>">
                      <input name="telp" type="number" class="form-control" value="<?= (isset($_POST['pelangan_ubah'])) ? @$_POST['telp'] : $pelangan['telp']; ?>">
                      <?php if (@$alert_telp) { ?>
                        <small class="text-danger">*<?= $message_telp; ?></small>
                      <?php } ?>
                    </td>
                  </tr>
                  <tr>
                    <th scope="col" class="text-right"></th>
                    <td scope="col"><button class="btn btn-info" type="submit" name="pelangan_ubah">Simpan Perubahan</button></td>
                  </tr>
                  <tr>
                    <th scope="col" class="text-right"></th>
                    <td scope="col">
                      <a class="text-info" href="akun_ubah_password.php">ubah password?</a>
                    </td>
                  </tr>
                </form>

              </tbody>
            </table>
            <!-- <p class="text-center" style="color: #000;">klick disini untuk <a class="text-info">mengubah password</a></p> -->
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src=" https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
  <script src="https://kit.fontawesome.com/50cc75fb6a.js" crossorigin="anonymous"></script>
</body>

</html>