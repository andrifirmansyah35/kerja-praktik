<?php
include "admin/function.php";
session_start();

// MIDDLE WARW --------------------
if (@$_SESSION['login']) {
    header('Location: index.php');
}
// Middleware ----------------------
if (isset($_POST['daftar'])) {
    $alert_nama = false;
    $alert_email = false;
    $alert_telp = false;
    $alert_password = false;

    $reg_nama = $_POST['nama'];
    $reg_email = $_POST['email'];
    $reg_telp = $_POST['telp'];
    $reg_password = $_POST['psw'];

    // 1 ---------  validasi nama
    if (strlen($reg_nama) < 5) {
        $alert_nama = true;
        $alert_nama_pesan = "Minimal nama 5 karakter";
    }

    if (strlen($reg_nama) > 40) {
        $alert_nama = true;
        $alert_nama_pesan = "nama terlalu panjang";
    }

    if (preg_match('/[^A-Za-z_ -]/', $reg_nama)) {
        $alert_nama = true;
        $alert_nama_pesan = 'nama tidak boleh memuat karakter atau angka';
    }

    // Validasi email
    if ($reg_email) {
        $cari_email = query_result_array("SELECT * FROM pelangan WHERE email = '$reg_email'");
        $jumlah_email = count($cari_email);

        if ($jumlah_email > 0) {
            $alert_email = true;
            $alert_email_pesan = "Email sudah digunakan";
        }
    }

    // validasi no telp
    if (strlen($reg_telp) < 11  || strlen($reg_telp) > 13) {
        $alert_telp = true;
        $alert_telp_pesan = "no telepon yang dimasukkan tidak valid";
    }

    if (!$alert_telp) {
        $cari_telp = query_result_array("SELECT * FROM pelangan WHERE telp = '$reg_telp'");
        $jumlah_telp = count($cari_email);

        if ($jumlah_telp > 0) {
            $alert_telp = true;
            $alert_telp_pesan = "no telp sudah digunakan";
        }
    }

    if (strlen($reg_password) < 8) {
        $alert_password = true;
        $alert_password_pesan = "Minimal password 8 digit";
    }

    if (strlen($reg_password) > 25) {
        $alert_password = true;
        $alert_password_pesan = "password terlalu panjang";
    }

    if (!$alert_nama && !$alert_email &&  !$alert_telp &&  !$alert_password) {
        $nama = htmlspecialchars($reg_nama);
        $email = htmlspecialchars($reg_email);
        $telp = $reg_telp;
        $password = password_hash($reg_password, PASSWORD_DEFAULT);

        query("INSERT INTO pelangan (nama,telp,email,paswd) VALUES ('$nama','$telp','$email','$password')");
        $alert = true;
        $alert_status = "success";
        $message = "<strong>Pendaftaran  Sukses</strong> <br> Silahkan login pada link dibawah";
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <title>RCSM | registrasi Akun</title>
    <link rel="stylesheet" href="./css/style-register.css">
</head>

<body>
    <div class="container px-4 py-5 mx-auto register-body">
        <div class="card card0">
            <div class="d-flex flex-lg-row flex-column-reverse">
                <div class="card card1">
                    <div class="row justify-content-center my-auto">
                        <div class="col-md-12 col-12">
                            <div class="row justify-content-center px-1 mb-1"> <img id="logo" src="admin/gambar/LOGO RCSM.png"> </div>
                            <h3 class="mb-1 text-center ">Registrasi Akun</h3>

                            <form action="" method="POST">
                                <?php if (@$alert) : ?>
                                    <div class="alert alert-<?= $alert_status; ?> text-center" role="alert">
                                        <?= $message; ?>
                                    </div>
                                <?php endif ?>
                                <div class="form-group">
                                    <label class="form-control-label text-muted">Nama</label>
                                    <input type="text" id="nama" name="nama" placeholder="Nama Lengkap" class="form-control" required value="<?= @$_POST['nama']; ?>" autocomplete="off">
                                    <?php if (@$alert_nama) { ?>
                                        <div class="ml-2 mt-2 text-danger" style="margin-bottom: -10px; font-size: 14px">
                                            *<?= $alert_nama_pesan; ?>
                                        </div>
                                    <?php } ?>

                                </div>
                                <div class="form-group">
                                    <label class="form-control-label text-muted">Email</label>
                                    <input type="email" id="email" name="email" placeholder="Email" class="form-control" required value="<?= @$_POST['email']; ?>" autocomplete="off">
                                    <?php if (@$alert_email) { ?>
                                        <div class="ml-2 mt-2 text-danger" style="margin-bottom: -10px; font-size: 14px">
                                            *<?= $alert_email_pesan; ?>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label text-muted">Telepon</label>
                                    <input type="number" id="telp" name="telp" placeholder="No Telp" class="form-control" required value="<?= @$_POST['telp']; ?>">
                                    <?php if (@$alert_telp) { ?>
                                        <div class="ml-2 mt-2 text-danger" style="margin-bottom: -10px; font-size: 14px">
                                            *<?= $alert_telp_pesan; ?>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label text-muted">Password</label>
                                    <input type="password" id="psw" name="psw" placeholder="Password" class="form-control" required>
                                    <?php if (@$alert_password) { ?>
                                        <div class="ml-2 mt-2 text-danger" style="margin-bottom: -10px; font-size: 14px">
                                            *<?= $alert_password_pesan; ?>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="row justify-content-center my-1 px-1"> <button class="btn-block btn-color" type="submit" name="daftar">Daftarkan</button> </div>
                            </form>
                            <a href="login.php" class="row justify-content-center mt-3 py-2 login">Login Sekarang</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
    <script>
        // const input_nama = document.querySelector('#nama');
        // const input_email = document.querySelector('#email');
        // const input_telp = document.querySelector('#telp');
        // const input_psw = document.querySelector('#psw');

        // let nilai_nama = ""
        // let nilai_email = ""
        // let nilai_telp = ""
        // let nilai_psw = ""

        // input_nama.addEventListener('keyup', function() {
        //     nilai_nama = input_nama.value
        //     if (!/^[0-9]+$/.test(nilai_nama)) {
        //         alert("Please only enter numeric characters only for your Age! (Allowed input:0-9)")
        //     }
        // })

        // function validation(){
        //     if()
        // }
    </script>
</body>

</html>