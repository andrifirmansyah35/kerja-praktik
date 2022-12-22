<?php
$data = "TIDAK ADA";
if (isset($_GET)) {
    if ($_GET['page'] == "produkdetail" and isset($_GET['id'])) {
        if (!getByIDProduk($_GET['id'])) {
            echo "
            <script>
            alert('Data Produk Tidak Ada');
            document.location.href='index.php?page=produk';
            </script>
            ";
        } else {
            $produk = getByIDProduk($_GET['id']);
            // var_dump($produk);
            $data = "DATA ADA";
        }
    }
}
?>
<?php if ($data == "DATA ADA") { ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Detail Produk : <?= $produk['nama']; ?></h1>
                    </div>
                </div>
                <div class="row">
                    <a href="index.php?page=produk" class="ml-2 text-info"><i class="fas fa-arrow-left mr-1"></i><strong>daftar produk</strong></a>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="card card-solid">
                <!-- Default box -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <div class="col-12">
                                <img src="gambar/<?= $produk['gambar']; ?>" class="product-image" alt="Product Image">
                            </div>

                        </div>
                        <div class="col-12 col-sm-6">

                            <h5 class="my-3"><strong>Harga Beli</strong></h5>
                            <input class="form-control" type="text" value="Rp.<?= number_format($produk['harga_beli']); ?>" readonly>

                            <h5 class="my-3"><strong>Harga Jual</strong></h5>
                            <input class="form-control" type="text" value="Rp.<?= number_format($produk['harga']); ?>" readonly>

                            <h5 class="my-3"><strong>Profit</strong></h5>
                            <input class="form-control" type="text" value="Rp.<?= number_format($produk['profit']); ?>" readonly>

                            <h5 class="my-3"><strong>Stock</strong></h5>
                            <input class="form-control" type="text" value="<?= $produk['stok']; ?> pcs" readonly>

                            <h5 class="my-3"><strong>Berat</strong></h5>
                            <input class="form-control" type="text" value="<?= $produk['berat']; ?> gram" readonly>

                            <h5 class="my-3"><strong>Deskripsi</strong></h5>
                            <textarea class="form-control" readonly><?= $produk['deskripsi']; ?></textarea>
                        </div>
                    </div>
                </div><!-- /.card-body -->
            </div><!-- /.card -->
        </section> <!-- /.content -->
    </div><!-- /.content-wrapper -->
<?php } else { ?>
    <h1>XXXXXXXXXXXXXXXXXXX Data Tidak Ditemukan</h1>
<?php } ?>