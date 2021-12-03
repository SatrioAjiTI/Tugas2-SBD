<?php
$host       = "localhost";
$user       = "root";
$pass       = "";
$db         = "c8";

$koneksi    = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) { //cek koneksi
    die("Tidak bisa terkoneksi ke database");
}
$NotaNo = $_GET['NotaNo'];
$NamaBarang        = "";
$banyak             = "";
$IdBarang             = "";
$jumlah = "";
$sukses     = "";
$error      = "";
$TanggalAmbil = "";
$TanggalKembali = "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}

                        $sql1   = "select TanggalAmbil,TanggalKembali,pelanggan.NamaPelanggan,pelanggan.NIK,pelanggan.Alamat from transaksi inner join pelanggan on transaksi.NIK = pelanggan.NIK where NotaNo = '$NotaNo'";
                        $q1     = mysqli_query($koneksi, $sql1);
                        while ($r1 = mysqli_fetch_array($q1)) {
                            $TanggalAmbil = $r1["TanggalAmbil"];
                            $TanggalKembali = $r1["TanggalKembali"];
                            $NamaPelanggan =    $r1["NamaPelanggan"];
                            $Alamat =    $r1["Alamat"];
                            $NIK =    $r1["NIK"];
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
    <div class="card">
            <div class="card-header text-white bg-secondary">
                Nota Sewa
            </div>
            <div class="card-body">
            <form action="" method="POST">
                <table class="table">
                    <thead>
                    <div >
                            Nota : <?php echo $NotaNo; ?>
                        </div>
                        <div>
                            Tanggal Ambil : (<?php echo $TanggalAmbil; ?>)
                        </div>
                        <div>
                            Tanggal Kembali : (<?php echo $TanggalKembali; ?>)
                        </div>
                        <div>
                            Nama Pembeli : <?php echo $NamaPelanggan; ?>
                        </div>
                        <div>
                            Alamat : <?php echo $Alamat; ?>
                        </div>
                        <div>
                            NIK : <?php echo $NIK; ?>
                        </div>
                        <tr>
                            <th scope="col-12">Banyak Barang</th>
                            <th scope="col-12">Nama Barang</th>
                            <th scope="col-12">Harga Barang</th>
                            <th scope="col-12">Jumlah Pembayaran</th>
                        </tr>
                        <div class="col-12">
                        <a href="crud.php"><button type="button" class="btn btn-danger" class="float-right">Kembali</button></a>
                    </div>   
                    </thead>
                    <tbody>
                        <?php
                        $sql2   = "select barang.IdBarang,barang.NamaBarang,NotaNo,banyak,barang.harga,banyak * barang.harga as jumlah from detail_transaksi inner join barang on detail_transaksi.IdBarang = barang.IdBarang where NotaNo = '$NotaNo'";
                        $q2     = mysqli_query($koneksi, $sql2);
                        while ($r2 = mysqli_fetch_array($q2)) {
                            $NamaBarang       = $r2['NamaBarang'];
                            $banyak     = $r2['banyak'];
                            $harga = $r2['harga'];
                            $jumlah = $r2['jumlah'];
                            $IdBarang = $r2['IdBarang'];
                            $sql3   = "update detail_transaksi set jumlah = '$jumlah' where NotaNo = '$NotaNo' and IdBarang = '$IdBarang'";
                            $q3 = mysqli_query($koneksi, $sql3)

                        ?>
                            <tr >
                                <td scope="col-12"><?php echo $banyak ?></td>
                                <td scope="col-12"><?php echo $NamaBarang ?></td>
                                <td scope="col-12"><?php echo $harga ?></td>
                                <td scope="col-12"><?php echo $jumlah ?></td>
                            </tr>
                        <?php
                        }
                        $sqsum = "select sum(jumlah) as Total from detail_transaksi where NotaNo = '$NotaNo'";
                        $qsum = mysqli_query($koneksi, $sqsum);
                        while ($rsum = mysqli_fetch_array($qsum)) {
                            $total = $rsum['Total'];
                        ?>
                    </tbody>
                    
                </table>
                <div>
                    <h5>Total = Rp <?php echo $total  ?></h5>
                </div>
                <?php } ?>
            </div>
        </div>
                    </div>
</body>