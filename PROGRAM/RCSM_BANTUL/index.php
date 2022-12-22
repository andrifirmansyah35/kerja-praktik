<?php
session_start();
include "admin/function.php";

$pagination = false;
$dataPerhalaman = 7;
$kategori = isset($_GET['kategori']) ? $_GET['kategori'] : null;

if ($kategori != null) {
    if (getByIDkategori($_GET['kategori']) > 0) {
        $jumlahData = count(produkByKategori($_GET['kategori']));
        $jumlahHalaman = ceil($jumlahData / $dataPerhalaman);
        $halamanAktif = (isset($_GET['halaman'])) ? $_GET["halaman"] : 1;
        $awalData = ($dataPerhalaman * $halamanAktif) - $dataPerhalaman;
        $dataProdukPage = produkPageByIDKategori($_GET['kategori'], $awalData, $dataPerhalaman);
        $dataProduk = $dataProdukPage;
        // var_dump($dataProduk);   
        // $dataProduk = produkByKategori($_GET['kategori']);
        $pagination = true;
    } else {
        echo "<script>
        alert('Kategori Tidak Ditemukan');
        document.location.href='index.php';
        </script>
        ";
    }
} else if ($kategori == null) {
    $jumlahData = count(produk());
    $jumlahHalaman = ceil($jumlahData / $dataPerhalaman);
    $halamanAktif = (isset($_GET['halaman'])) ? $_GET["halaman"] : 1;
    $awalData = ($dataPerhalaman * $halamanAktif) - $dataPerhalaman;
    $dataProdukPage = produkPage($awalData, $dataPerhalaman);
    $dataProduk = $dataProdukPage;
    $pagination = true;
}

// 3. Search 
if (isset($_POST["cari"])) {
    if (isset($_POST["keyword"])) {
        // $url = strtok($url, '?');
        $dataProduk = produk_cari($_POST["keyword"]);
        // var_dump($dataProduk);
    } else {
        echo "
        <script>
            alert('Anda belum Memasukkan kunci Pencarian');
        </script>
    ";
    }
    mysqli_error_list($conn);
    $pagination = false;
}

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

    <div class="container">
        <form action="" method="POST">
            <div class="row mb-4 mt-5">
                <div class="input-group mb-3 col-sm-8  mx-auto form-pencarian-produk">
                    <input type="text" class="form-control border-danger" placeholder="Pencarian Produk..." name="keyword" value="<?= @$_POST['keyword']; ?>">
                    <button class="btn btn-pencarian bg-danger rounded-0 rounded-right" type="submit" name="cari"><i class="fas fa-search text-white"></i></button>
                </div>
            </div>
        </form>
    </div>
    <div class="container">
        <div class="row mb-2">
            <h3 class="ml-2" style="color:rgb(235, 78, 104); font-weight: 400">
                <?php if ($dataProduk) { ?>
                    Produk
                <?php } ?>
            </h3>
        </div>
        <div class="row">
            <?php if ($dataProduk) { ?>
                <?php foreach ($dataProduk as $produk) : ?>
                    <a class="col-md-3 col-sm-4 col-6 d-produk mb-2 " href="detail.php?id=<?= $produk['id']; ?>">
                        <div class="display">
                            <div class="produk-img">
                                <img src="admin/gambar/<?= $produk['gambar']; ?>" alt="">
                            </div>
                            <div class="produk-caption">
                                <p style="margin-top:10px; color: black;"><?= $produk['nama']; ?></p>
                                <p style="font-size: 24px; color: #111; font-weight: 600; margin-top: -20px;">Rp <?= number_format($produk['harga'], 0, ",", "."); ?></p>
                                <p class="p-stock">stock <?= $produk['stok']; ?></p>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php } else { ?>
                <div class="col-md-12 text-center">
                    <h1>produk tidak Ditemukan</h1>
                </div>
            <?php  } ?>
        </div>
    </div>
    <div class="container">
        <div class="row ">
            <nav aria-label="..." mx-auto>
                <?php if ($pagination) : ?>
                    <ul class="pagination">
                        <?php $halaman = (isset($_GET['halaman']) ? $_GET['halaman'] : null); ?>
                        <?php if (isset($_GET['halaman'])) :  ?>
                            <?php if ($_GET['halaman'] != 1 and ($jumlahHalaman > 1)) : ?>
                                <li class="page-item ">
                                    <a class="page-link" href="index.php?<?php if (isset($_GET['kategori'])) {
                                                                                echo "kategori=" . $_GET['kategori'] . "&";
                                                                            } ?>halaman=<?= $_GET['halaman'] - 1; ?>" tabindex="-1">Previous</a>
                                </li>
                            <?php endif; ?>
                        <?php endif ?>

                        <?php for ($i = 0; $i < $jumlahHalaman; $i++) : ?>
                            <?php $noPage = 1 + $i; ?>
                            <li class="page-item <?php
                                                    if (isset($_GET['halaman'])) {
                                                        if ($_GET['halaman'] == $noPage) {
                                                            echo "active";
                                                        }
                                                    }
                                                    ?>
                                                ">
                                <a class="page-link" href="index.php?<?php if (isset($_GET['kategori'])) {
                                                                            echo "kategori=" . $_GET['kategori'] . "&";
                                                                        } ?>halaman=<?= $noPage; ?>"><?= $noPage; ?></a>
                            </li>
                        <?php endfor; ?>
                        <?php if (isset($_GET['halaman'])) : ?>
                            <?php if ($jumlahHalaman != $_GET['halaman'] and ($jumlahHalaman > 1)) : ?>
                                <li class="page-item">
                                    <a class="page-link" href="index.php?<?php if (isset($_GET['kategori'])) {
                                                                                echo "kategori=" . $_GET['kategori'] . "&";
                                                                            } ?>halaman=<?= $_GET['halaman'] + 1; ?>">Next</a>
                                </li>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endif; //pagination 
                    ?>
                    </ul>
            </nav>
        </div>
    </div>

    <script src=" https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/50cc75fb6a.js" crossorigin="anonymous"></script>
</body>

</html>