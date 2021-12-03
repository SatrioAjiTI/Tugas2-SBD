<?php
$host       = "localhost";
$user       = "root";
$pass       = "";
$db         = "c8";

$koneksi    = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) { //cek koneksi
    die("Tidak bisa terkoneksi ke database");
}
$NotaNo           ="";
$NamaBarang        = "";
$banyak             = "";
$IdBarang             = "";
$jumlah = "";
$sukses     = "";
$error      = "";


if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}

if (isset($_POST['simpan'])) { //untuk create
    $NotaNo   = $_POST['NotaNo'];
    $IdBarang        = $_POST['IdBarang'];
    $banyak       = $_POST['banyak'];




    if ($NotaNo && $IdBarang && $banyak) {
        //untuk insert
            $sql1   = "insert into detail_transaksi(NotaNo, IdBarang, banyak) Values ($NotaNo,$IdBarang, $banyak)";
            $sqlup = "update detail_transaksi set banyak = banyak + $banyak where NotaNo=$NotaNo and IdBarang = $IdBarang";
            $sqlsel = "select * from detail_transaksi where IdBarang = $IdBarang";
            $kurang = "update barang set Stok = Stok - $banyak where IdBarang = $IdBarang";
            $qsel     = mysqli_query($koneksi, $sqlsel);
            $sel     = mysqli_fetch_array($qsel);
            if (empty($sel)) {
                $q1 = mysqli_query($koneksi,$sql1);
                if($q1) {
                    $sukses     = "Berhasil memasukkan data baru";
                    $q3 = mysqli_query($koneksi,$kurang);
                } else {
                    $error      = "Gagal memasukkan data";
                }
                
            } else {
                $qup = mysqli_query($koneksi,$sqlup);
                $q3 = mysqli_query($koneksi,$kurang);
                $sukses     = "Berhasil menambahkan data";
            }
           
    } else {
        $error = "Silakan masukkan semua data";
    }
}
if (isset($_POST['teruskan'])){
    $NotaNo = $_GET['NotaNo'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabel Detail Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <style>
        .mx-auto {
            width: 800px
        }

        .card {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="mx-auto">
        <!-- untuk memasukkan data -->
        <div class="card">
            <div class="card-header">
                Belanja

            </div>
            <div class="card-body">
                <?php
                if ($error) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                <?php
                    header("refresh:5;url=nota.php");//5 : detik
                }
                ?>
                <?php
                if ($sukses) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                <?php
                    header("refresh:5;url=nota.php");
                }
                ?>
                <form action="" method="POST">
                <div class="mb-3 row">
                  <label for="NotaNo" class="col-sm-2 col-form-label">Nomor Nota</label>
                  <div class="col-sm-10">
                     <select name="NotaNo" id%="NotaNo" class="form-control" required>
                        <option value="">- Pilih Nota Nomor -</option>
                        <?php
                        $sql_NotaNo = mysqli_query($koneksi, "SELECT NotaNo FROM transaksi") or die (mysqli_error($koneksi));
                        while($NotaNo = mysqli_fetch_array($sql_NotaNo)) {
                           echo '<option value ="'.$NotaNo ['NotaNo']. '" > '.$NotaNo['NotaNo']. '</option>';
                        } ?>
                     </select>
                  </div>
                </div>
                <div class="mb-3 row">
                  <label for="IdBarang" class="col-sm-2 col-form-label">Nama Barang</label>
                        <div class="col-sm-10">
                            <select name="IdBarang" id%="IdBarang" class="form-control" required>
                                <option value="">- Pilih Barang -</option>
                                <?php
                                $sql_produk = mysqli_query($koneksi, "SELECT IdBarang ,NamaBarang FROM barang") or die(mysqli_error($koneksi));
                                while ($IdBarang = mysqli_fetch_array($sql_produk)) {
                                    echo '<option value ="' . $IdBarang['IdBarang'] . '" > ' . $IdBarang['IdBarang'] .' - '. $IdBarang['NamaBarang'] . '</option>';
                                } ?>
                            </select>
                        </div>
                  </div>

                    <div class="mb-3 row">
                        <label for="banyak" class="col-sm-2 col-form-label">Banyak Barang</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="banyak" name="banyak" value="<?php echo $banyak ?>">
                        </div>
                    </div>

                    <div class="col-12">
                        <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary" />
                        <a href="pilihnota.php"><button type="button" name="teruskan" class="btn btn-success">Lihat Nota</button></a>
                        <a href="crud.php"><button type="button" class="btn btn-danger">Kembali</button></a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>