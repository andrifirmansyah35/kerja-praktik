<?php
$kategori = kategori("SELECT * FROM kategori");
error_reporting(0);

if (isset($_POST['kategori'])) {
    if (kategori_tambah($_POST) > 0) {
        echo "  <script>
                document.location.href = 'index.php?page=kategori';
                swal('Berhasil', 'Data berhasil Ditambahkan', 'success');
                </script>
            ";
    } else {
        echo "
                <script>
                swal('Gagal!, 'Data Gagal Ditambakan', 'error');
                </script>
            ";
    }
}
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1>Kategori produk</h1>
                </div>
            </div>
            <div class="row">
                <div class="card-body">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default">
                        Tambah Kategori
                    </button>
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
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $nmr = 1; ?>
                                            <?php foreach ($kategori as $k) : ?>
                                                <tr>
                                                    <td><?= $nmr; ?></td>
                                                    <td><?= $k['nama']; ?></td>
                                                    <td>
                                                        <a href="index.php?page=kategoriubah&id=<?= $k['id']; ?>" class="badge badge-warning">ubah</a>
                                                        <a href="index.php?page=kategorihapus&id=<?= $k['id']; ?>" class="badge badge-danger" onclick=" return confirm('yakin');">hapus</a>
                                                    </td>
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

<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Kategori</h4>
                <button type="button btn-primary" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <div class="card-body">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Masukkan data Kategori" name="kategori" required oninvalid="this.setCustomValidity('')" oninput="this.setCustomValidity('')">
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
</div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var elements = document.getElementsByTagName("INPUT");
        for (var i = 0; i < elements.length; i++) {
            elements[i].oninvalid = function(e) {
                e.target.setCustomValidity("");
                if (!e.target.validity.valid) {
                    e.target.setCustomValidity("Data Raoleh Kotong");
                }
            };
            elements[i].oninput = function(e) {
                e.target.setCustomValidity("");
            };
        }
    })
</script>