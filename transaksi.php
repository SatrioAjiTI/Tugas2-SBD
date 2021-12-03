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
$NIK        = "";
$TanggalAmbil             = "";
$TanggalKembali = "";
$IdKasir = "";
$sukses     = "";
$error      = "";


if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}
if($op == 'delete'){
    $NotaNo   = $_GET['NotaNo'];
    $sql1       = "delete from transaksi where NotaNo = '$NotaNo'";
    $q1         = mysqli_query($koneksi,$sql1);
    if($q1){
        $sukses = "Berhasil hapus data";
    }else{
        $error  = "Gagal melakukan delete data";
    }
}
if ($op == 'edit') {
    $NotaNo    = $_GET['NotaNo'];
    $sql1       = "select * from transaksi where NotaNo = '$NotaNo'";
    $q1         = mysqli_query($koneksi, $sql1);
    $r1         = mysqli_fetch_array($q1);
    $NIK = $r1['NIK'];
    $TanggalAmbil       = $r1['TanggalAmbil'];
    $TanggalKembali = $r1['TanggalKembali'];
    $IdKasir       = $r1['IdKasir'];
    

    if ($NotaNo == '') {
        $error = "Data tidak ditemukan";
    }
}
if (isset($_POST['simpan'])) { //untuk create
    $NotaNo   = $_POST['NotaNo'];
    $NIK        = $_POST['NIK'];
    $TanggalAmbil       = $_POST['TanggalAmbil'];
    $TanggalKembali = $_POST['TanggalKembali'];
    $IdKasir        = $_POST['IdKasir'];


    if ($NotaNo && $NIK && $TanggalAmbil && $TanggalKembali && $IdKasir) {
        if ($op == 'edit') { //untuk update
            $sql1       = "update transaksi set NIK = $NIK,TanggalAmbil= $TanggalAmbil, TanggalKembali = $TanggalKembali,IdKasir = $IdKasir  where NotaNo = '$NotaNo'";
            $q1         = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Data berhasil diupdate";
            } else {
                $error  = "Data gagal diupdate";
            }
        } else { //untuk insert
            $sql1   = "insert into transaksi(NotaNo,NIK,TanggalAmbil,TanggalKembali,IdKasir) values ($NotaNo,$NIK, '$TanggalAmbil','$TanggalKembali',$IdKasir)";
            $q1     = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses     = "Berhasil memasukkan data baru";
            } else {
                $error      = "Gagal memasukkan data";
            }
        }
    } else {
        $error = "Silakan masukkan semua data";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabel Tarsakasi</title>
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
                Tabel Transaksi

            </div>
            <div class="card-body">
                <?php
                if ($error) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                <?php
                    header("refresh:5;url=transaksi.php");//5 : detik
                }
                ?>
                <?php
                if ($sukses) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                <?php
                    header("refresh:5;url=transaksi.php");
                }
                ?>
                <form action="" method="POST">
                    <div class="mb-3 row">
                        <label for="NotaNo" class="col-sm-2 col-form-label">No Nota</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="NotaNo" name="NotaNo" value="<?php echo $NotaNo ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="NIK" class="col-sm-2 col-form-label">NIK</label>
                        <div class="col-sm-10">
                            <select name="NIK" id%="NIK" class="form-control" required>
                                <option value="">- Pilih NIK -</option>
                                <?php
                                $sql_NIK = mysqli_query($koneksi, "SELECT NIK FROM pelanggan") or die (mysqli_error($koneksi));
                                while($NIK = mysqli_fetch_array($sql_NIK)) {
                                echo '<option value ="'.$NIK ['NIK']. '" > '.$NIK['NIK']. '</option>';
                                } ?>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="TanggalAmbil" class="col-sm-2 col-form-label">Tanggal Ambil</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" id="TanggalAmbil" name="TanggalAmbil" value="<?php echo $TanggalAmbil ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="TanggalKembali" class="col-sm-2 col-form-label">Tanggal Kembali</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" id="TanggalKembali" name="TanggalKembali" value="<?php echo $TanggalKembali ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="IdKasir" class="col-sm-2 col-form-label">Id Kasir</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="IdKasir" name="IdKasir" value="<?php echo $IdKasir ?>">
                        </div>
                    </div>
                    <div class="col-12">
                        <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary" />
                        <a href="crud.php"><button type="button" class="btn btn-danger" class="float-right">Kembali</button></a>
                    </div>
                </form>
            </div>
        </div>

        <!-- untuk mengeluarkan data -->
        <div class="card">
            <div class="card-header text-white bg-secondary">
                Data Transaksi
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col-12">No Nota</th>
                            <th scope="col-12">NIK</th>
                            <th scope="col-12">Tanggal Ambil</th>
                            <th scope="col-12">Tanggal Kembali</th>
                            <th scope="col-12">Id Kasir</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql2   = "select * from transaksi order by NotaNo desc";
                        $q2     = mysqli_query($koneksi, $sql2);
                        while ($r2 = mysqli_fetch_array($q2)) {
                            $NotaNo         = $r2['NotaNo'];
                            $NIK       = $r2['NIK'];
                            $TanggalAmbil      = $r2['TanggalAmbil'];
                            $TanggalKembali = $r2['TanggalKembali'];
                            $IdKasir = $r2['IdKasir'];

                        ?>
                            <tr>
                                <th scope="row"><?php echo $NotaNo ?></th>
                                <td scope="row"><?php echo $NIK ?></td>
                                <td scope="row"><?php echo $TanggalAmbil ?></td>
                                <td scope="row"><?php echo $TanggalKembali ?></td>
                                <td scope="row"><?php echo $IdKasir ?></td>
                                <td scope="row">
                                    <a href="transaksi.php?op=edit&NotaNo=<?php echo $NotaNo ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                    <a href="transaksi.php?op=delete&NotaNo=<?php echo $NotaNo?>" onclick="return confirm('Yakin mau delete data?')"><button type="button" class="btn btn-danger">Delete</button></a>            
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                    
                </table>
            </div>
        </div>
    </div>
</body>

</html>