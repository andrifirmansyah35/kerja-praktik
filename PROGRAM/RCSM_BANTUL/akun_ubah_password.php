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

// Password ubah aksi ----------------------------------------
if (isset($_POST['password_ubah'])) {
  $alert_passLama = false;
  $alert_passBaru = false;
  $alert_passKonfirmasi = false;

  if (strlen($_POST['passBaru']) < 1) {
    $alert_passLama = true;
    $message_passLama = "tidak boleh kosong";
  }

  if (strlen($_POST['passBaru']) < 1) {
    $alert_passBaru = true;
    $message_passBaru = "tidak boleh kosong";
  }

  if (strlen($_POST['passKonfirmasi']) < 1) {
    $alert_passKonfirmasi = true;
    $message_passKonfirmasi = "tidak boleh kosong";
  }

  if (!$alert_passBaru) {
    if (strlen($_POST['passBaru']) < 8) {
      $alert_passBaru = true;
      $message_passBaru = "password minimal 8 digit";
    }
  }
  if (!$alert_passBaru && !$alert_passKonfirmasi) {
    if ($_POST['passBaru'] != $_POST['passKonfirmasi']) {
      $alert_passKonfirmasi = true;
      $message_passKonfirmasi = "password konfirmasi tidak sama";
    }
  }

  if (!$alert_passLama && !$alert_passLama && !$alert_passKonfirmasi) {
    if (!cek_password_pelangan($_POST['passLama'], $id_pelangan)) {
      $alert_passLama = true;
      $message_passLama = "password salah";
    } else if (cek_password_pelangan($_POST['passLama'], $id_pelangan)) {
      // Update password
      ubah_password_pelangan($_POST['passBaru'], $id_pelangan);
      echo "<script>
      alert('Password berhasil diubah');
      </script>";
    }
  }
}
// passwordubah end ------------------------------------------
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

            <form action="" method="POST">
              <table class="table table-borderless">
                <thead>
                  <tr>
                    <th scope="col" class="text-right"><i class="fas fa-user-circle mr-1" style="font-size: 26px;"></th>
                    <td scope="col"><span style="font-weight: 600; font-size: 26px;"><?= $pelangan['email']; ?></span></td>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th scope="col" class="text-right">Password Lama</th>
                    <td scope="col">
                      <input name="passLama" type="password" class="form-control" value="">
                      <?php if (@$alert_passLama) { ?>
                        <small class="text-danger">*<?= $message_passLama; ?></small>
                      <?php } ?>
                    </td>
                  </tr>
                  <tr>
                    <th scope="col" class="text-right">Password Baru</th>
                    <td scope="col">
                      <input name="passBaru" type="password" class="form-control" value="">
                      <?php if (@$alert_passBaru) { ?>
                        <small class="text-danger">*<?= $message_passBaru; ?></small>
                      <?php } ?>
                    </td>
                  </tr>
                  <tr>
                    <th scope="col" class="text-right">
                      <p>Konfirmasi Password</p>
                    </th>
                    <td scope="col"><input name="passKonfirmasi" type="password" class="form-control" value="">
                      <?php if (@$alert_passKonfirmasi) { ?>
                        <small class="text-danger">*<?= @$message_passKonfirmasi; ?></small>
                      <?php } ?>
                    </td>
                  </tr>
                  <tr>
                    <th scope="col" class="text-right"></th>
                    <td scope="col"><button name="password_ubah" type="submit" class="btn btn-info">Ubah Password</button></td>
                  </tr>
                  <tr>
                    <th scope="col" class="text-right"></th>
                    <td scope="col">
                      <a class="text-info" href="akun_edit.php">kembali ke-profil</a>
                    </td>
                  </tr>
                </tbody>
              </table>
            </form>
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