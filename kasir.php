<?php
$host       = "localhost";
$user       = "root";
$pass       = "";
$db         = "c8";

$koneksi    = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) { //cek koneksi
    die("Tidak bisa terkoneksi ke database");
}
$IdKasir           ="";
$NamaKasir       = "";
$sukses     = "";
$error      = "";



if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}
if($op == 'delete'){
    $IdKasir   = $_GET['IdKasir'];
    $sql1       = "delete from kasir where IdKasir = '$IdKasir'";
    $q1         = mysqli_query($koneksi,$sql1);
    if($q1){
        $sukses = "Berhasil hapus data";
    }else{
        $error  = "Gagal melakukan delete data";
    }
}
if ($op == 'edit') {
    $IdKasir    = $_GET['IdKasir'];
    $sql1       = "select * from kasir where IdKasir = '$IdKasir'";
    $q1         = mysqli_query($koneksi, $sql1);
    $r1         = mysqli_fetch_array($q1);
    $NamaKasir = $r1['NamaKasir'];
    

    if ($IdKasir == '') {
        $error = "Data tidak ditemukan";
    }
}
if (isset($_POST['simpan'])) { //untuk create
    $IdKasir   = $_POST['IdKasir'];
    $NamaKasir       = $_POST['NamaKasir'];



    if ($IdKasir && $NamaKasir) {
        if ($op == 'edit') { //untuk update
            $sql1       = "update kasir set Namakasir = '$NamaKasir' where IdKasir = '$IdKasir'";
            $q1         = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Data berhasil diupdate";
            } else {
                $error  = "Data gagal diupdate";
            }
        } else { //untuk insert
            $sql1   = "insert into kasir(IdKasir,NamaKasir) values ($IdKasir,'$NamaKasir')";
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
    <title>Tabel Kasir</title>
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
                Tabel Kasir
            </div>
            <div class="card-body">
                <?php
                if ($error) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                <?php
                    header("refresh:5;url=kasir.php");//5 : detik
                }
                ?>
                <?php
                if ($sukses) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                <?php
                    header("refresh:5;url=kasir.php");
                }
                ?>
                <form action="" method="POST">
                <div class="mb-3 row">
                        <label for="IdKasir" class="col-sm-2 col-form-label">Id Kasir</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="IdKasir" name="IdKasir" value="<?php echo $IdKasir ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="NamaKasir" class="col-sm-2 col-form-label">Nama Kasir</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="NamaKasir" name="NamaKasir" value="<?php echo $NamaKasir ?>">
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
                Data Kasir
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col-12">Id Kasir</th>
                            <th scope="col-12">Nama Kasir</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql2   = "select * from kasir order by IdKasir desc";
                        $q2     = mysqli_query($koneksi, $sql2);
                        while ($r2 = mysqli_fetch_array($q2)) {
                            $IdKasir         = $r2['IdKasir'];
                            $NamaKasir       = $r2['NamaKasir'];

                        ?>
                            <tr>
                                <th scope="row"><?php echo $IdKasir ?></th>
                                <td scope="row"><?php echo $NamaKasir ?></td>
                                <td scope="row">
                                    <a href="kasir.php?op=edit&IdKasir=<?php echo $IdKasir ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                    <a href="kasir.php?op=delete&IdKasir=<?php echo $Idkasir?>" onclick="return confirm('Yakin mau delete data?')"><button type="button" class="btn btn-danger">Delete</button></a>            
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