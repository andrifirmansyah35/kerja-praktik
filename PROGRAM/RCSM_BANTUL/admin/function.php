<?php
$conn = mysqli_connect("localhost", "root", "", "rcsm");

function query($query)
{
    global $conn;
    mysqli_query($conn, $query);
}

function query_result($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_assoc($result);
}

function query_result_array($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function kategori($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}
function kategori_tambah($data)
{
    global $conn;
    $kategori = htmlspecialchars($data['kategori']);
    $query = "INSERT INTO kategori (nama) VALUES ('$kategori')";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function kategori_hapus($data)
{
    global $conn;
    $id = htmlspecialchars($data['id']);
    $query = "DELETE FROM kategori WHERE id =$id";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function getByIDkategori($id)
{
    global $conn;
    $query = "SELECT * FROM kategori WHERE id = $id";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result);
    } else {
        return false;
    }
}

function kategori_ubah($data)
{
    global $conn;
    $id = $data['id'];
    $nama = $data['nama'];
    $query = "UPDATE kategori SET nama = '$nama' 
    WHERE id = $id";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function produk()
{
    global $conn;
    $query = "SELECT * FROM produk";
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}


function produkPage($dataAwal, $batasData)
{
    global $conn;
    $query = "SELECT * FROM produk WHERE stok > 0 LIMIT $dataAwal,$batasData";
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function produkByKategori($id_kategori)
{
    global $conn;
    $query = "SELECT * FROM produk WHERE id_kategori = $id_kategori";
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}


function produkPageByIDKategori($id_kategori, $dataAwal, $batasData)
{
    global $conn;
    $query = "SELECT * FROM produk WHERE id_kategori = $id_kategori LIMIT $dataAwal,$batasData ";
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function  produk_tambah($data)
{
    global $conn;
    $nama = htmlspecialchars($data["nama"]);
    $kategori = $data["kategori"];
    $harga_beli = $data["harga_beli"];
    $harga = $data["harga"];
    $deskripsi = htmlspecialchars($data["deskripsi"]);
    $stok = $data["stok"];
    $berat = $data["berat"];
    $gambar = upload();

    $profit = $harga - $harga_beli;

    if (!$gambar) {
        return false;
    }
    $query = "INSERT INTO produk (id_kategori,nama,harga_beli,harga,profit,gambar,stok,deskripsi,berat) 
        VALUES 
        ($kategori,'$nama',$harga_beli,$harga,$profit,'$gambar',$stok,'$deskripsi',$berat);
                ";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function upload()
{
    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    if ($error === 4) {
        echo "
        <script> 
            alert ('Pilih Gambar terlebih Dahulu');
        </script>
        ";
        return false;
    }
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));

    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo "
            <script>
                alert ('Yang anda Upload Bukan gambar');
            </script>
        ";
        return false;
    }

    if ($ukuranFile > 5000000) {
        echo " 
    <script>
        alert ('Gambar terlalu besar');
    </script>
";
        return false;
    }
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar;

    move_uploaded_file($tmpName, 'gambar/' . $namaFileBaru);
    // echo "<h1>";
    // echo "Nama Foto Baru" . $namaFileBaru;
    // echo "<h1>";
    return $namaFileBaru;
}

function produk_stok_tambah($data)
{
    $id_produk = $data['id_produk'];
    $harga_jual_lama = $data['harga_jual_lama'];
    $harga_beli_lama = $data['harga_beli_lama'];

    $stok_lama = $data['stock_lama'];
    $stok_tambah = $data['stock_tambah'];

    $beli_stock_tambah = $data['harga_beli_stock_tambah'];
    $jual_stock_tambah = $data['harga_jual_stock_tambah'];

    if ($jual_stock_tambah < $beli_stock_tambah) {
        echo "<script>
            alert('harga pembelian tidak boleh lebih dari harga penjualan');
        </script>";
    } else if ($jual_stock_tambah > $beli_stock_tambah) {
        if ($stok_lama > 0) {
            $jumlah_seluruh_barang = $stok_lama + $stok_tambah;
            // 1. harga beli baru
            $jumlah_harga_beli_lama = $stok_lama * $harga_beli_lama;
            $jumlah_harga_beli_baru = $stok_tambah * $beli_stock_tambah;
            $harga_beli_baru = round(($jumlah_harga_beli_lama + $jumlah_harga_beli_baru) / $jumlah_seluruh_barang);

            $jumlah_harga_jual_lama = $stok_lama * $harga_jual_lama;
            $jumlah_harga_jual_baru = $stok_tambah * $jual_stock_tambah;
            $harga_jual_baru = round((($jumlah_harga_jual_lama + $jumlah_harga_jual_baru) / $jumlah_seluruh_barang) / 1000) * 1000;
            // 2. harga_jual_baru
            $profit_baru = $harga_jual_baru - $harga_beli_baru;

            query("UPDATE produk SET stok = $jumlah_seluruh_barang, 
                                harga_beli = $harga_beli_baru,
                                harga = $harga_jual_baru,
                                profit = $profit_baru
                            WHERE id = $id_produk");
        } else {
            $profit_baru = $jual_stock_tambah - $beli_stock_tambah;
            query("UPDATE produk SET stok = $stok_tambah, 
                                harga_beli = $beli_stock_tambah,
                                harga = $jual_stock_tambah,
                                profit = $profit_baru
                            WHERE id = $id_produk");
        }
    }
}

function produk_ubah($data)
{
    // echo "<>"
    global $conn;
    $id_produk = $data['id_produk'];
    $nama = htmlspecialchars($data["nama"]);
    $id_kategori = $data["kategori"];
    // $harga = $data["harga"];
    $deskripsi = htmlspecialchars($data["deskripsi"]);
    // $stok = $data["stok"];
    $berat = $data["berat"];
    $gambarLama =  $data["gambar_lama"];

    // cek harga jual dan beli
    // $harga_beli_produk =  query_result("SELECT harga_beli FROM produk WHERE id = $id_produk")['harga_beli'];

    if ($_FILES['gambar']['error'] === 4) {
        $gambar = $gambarLama;
    } else {
        $gambar = upload();
        if ($gambar == false) {
            return false;
        }
        unlink("./gambar/" . $gambarLama);
    }

    // $harga_beli = query_result("SELECT harga_beli FROM produk WHERE id = $id_produk")['harga_beli'];
    // $profit = $harga - $harga_beli;

    $query = "UPDATE produk SET nama = '$nama',
                                id_kategori = $id_kategori,
                                gambar = '$gambar',
                                deskripsi = '$deskripsi',
                                berat = $berat
                            WHERE id = $id_produk";
    query($query);
    return true;
}

function getByIDProduk($id)
{
    global $conn;
    $query = "SELECT * FROM produk WHERE id = $id";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result);
    } else {
        return false;
    }
}

function produk_kategori()
{
    global $conn;
    $query = "SELECT nama FROM kategori";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_assoc($result['nama']);
}

function produk_hapus($data)
{
    global $conn;
    $id = $data['id'];
    $gambar = $data['gambar'];

    if (file_exists("gambar/$gambar")) {
        unlink("gambar/$gambar");
    }

    $query = "DELETE FROM produk WHERE id = $id";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function produk_cari($keyword)
{
    global $conn;
    $query = "SELECT * FROM produk
                WHERE
                nama LIKE '%$keyword%'               
                ";
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($mhs = mysqli_fetch_assoc($result)) {
        $rows[] = $mhs;
    }
    return $rows;
}

function  produk_update_tambah_pembelian($id_produk, $jumlah_barang)
{
    global $conn;

    $dataProduk = produkByID($id_produk);
    $jumlahProdukLama = $dataProduk['stok'];
    $jumlahProdukBaru = $jumlahProdukLama - $jumlah_barang;

    $query = "UPDATE produk SET stok = $jumlahProdukBaru WHERE id = $id_produk";
    mysqli_query($conn, $query);
}

function provinsi($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}
function provinsi_tambah($data)
{
    global $conn;
    $provinsi = htmlspecialchars($data['nama']);
    $query = "INSERT INTO provinsi (nama) VALUES ('$provinsi')";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}
function provinsi_nonaktif($data)
{
    global $conn;
    $id = $data['id'];
    $query = "UPDATE provinsi SET status='non-aktif' WHERE id=$id";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}
function provinsi_aktif($data)
{
    global $conn;
    $id = $data['id'];
    $query = "UPDATE provinsi SET status='aktif' WHERE id=$id";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}
function provinsi_hapus($data)
{
    global $conn;
    $id = htmlspecialchars($data['id']);
    $query = "DELETE FROM provinsi WHERE id = $id";
    $query2 = "DELETE FROM ongkir WHERE id_provinsi = $id";
    mysqli_query($conn, $query);
    mysqli_query($conn, $query2);
    return mysqli_affected_rows($conn);
}

function getByIDProvinsi($id)
{
    global $conn;
    $query = "SELECT * FROM provinsi WHERE id = $id";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result);
    } else {
        return false;
    }
}

function provinsi_ubah($data)
{
    global $conn;
    $id = $data['id'];
    $nama = $data['nama'];
    $query = "UPDATE provinsi SET nama = '$nama' 
    WHERE id = $id";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}
function provinsi_detail($id)
{
    global $conn;
    $query = "SELECT * FROM ongkir WHERE id_provinsi = $id";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) < 1) {
        return false;
    } else {
        $rows = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        return $rows;
    }
}

