<?php
$dataKategori = kategori("SELECT * FROM kategori");
?>
<nav class="navbar navbar-expand-lg navbar-menu fixed-top">
    <div class="container">
        <a class="navbar-brand" href="index.php"><img src="admin/gambar/LOGO RCSM.png" alt="" style="height: 60px;"></a>
        <button class="navbar-toggler text-light" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon">aa</span>
        </button>

        <div class="collapse navbar-collapse nav-haha" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">Home <span class=" sr-only">(current)</span></a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Kategori
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="index.php">Semua</a>
                        <?php foreach ($dataKategori as $kategori) : ?>
                            <a class="dropdown-item" href="index.php?kategori=<?= $kategori['id']; ?>"><?= $kategori['nama']; ?></a>
                        <?php endforeach; ?>
                    </div>
                </li>
                <?php if (isset($_SESSION['id_pelangan'])) { ?>
                <?php } else { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">Register</a>
                    </li>
                <?php } ?>

                <?php if (isset($_SESSION['id_pelangan'])) { ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-user-circle mr-1"></i>
                            <?php
                            $id_pelangan = $_SESSION['id_pelangan'];
                            $nama_pelangan = query_result("SELECT * FROM pelangan WHERE id_pelangan = $id_pelangan")['nama'];
                            echo user_nama($nama_pelangan); ?>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="akun_edit.php"><i class="fas fa-user mr-3 w-4 d-inline-block"></i>Profile</a>
                            <a class="dropdown-item" href="keranjang_belanja.php"><i class="fas fa-shopping-bag mr-3 w-4 d-inline-block"></i>Keranjang</a>
                            <a class="dropdown-item" href="pesanan_daftar.php"><i class="fas fa-archive mr-3 w-4 d-inline-block"></i>Pesanan</a>
                            <a class="dropdown-item" href="pesanan_riwayat.php"><i class="fas fa-clipboard-list mr-3 w-2 d-inline-block"></i>Riwayat Pesanan</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item btn btn-danger bg-danger rounded-0 text-white" data-toggle="modal" data-target="#exampleModal">Logout</a>

                        </div>
                    </li>
                <?php } //data user 
                ?>
            </ul>
        </div>
    </div>
</nav>


<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Logout</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-footer">
                <a href="logout.php" type="button" class="btn btn-danger w-100">logout</a>
            </div>
        </div>
    </div>
</div>