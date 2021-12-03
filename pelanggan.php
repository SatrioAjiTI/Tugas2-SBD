<?php
$host       = "localhost";
$user       = "root";
$pass       = "";
$db         = "c8";

$koneksi    = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) { //cek koneksi
    die("Tidak bisa terkoneksi ke database");
}
$NIK           ="";
$NamaPelanggan = "";
$Alamat = "";
$sukses     = "";
$error      = "";


if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}
if($op == 'delete'){
    $NIK   = $_GET['NIK'];
    $sql1       = "delete from pelanggan where NIK = '$NIK'";
    $q1         = mysqli_query($koneksi,$sql1);
    if($q1){
        $sukses = "Berhasil hapus data";
    }else{
        $error  = "Gagal melakukan delete data";
    }
}
if ($op == 'edit') {
    $NIK    = $_GET['NIK'];
    $sql1       = "select * from pelanggan where NIK = '$NIK'";
    $q1         = mysqli_query($koneksi, $sql1);
    $r1         = mysqli_fetch_array($q1);
    $NamaPelanggan = $r1['NamaPelanggan'];
    $Alamat       = $r1['Alamat'];
    

    if ($NIK == '') {
        $error = "Data tidak ditemukan";
    }
}
if (isset($_POST['simpan'])) { //untuk create
    $NIK   = $_POST['NIK'];
    $NamaPelanggan        = $_POST['NamaPelanggan'];
    $Alamat       = $_POST['Alamat'];


    if ($NIK && $NamaPelanggan && $Alamat) {
        if ($op == 'edit') { //untuk update
            $sql1       = "update pelanggan set NamaPelanggan = '$NamaPelanggan',Alamat= $Alamat  where NIK = '$NIK'";
            $q1         = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Data berhasil diupdate";
            } else {
                $error  = "Data gagal diupdate";
            }
        } else { //untuk insert
            $sql1   = "insert into pelanggan(NIK,NamaPelanggan,Alamat) values ($NIK,'$NamaPelanggan', '$Alamat')";
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
    <title>Tabel Pelanggan</title>
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
                Tabel Pelanggan

            </div>
            <div class="card-body">
                <?php
                if ($error) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                <?php
                    header("refresh:5;url=pelanggan.php");//5 : detik
                }
                ?>
                <?php
                if ($sukses) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                <?php
                    header("refresh:5;url=pelanggan.php");
                }
                ?>
                <form action="" method="POST">
                <div class="mb-3 row">
                        <label for="NIK" class="col-sm-2 col-form-label">NIK</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="NIK" name="NIK" value="<?php echo $NIK ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="NamaPelanggan" class="col-sm-2 col-form-label">Nama Pelanggan</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="NamaPelanggan" name="NamaPelanggan" value="<?php echo $NamaPelanggan ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="Alamat" class="col-sm-2 col-form-label">Alamat</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="Alamat" name="Alamat" value="<?php echo $Alamat ?>">
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
                Data Pelanggan
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col-12">NIK</th>
                            <th scope="col-12">Nama Pelanggan</th>
                            <th scope="col-12">Alamat</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql2   = "select * from pelanggan order by NIK desc";
                        $q2     = mysqli_query($koneksi, $sql2);
                        while ($r2 = mysqli_fetch_array($q2)) {
                            $NIK         = $r2['NIK'];
                            $NamaPelanggan       = $r2['NamaPelanggan'];
                            $Alamat      = $r2['Alamat'];

                        ?>
                            <tr>
                                <th scope="row"><?php echo $NIK ?></th>
                                <td scope="row"><?php echo $NamaPelanggan ?></td>
                                <td scope="row"><?php echo $Alamat ?></td>

                                <td scope="row">
                                    <a href="pelanggan.php?op=edit&NIK=<?php echo $NIK ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                    <a href="pelanggan.php?op=delete&NIK=<?php echo $NIK?>" onclick="return confirm('Yakin mau delete data?')"><button type="button" class="btn btn-danger">Delete</button></a>            
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