function ongkir_tambah($data)
{
    global $conn;
    $id_provinsi = $data['id_provinsi'];
    $kota = htmlspecialchars($data['nama']);
    $harga = $data['harga'];
    $query = "INSERT INTO ongkir (id_provinsi,kota,harga) VALUES ($id_provinsi,'$kota',$harga)";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function getByIDOngkir($data)
{
    global $conn;
    $id_provinsi = $data['id_provinsi'];
    $id_ongkir = $data['id'];
    $query = "SELECT * FROM ongkir WHERE id_provinsi = $id_provinsi AND id = $id_ongkir";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result);
    } else {
        return false;
    }
}

function ongkir_ubah($data)
{
    global $conn;
    $id_ongkir = $data['id_ongkir'];
    $kota = $data['kota'];
    $harga = $data['harga'];

    $query = "UPDATE ongkir SET 
            kota = '$kota',
            harga = $harga 
            WHERE id = $id_ongkir";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function ongkir_pelangan()
{
    global $conn;
    $query = "SELECT ongkir.id,ongkir.kota,ongkir.harga,provinsi.nama AS provinsi FROM ongkir LEFT JOIN provinsi ON ongkir.id_provinsi = provinsi.id";
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function pelangan()
{
    global $conn;
    $query = "SELECT * FROM pelangan";
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function pelanganByEmail($email)
{
    global $conn;
    $query = "SELECT * FROM pelangan where email = '$email'";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);
    return $data;
}


// adminend

function registrasi($data)                                                          // registrasi Admin
{
    global $conn;
    $nama = strtolower(stripslashes($data["nama"]));
    $username = mysqli_escape_string($conn, $data["username"]);
    $password = mysqli_escape_string($conn, $data["password"]);
    $password = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO admin VALUES ('','$username','$password','$nama')";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function admin_login()
{
    return true;
}

// register pelangan tidak digunakan
function register_pelangan($data)
{
    global $conn;
    // echo "<h1>Data Dari Function :</h1>";
    // var_dump($data);
    $nama = htmlspecialchars($data['nama']);
    $email = htmlspecialchars($data['email']);
    $telp = $data['telp'];
    $password = password_hash($data['psw'], PASSWORD_DEFAULT);
    //seleksi Data
    $query_cari_email = "SELECT * FROM pelangan WHERE email = '$email'";
    $result_email = mysqli_query($conn, $query_cari_email);

    $cek_data_email = "kosong";
    if (mysqli_num_rows($result_email) > 0) {
        $cek_data_email = "ada";
        return "Email Sudah Terdaftar";
    }

    $query_cari_telp = "SELECT * FROM pelangan WHERE telp = '$telp'";
    $result_telp = mysqli_query($conn, $query_cari_telp);

    $cek_data_telp = "kosong";
    if (mysqli_num_rows($result_telp) > 0) {
        $cek_data_telp = "ada";
        return "Data Telp Sudah Terdaftar";
    }

    if ($cek_data_telp == "kosong" and $cek_data_email == "kosong") {
        $query_daftar = "INSERT INTO pelangan (nama,telp,email,paswd) 
                        VALUES 
                        ('$nama','$telp','$email','$password')";
        mysqli_query($conn, $query_daftar);
        return "Data Terdaftar";
    }
}

function login_pelangan($data)
{
    global $conn;
    $email = $data['email'];
    $password = $data['pswd'];
    $query = "SELECT * FROM pelangan WHERE email = '$email'";

    $result_akun = mysqli_query($conn, $query);
    if (mysqli_num_rows($result_akun) == 1) {
        $row = mysqli_fetch_assoc($result_akun);
        if (password_verify($password, $row["paswd"])) {
            return "login berhasil";
        } else {
            return "password salah";
        }
    }
    return "email tidak terdaftar";
}

function keranjang($id_pelangan)
{
    global $conn;

    $query = "SELECT * FROM pelangan 
    JOIN keranjang ON pelangan.id_pelangan = keranjang.id_pelangan 
    JOIN produk ON keranjang.id_produk = produk.id
    WHERE pelangan.id_pelangan =" . $id_pelangan;
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $rows = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        return $rows;
    } else {
        return false;
    }
}

function keranjang_hapus($id_pelangan, $id_produk)
{
    global $conn;
    $query = "DELETE FROM keranjang WHERE id_pelangan = " . $id_pelangan . " AND id_produk = " . $id_produk . "";
    mysqli_query($conn, $query);
}

function barang_keranjang_pelangan($id_pelangan, $id_produk)
{
    global $conn;
    global $conn;
    $query = "SELECT * FROM keranjang WHERE id_pelangan = $id_pelangan AND id_produk = $id_produk";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);
    return $data;
}

function keranjang_tambah($id_pelangan, $id_produk, $jumlah)
{
    global $conn;

    $query = "SELECT * FROM keranjang WHERE id_pelangan= $id_pelangan AND id_produk= $id_produk";
    $hasil_cek_keranjang = mysqli_query($conn, $query);

    if (mysqli_num_rows($hasil_cek_keranjang) > 0) {
        $data_produk = getByIDProduk($id_produk);
        $harga_produk = $data_produk['harga'];

        $data_produk_keranjang = barang_keranjang_pelangan($id_pelangan, $id_produk);
        $jumlah += $data_produk_keranjang['jumlah_barang'];
        $total_harga = $jumlah * $harga_produk;

        $query_update_keranjang_pelangan = "UPDATE keranjang 
                                            SET jumlah_barang = $jumlah, total_harga = $total_harga 
                                            WHERE id_pelangan = $id_pelangan AND id_produk = $id_produk";

        mysqli_query($conn, $query_update_keranjang_pelangan);
    } else {
        $data_produk = getByIDProduk($id_produk);
        $harga_produk = $data_produk['harga'];
        $totalHarga = $jumlah * $harga_produk;

        $query_insert_keranjang = "INSERT INTO keranjang (id_pelangan,id_produk,jumlah_barang,total_harga,status_barang)
		                                        VALUE ($id_pelangan, $id_produk, $jumlah,$totalHarga,'tersedia');";
        mysqli_query($conn, $query_insert_keranjang);
    }
}

function keranjangCekByID($id_keranjang)
{
    global $conn;
    $query_cek_keranjang = "SELECT * FROM keranjang WHERE id = $id_keranjang";
    $cek_keranjang = mysqli_query($conn, $query_cek_keranjang);
    return mysqli_num_rows($cek_keranjang);
}

function keranjangGetByID($id_keranjang)
{
    global $conn;
    $query_keranjang = "SELECT * FROM keranjang WHERE id_keranjang = $id_keranjang";
    $data_keranjang = mysqli_query($conn, $query_keranjang);
    return mysqli_fetch_assoc($data_keranjang);
}

function keranjang_update($id_keranjang, $jumlah_barang, $harga)
{
    global $conn;
    $total_harga = $jumlah_barang * $harga;
    $query = "UPDATE keranjang SET jumlah_barang = $jumlah_barang, total_harga = $total_harga WHERE id_keranjang = $id_keranjang";
    mysqli_query($conn, $query);
}

function produkByID($id)
{
    global $conn;
    $query = "SELECT * FROM produk WHERE id = $id";
    $result = mysqli_query($conn, $query);

    return mysqli_fetch_assoc($result);
}

// Function cekout -------------------------------------------------------------------

function produk_stock_keranjang_cek($id_produk, $jumlah_barang_keranjang)
{
    $stock_produk  = produkByID($id_produk)['stok'];

    if ($stock_produk < $jumlah_barang_keranjang) {
        return "stok produk tidak cukup";
    } else {
        return "stok produk tersedia";
    }
}

function keranjang_over_stock($id_pelangan, $id_produk)
{
    global $conn;
    $query = "UPDATE keranjang SET status_barang = 'stok tidak tersedia' WHERE id_pelangan=$id_pelangan AND id_produk = $id_produk";
    mysqli_query($conn, $query);
}

function keranjang_cek_status_barang_tidaktersedia()
{
    global $conn;
    $query = "SELECT * FROM keranjang WHERE status_barang = 'stok tidak tersedia'";
    $result = mysqli_query($conn, $query);
    return mysqli_num_rows($result);
}

function cekout_cekStockKeranjang($id_pelangan)
{
    $keranjang_pelangan = keranjang($id_pelangan);
    //cek stock sekaligus mengubah status keranjang 
    foreach ($keranjang_pelangan as $kp) {
        // id = id_produk
        if (produk_stock_keranjang_cek($kp['id_produk'], $kp['jumlah_barang']) == "stok produk tidak cukup") {
            keranjang_over_stock($id_pelangan, $kp['id_produk']);
        }
    }
    //cek adakah keranjang dengan status_barang  
    if (keranjang_cek_status_barang_tidakTersedia($id_pelangan) > 0) {
        return "ada barang keranjang tidak tersedia";
    }
    return "barang tersedia";
}


// Pembelian ---------------------------------------------------------

function pembelian_simpan($id_pelangan, $id_ongkir, $biaya_kirim, $alamat_pengiriman, $berat, $total_pembayaran, $ekspedisi, $ekspedisi_kota, $ekspedisi_paket)
{
    global $conn;
    date_default_timezone_set('Asia/Jakarta');
    $tgl_pembelian = date('Y-m-d');
    $batas_pembayaran = date('Y-m-d', strtotime($tgl_pembelian . ' +1 day'));

    $query = "INSERT INTO pembelian ( id_pelangan, ekspedisi,ekspedisi_kota,ekspedisi_paket,berat,biaya_pengiriman,total_pembayaran,alamat_pengiriman,batas_pembayaran,status_pembelian)
                            VALUES ($id_pelangan,'$ekspedisi','$ekspedisi_kota','$ekspedisi_paket',$berat,$biaya_kirim,$total_pembayaran,'$alamat_pengiriman','$batas_pembayaran','belum bayar')";
    mysqli_query($conn, $query);
    // echo (mysqli_error($conn));

    // 2. Mendapatkan id pembelian 
    $id_pembelian_pelangan = pembelian_id_baru($id_pelangan)['id_pembelian'];
    // echo ('Id pelangan Baru : ' . $id_pembelian_pelangan);

    // 3. memindahkan data keranjang ke detail pembelian
    pembelian_detailpembelian_tambah($id_pelangan, $id_pembelian_pelangan);

    // 4. Update stock produk : mengurari jumlah stock produk
    pembelian_tambah_produkUpdate($id_pelangan);

    // 5. menghapus data keranjang pelangan
    // keranjang_pelangan_hapus($id_pelangan);
    query("DELETE FROM keranjang WHERE id_pelangan = $id_pelangan");

    // 6.mengupdate keuntungan  transaksi 
}

function pembelian_id_baru($id_pelangan)
{
    global $conn;
    $query = "SELECT * FROM pembelian WHERE id_pelangan= $id_pelangan ORDER BY id_pembelian DESC";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_assoc($result);
}

function pembelian_detailpembelian_tambah($id_pelangan, $id_pembelian_pelangan)
{
    global $conn;
    $keranjang_pelangan = keranjang($id_pelangan);

    // memindahkan ke detail pembelian
    foreach ($keranjang_pelangan as $barang) {
        pembelian_keranjangKeDetailPembelian($id_pelangan, $id_pembelian_pelangan, $barang['id'], $barang['harga'], $barang['jumlah_barang'], $barang['total_harga']);
    }
}

function pembelian_keranjangKeDetailPembelian($id_pelangan, $id_pembelian, $id_produk, $harga_produk, $jumlah_barang, $total_harga)
{
    $keuntunganPerproduk = query_result("SELECT profit FROM produk WHERE id = $id_produk")['profit'];
    $keuntunganProduk = $keuntunganPerproduk * $jumlah_barang;

    query("INSERT INTO pembelian_detail (id_pelangan,id_pembelian,id_produk,harga,jumlah_barang,total_harga,keuntungan_perproduk)
                                VALUES ($id_pelangan,$id_pembelian,$id_produk,$harga_produk,$jumlah_barang,$total_harga,$keuntunganProduk)");
}


function pembelian_tambah_produkUpdate($id_pelangan)
{
    $keranjang_pelangan = keranjang($id_pelangan);
    foreach ($keranjang_pelangan as $barang) {
        produk_update_tambah_pembelian($barang['id'], $barang['jumlah_barang']);
    }
}

// Detail Pembelian pelangan 
function pembelian_pelangan_info($id_pelangan, $id_pembelian)
{
    global $conn;
    // $query = "SELECT * FROM pembelian WHERE id_pelangan = $id_pelangan AND id_pembelian = $id_pembelian";
    $query = "SELECT * FROM pembelian INNER JOIN pelangan ON pembelian.id_pelangan = pelangan.id_pelangan 
                WHERE pembelian.id_pelangan = $id_pelangan AND pembelian.id_pembelian = $id_pembelian";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_assoc($result);
}

function pembelian_ongkir($id_ongkir)
{
    global $conn;
    $query = "SELECT provinsi.nama AS provinsi,ongkir.kota AS kota,ongkir.harga AS harga FROM provinsi INNER JOIN ongkir ON provinsi.id = ongkir.id_provinsi WHERE ongkir.id = $id_ongkir";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_assoc($result);
}

function pembelian_detailProduk($id_pelangan, $id_pembelian)
{
    global $conn;
    $query = "SELECT    produk.id AS id_produk,
                        produk.gambar,
                        produk.nama,
                        pembelian_detail.jumlah_barang,
                        pembelian_detail.total_harga 
                FROM pelangan 
                JOIN pembelian_detail ON pelangan.id_pelangan = pembelian_detail.id_pelangan 
                JOIN produk ON pembelian_detail.id_produk = produk.id
                    WHERE pelangan.id_pelangan = $id_pelangan 
                        AND pembelian_detail.id_pembelian = $id_pembelian";
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}



// daftar Pemesanan
function pembelian_daftar_pelangan($id_pelangan)
{
    global $conn;
    $query = "SELECT * FROM pembelian WHERE id_pelangan = $id_pelangan AND NOT status_pembelian = 'selesai' ORDER BY id_pembelian DESC";
    $result = mysqli_query($conn, $query);
    $datas = [];
    while ($data = mysqli_fetch_assoc($result)) {
        $datas[] = $data;
    }
    return $datas;
}

// Pesanan Batal -----------------------------
function pesanan_batal($id_pelangan, $id_pembelian)
{
    $data_produk = pembelian_detailProduk($id_pelangan, $id_pembelian);

    foreach ($data_produk as $produk) {
        // update produk
        $id_produk = $produk['id_produk'];
        $produk_dipesan = $produk['jumlah_barang'];

        $produk_stock = query_result("SELECT stok FROM produk WHERE id = $id_produk")['stok'];
        $penambahan_produk = $produk_dipesan + $produk_stock;
        query("UPDATE produk SET stok = $penambahan_produk WHERE id = $id_produk");
    }
}

// cek apakah daftar pemesanan yg melewati batas pembayaran yang ditentukan
function pembelian_cek_lambatPembayaran($data_pembelian_pelangan, $id_pelangan)
{
    date_default_timezone_set('Asia/Jakarta');
    $hari_ini = strtotime(date('Y-m-d'));

    foreach ($data_pembelian_pelangan as $data_pembelian) {
        $hari_terakhir_pembayaran = strtotime(date("Y-m-d", strtotime($data_pembelian['batas_pembayaran'])));
        if ($hari_terakhir_pembayaran < $hari_ini && $data_pembelian['status_pembelian'] == "belum bayar") {
            // 1. detail pembelian pelangan
            $id_pembelian = $data_pembelian['id_pembelian'];
            $detail_pembelian = pembelian_detailProduk($id_pelangan, $id_pembelian);
            foreach ($detail_pembelian as $produk) {
                $id_produk_pesanan = $produk['id_produk'];
                $jumlah_produk_pesanan = $produk['jumlah_barang'];

                $produk_stock = query_result("SELECT stok FROM produk WHERE id = $id_produk_pesanan")['stok'];
                $penambahan_produk = $jumlah_produk_pesanan + $produk_stock;
                query("UPDATE produk SET stok = $penambahan_produk WHERE id = $id_produk_pesanan");
            }

            $id_pembelian = $data_pembelian['id_pembelian'];
            query("UPDATE pembelian SET status_pembelian = 'pemesanan melewati waktu' WHERE id_pembelian = $id_pembelian");
            // pembelian detail baru update
        }
    }
}

// global $conn;
// $email = $data['email'];
// $password = $data['pswd'];
// $query = "SELECT * FROM pelangan WHERE email = '$email'";

// $result_akun = mysqli_query($conn, $query);
// if (mysqli_num_rows($result_akun) == 1) {
//     $row = mysqli_fetch_assoc($result_akun);
//     if (password_verify($password, $row["paswd"])) {
//         return "login berhasil";
//     } else {
//         return "password salah";
//     }
// }
// return "email tidak terdaftar";
// ubah Password -------------------------
function cek_password_pelangan($password, $id_pelangan)
{
    global $conn;
    $password_pelangan = query_result("SELECT * FROM pelangan WHERE id_pelangan = $id_pelangan")['paswd'];
    if (password_verify($password, $password_pelangan)) {
        return true;
    } else {
        return false;
    }
}

function ubah_password_pelangan($passwordbaru, $id_pelangan)
{
    $password = password_hash($passwordbaru, PASSWORD_DEFAULT);
    query("UPDATE pelangan SET paswd = '$password' WHERE id_pelangan = $id_pelangan");
}


// Transaksi Pembayaran
function transaksi_pembayaran($data)
{
    $id_pembelian = $data['id_pembelian'];
    $id_pelangan = $data['id_pelangan'];
    $gambar_konfirmasi_pembayaran = upload_pembayaran();

    if ($gambar_konfirmasi_pembayaran) {
        date_default_timezone_set('Asia/Jakarta');
        $tgl_pembayaran = date('Y-m-d');
        $bulan_pembayaran = date('m');
        $tahun_pembayaran = date('Y');

        query("UPDATE pembelian SET bukti_pembayaran = '$gambar_konfirmasi_pembayaran', 
                                    tanggal_pembayaran = '$tgl_pembayaran',
                                    bulan_pembayaran = '$bulan_pembayaran',
                                    tahun_pembayaran = '$tahun_pembayaran',
                                    status_pembelian = 'menungu konfirmasi'
                                WHERE id_pembelian = $id_pembelian 
                                        AND 
                                    id_pelangan = $id_pelangan
            ");
        return true;
        // End if 
    } else if (!$gambar_konfirmasi_pembayaran) {
        return false;
    }
}

function upload_pembayaran()
{
    // echo "<h1>";
    // // var_dump($_FILES);
    // echo "<h1>";
    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    if ($error === 4) {
        echo "
        <script> 
            alert ('Pilih Gambar terlebih Dahulu');
        </scri>
        ";
        return false;
    }
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));

    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo "
            <script>
                alert ('Yang anda Upload Bukan gambar');
            </script>
        ";
        return false;
    }

    if ($ukuranFile > 5000000) {
        echo " 
    <script>
        alert ('Gambar terlalu besar');
    </script>
";
        return false;
    }
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar;

    move_uploaded_file($tmpName, 'admin/gambar_transaksi/' . $namaFileBaru);
    // echo "<h1>";
    // echo "Nama Foto Baru" . $namaFileBaru;
    // echo "<h1>";
    return $namaFileBaru;
}


