<?php
session_start();
include 'admin/function.php';

if (isset($_POST['login'])) {
    $login = login_pelangan($_POST);

    if ($login == "login berhasil") {
        $status_login = $login;
        $alert = "success";
        $_SESSION['id_pelangan'] = pelanganByEmail($_POST['email'])['id_pelangan'];
        $_SESSION['login'] = "pelangan";
        header("Location: index.php");
    } else if ($login == "password salah") {
        $status_login = $login;
        $alert = "danger";
    } else if ($login == "email tidak terdaftar") {
        $status_login = $login;
        $alert = "danger";
    }
}

if (isset($_SESSION['login'])) {
    if ($_SESSION['login'] != 'pelangan') {
        header("Location: logout.php");
    }
}

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <title>Login RCSM</title>
    <link rel="stylesheet" href="./css/style-register-login.css">
</head>

<body>
    <div class="container" style="height: 100%">
        <div class="card">
            <div class="d-flex flex-lg-row flex-column-reverse">
                <div class="card card1">
                    <div class="row justify-content-center my-auto">
                        <div class="col-md-8 col-10 my-1">
                            <div class="row justify-content-center px-1 mb-1"> <img id="logo" src="admin/gambar/LOGO RCSM.png"> </div>
                            <h3 class="text-center mb-4" style="color: #222;">Login Akun RCSM Bantul</h3>
                            <form action="" method="POST">
                                <?php if (isset($status_login)) { ?>
                                    <div class="alert alert-<?= $alert; ?>" role="alert">
                                        <?= $status_login; ?>
                                    </div>
                                <?php } ?>
                                <div class="form-group">
                                    <label class="form-control-label text-muted">Email</label>
                                    <input type="text" id="email" name="email" placeholder="Email" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label text-muted">Password</label>
                                    <input type="password" id="psw" name="pswd" placeholder="Password" class="form-control" required>
                                </div>
                                <div class="row justify-content-center my-3 px-3">
                                    <button type="submit" class="btn-block btn-color" name="login">Login</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="bottom text-center mb-1">
                        <p href="#" class="sm-text mx-auto mb-1">Tidak Mempunyai Akun?
                            <a href="register.php" class="buat-akun">Buat Akun</a>
                        </p>
                    </div>
                </div>
                <div class="card card2">
                    <div class="my-auto mx-md-5 px-md-5 right">
                        <h3 class="text-white">Login akun RCSM Kalian</h3> <small class="text-white">Bingung dengan pemilihan produk anda dapat konsultasikan produk apa yang dapat anda pilih dengan bertanya kepada kami.</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
</body>

</html>