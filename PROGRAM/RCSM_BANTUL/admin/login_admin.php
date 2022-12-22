<?php
session_start();

if (isset($_SESSION["login"])) {
    if ($_SESSION['login'] == "admin") {
        header("Location: index.php");
        exit;
    }
}
$error = false;

if (isset($_POST)) {
    // var_dump($_POST);
    if (isset($_POST["login"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];
        $conn = mysqli_connect('localhost', 'root', '', 'rcsm');
        $result = mysqli_query($conn, "SELECT * FROM admin WHERE username = '$username'");

        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            if (password_verify($password, $row["password"])) {
                $_SESSION["login"] = "admin";
                $_SESSION['nama_admin'] = $row['nama_lengkap'];
                $_SESSION['id_admin'] = $row['id'];
                // echo "<h1>Password Sama</h1>";
                header("Location: index.php");
                exit;
            }
        } else {
            $error = true;
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RCSM Bantul | Login Admin</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
    <img src="gambar/LOGO RCSM.png" style="max-width: 200px;" class="d-block text-center">
    <div class="login-box">
        <div class="login-logo">
            <a href=""><b>Admin </b>RCSM BANTUL</a>
        </div>

        <!-- /.login-logo -->
        <div class="card">

            <div class="card-body login-card-body">
                <form action="" method="post">
                    <?php if ($error) : ?>
                        <div class="alert alert-danger text-center" role="alert">
                            Data Admin Tidak Ditemukan
                        </div>
                    <?php endif; ?>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Username" autocomplete="off" name="username" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" placeholder="Password" autocomplete="off" name="password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <button type="submit" class="btn btn-primary d-flex justify-content-center" style="width: 100%;" name="login">Login</button>
                    </div>
                </form>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
</body>

</html>