// pssanan batal 
function pesanan_dibatalkan($id_pembelian)
{
    $data_produk = query_result_array("SELECT * FROM pembelian_detail WHERE id_pembelian = $id_pembelian");

    foreach ($data_produk as $produk) {
        // update produk
        $id_produk = $produk['id_produk'];
        $produk_dipesan = $produk['jumlah_barang'];

        $produk_stock = query_result("SELECT stok FROM produk WHERE id = $id_produk")['stok'];
        $penambahan_produk = $produk_dipesan + $produk_stock;
        query("UPDATE produk SET stok = $penambahan_produk WHERE id = $id_produk");
    }

    query("UPDATE pembelian SET status_pembelian ='pemesanan gagal' WHERE id_pembelian = $id_pembelian");
}

// function get_bulan($angka_bulan){
//     if($angka_bulan)
// }

function produk_terjual($bulan, $tahun)
{
    return query_result_array("SELECT produk.nama,SUM(pembelian_detail.jumlah_barang) AS jumlah_terjual
    FROM pembelian_detail 
    LEFT JOIN produk ON pembelian_detail.id_produk = produk.id 
    LEFT JOIN pembelian ON pembelian_detail.id_pembelian = pembelian.id_pembelian
    WHERE pembelian.status_pembelian = 'selesai' AND
    bulan_pembayaran = '$bulan' AND tahun_pembayaran = '$tahun' 
    GROUP BY produk.nama
    ORDER BY jumlah_terjual DESC");
}

function profit_penjualan($bulan, $tahun)
{
    return query_result("SELECT SUM(pembelian_detail.keuntungan_perproduk) AS profit_bulanan FROM pembelian_detail 
    LEFT JOIN produk ON pembelian_detail.id_produk = produk.id 
    LEFT JOIN pembelian ON pembelian_detail.id_pembelian = pembelian.id_pembelian
    WHERE pembelian.status_pembelian = 'selesai' AND
    bulan_pembayaran = '$bulan' AND tahun_pembayaran = '$tahun'");
}

function user_nama($kalimat)
{
    if (strlen($kalimat) > 21) {
        return substr($kalimat, 0, 21) . "..";
    } else {
        return $kalimat;
    }
}
