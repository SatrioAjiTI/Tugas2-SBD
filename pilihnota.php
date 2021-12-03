<?php
$host       = "localhost";
$user       = "root";
$pass       = "";
$db         = "c8";

$koneksi    = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) { //cek koneksi
    die("Tidak bisa terkoneksi ke database");
}
$NotaNo          ="";



if (isset($_POST['simpan'])) { //untuk create
    $NotaNo   = $_POST['NotaNo'];
    if ($NotaNo) {
        ?>
        <meta http-equiv='refresh' content='0; URL=invoice.php?NotaNo=<?php echo $NotaNo ?>'>
        <?php
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
                Tampilkan Nota
        </div>
        <div class="card-body">
            <form action="" method="POST">
            <div class="mb-3 row">
                  <label for="NotaNo" class="col-sm-2 col-form-label">Nomor Nota</label>
                  <div class="col-sm-10">
                        <select name="NotaNo" id="NotaNo" class="form-control" required>
                        <option value="">- Pilih Nota Nomor -</option>
                        <?php
                        $sql_NotaNo = mysqli_query($koneksi, "SELECT NotaNo FROM transaksi") or die (mysqli_error($koneksi));
                        while($NotaNo = mysqli_fetch_array($sql_NotaNo)) {
                           echo '<option value ="'.$NotaNo ['NotaNo'].'" > '.$NotaNo['NotaNo']. '</option>';
                        } ?>
                        </select>
                  </div>
                </div>
                <div class="col-12">
                        <input type="submit" name="simpan" value="Select" class="btn btn-primary" />
                </div>
            </div>
        </div>
                    </div>
</body>