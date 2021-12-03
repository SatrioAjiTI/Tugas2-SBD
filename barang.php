<?php
$host       = "localhost";
$user       = "root";
$pass       = "";
$db         = "c8";

$koneksi    = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) { //cek koneksi
    die("Tidak bisa terkoneksi ke database");
}
$IdBarang           ="";
$NamaBarang        = "";
$Harga             = "";
$Stok = "";
$sukses     = "";
$error      = "";


if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}
if($op == 'delete'){
    $IdBarang   = $_GET['IdBarang'];
    $sql1       = "delete from barang where IdBarang = '$IdBarang'";
    $q1         = mysqli_query($koneksi,$sql1);
    if($q1){
        $sukses = "Berhasil hapus data";
    }else{
        $error  = "Gagal melakukan delete data";
    }
}
if ($op == 'edit') {
    $IdBarang    = $_GET['IdBarang'];
    $sql1       = "select * from barang where IdBarang = '$IdBarang'";
    $q1         = mysqli_query($koneksi, $sql1);
    $r1         = mysqli_fetch_array($q1);
    $NamaBarang = $r1['NamaBarang'];
    $Harga       = $r1['Harga'];
    $Stok        = $r1['Stok'];

    if ($IdBarang == '') {
        $error = "Data tidak ditemukan";
    }
}
if (isset($_POST['simpan'])) { //untuk create
    $IdBarang   = $_POST['IdBarang'];
    $NamaBarang        = $_POST['NamaBarang'];
    $Harga       = $_POST['Harga'];
    $Stok        = $_POST['Stok'];


    if ($IdBarang && $NamaBarang && $Harga && $Stok) {
        if ($op == 'edit') { //untuk update
            $sql1       = "update barang set NamaBarang = '$NamaBarang',Harga= $Harga, Stok = $Stok  where IdBarang = '$IdBarang'";
            $q1         = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Data berhasil diupdate";
            } else {
                $error  = "Data gagal diupdate";
            }
        } else { //untuk insert
            $sql1   = "insert into barang(IdBarang,NamaBarang,Harga) values ($IdBarang,'$NamaBarang', $Harga,$Stok)";
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
    <title>Tabel Barang</title>
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
                Tabel Barang
                
            </div>
            <div class="card-body">
                <?php
                if ($error) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                <?php
                    header("refresh:5;url=barang.php");//5 : detik
                }
                ?>
                <?php
                if ($sukses) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                <?php
                    header("refresh:5;url=barang.php");
                }
                ?>
                <form action="" method="POST">
                    <div class="mb-3 row">
                        <label for="IdBarang" class="col-sm-2 col-form-label">Id Barang</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="IdBarang" name="IdBarang" value="<?php echo $IdBarang ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="NamaBarang" class="col-sm-2 col-form-label">Nama Barang</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="NamaBarang" name="NamaBarang" value="<?php echo $NamaBarang ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="Harga" class="col-sm-2 col-form-label">Harga</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="Harga" name="Harga" value="<?php echo $Harga ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="Stok" class="col-sm-2 col-form-label">Stok</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="Stok" name="Stok" value="<?php echo $Stok ?>">
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
                Data Barang
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col-12">Id Barang</th>
                            <th scope="col-12">Nama Barang</th>
                            <th scope="col-12">Harga</th>
                            <th scope="col-12">Stok</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql2   = "select * from barang order by IdBarang desc";
                        $q2     = mysqli_query($koneksi, $sql2);
                        while ($r2 = mysqli_fetch_array($q2)) {
                            $IdBarang         = $r2['IdBarang'];
                            $NamaBarang       = $r2['NamaBarang'];
                            $Harga      = $r2['Harga'];
                            $Stok = $r2['Stok'];

                        ?>
                            <tr>
                                <th scope="row"><?php echo $IdBarang ?></th>
                                <td scope="row"><?php echo $NamaBarang ?></td>
                                <td scope="row"><?php echo $Harga ?></td>
                                <td scope="row"><?php echo $Stok ?></td>

                                <td scope="row">
                                    <a href="barang.php?op=edit&IdBarang=<?php echo $IdBarang ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                    <a href="barang.php?op=delete&IdBarang=<?php echo $IdBarang?>" onclick="return confirm('Yakin mau delete data?')"><button type="button" class="btn btn-danger">Delete</button></a>            
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