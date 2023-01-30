<?php
$server = "localhost";
$user = "root";
$password = "123";
$database = "db_baru";

$conn = mysqli_connect($server, $user, $password, $database) or die(mysqli_error($conn));
$key = mysqli_query($conn, "SELECT kd_barang FROM tb_barang order by kd_barang desc limit 1");
$a = mysqli_fetch_array($key);
if($a){
    $no_terakhir = substr($a['kd_barang'], -3);
    $nomor = $no_terakhir + 1;
    if($nomor >0 and $nomor<10){
        $kd = "00" . $nomor;

    }elseif($nomor >10 and $nomor<100){
        $kd = "0" . $nomor;
    }else if($no > 100){
        $kd = $nomor;
    }
}else{
    $kd = '001';
}

$tahun = date('Y');
$vkdbrg = "IVN-" . $tahun .'-'. $kd;


if(isset($_POST['simpan'])){

    if(isset($_GET['hal'])=='edit'){
        $edit = mysqli_query($conn, "UPDATE tb_barang SET 
        kd_barang = '$_POST[kdbrg]',
        nama_brg = '$_POST[nmbrg]',
        asal_brg = '$_POST[asbarang]',
        jumlah_brg ='$_POST[jmbrg]',
        satuan_brg ='$_POST[stbarang]',
        tanggal ='$_POST[tanggal]'
        WHERE id_barang = '$_GET[id]'
        ");
        if($edit){
        echo "<script>
        alert('Edit Data Berhasil');
        document.location='index.php';
        </script>";
        }else{
        echo "<script>
        alert('edit Data Gagal :( ');
        document.location='index.php';
        </script>";
        }
    }else{
        $simpan = mysqli_query($conn, "INSERT INTO tb_barang (kd_barang,nama_brg,asal_brg,jumlah_brg,satuan_brg,tanggal)
    VALUE ('$_POST[kdbrg]','$_POST[nmbrg]','$_POST[asbarang]','$_POST[jmbrg]','$_POST[stbarang]','$_POST[tanggal]')");
    if($simpan){
        echo "<script>
        alert('Simpan Data Berhasil');
        document.location='index.php';
        </script>";
    }else{
    echo "<script>
        alert('Simpan Data Gagal :( ');
        document.location='index.php';
        </script>";
    }
    }





    
}


$vnmbrg = "";
$vasbarang = "";
$vjmbrg = "";
$vstbarang = "";
$vtanggal = "";



if(isset($_GET['hal'])){
    if($_GET['hal']=='edit'){
        $tampil = mysqli_query($conn, "SELECT*FROM tb_barang WHERE id_barang = '$_GET[id]' ");
        $data = mysqli_fetch_array($tampil);
        if ($data) {
            $vkdbrg = $data['kd_barang'];
            $vnmbrg = $data['nama_brg'];
            $vasbarang = $data['asal_brg'];
            $vjmbrg = $data['jumlah_brg'];
            $vstbarang = $data['satuan_brg'];
            $vtanggal = $data['tanggal'];
        }
    } else if ($_GET['hal']=='hapus') {
        $hapus = mysqli_query($conn, "DELETE FROM tb_barang WHERE id_barang= '$_GET[id]'");
        if($hapus){
        echo "<script>
        alert('Hapus Data Berhasil');
        document.location='index.php';
        </script>";
        }else{
         echo "<script>
        alert('Hapus Data Gagal :( ');
        document.location='index.php';
        </script>";
    }
    }
}




?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inventaris Input Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>
    <div class="container">

        <h3 class="text-center">Data Inventaris</h3>
        <h3 class="text-center">Kantor Pusat Inventaris</h3>
        <div class="row">
            <div class="col-md-10 mx-auto">
                <div class="card ">
                    <div class="card-header bg-info text-light">
                        Form Input Data
                    </div>
                    <div class="card-body text-left">
                        <form method="post">
                            <div class="mb-3 ">
                                <label class="form-label ">Kode Barang</label>
                                <input type="text" class="form-control" name="kdbrg" value="<?= $vkdbrg?>"
                                    placeholder="Kode Barang">
                            </div>
                            <div class="mb-3 ">
                                <label class="form-label ">Nama Barang</label>
                                <input type="text" class="form-control" value="<?= $vnmbrg?>" name="nmbrg"
                                    placeholder="Nama Barang">
                            </div>
                            <div class="mb-3 ">
                                <label class="form-label ">Asal Barang</label>
                                <select class="form-select" name="asbarang">
                                    <option value="<?= $vasbarang?>"><?= $vasbarang?></option>
                                    <option value="Pembelian">Pembelian</option>
                                    <option value="Hibah">Hibah</option>
                                    <option value="Bantuan">Bantuan</option>
                                    <option value="Sumbangan">Sumbangan</option>
                                </select>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="mb-3 ">
                                        <label class="form-label ">Jumlah Barang</label>
                                        <input type="number" class="form-control" value="<?= $vjmbrg?>" name="jmbrg"
                                            placeholder="Jumlah Barang">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3 ">
                                        <label class="form-label ">Satuan Barang</label>
                                        <select class="form-select" name="stbarang" placeholder="Satuan Barang">
                                            <option value="<?= $vstbarang?>"><?= $vstbarang?></option>
                                            <option value="Unit">Unit</option>
                                            <option value="Kotak">Kotak</option>
                                            <option value="Pcs">Pcs</option>
                                            <option value="Box">Box</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3 ">
                                        <label class="form-label ">Tanggal diterima Barang</label>
                                        <input type="date" class="form-control" value="<?= $vtanggal?>" name="tanggal"
                                            placeholder="Jumlah Barang">
                                    </div>
                                </div>
                                <div class="text-end">
                                    <hr>
                                    <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                                    <button type="reset" name="kosongkan" class="btn btn-danger">Reset</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer bg-info text-light text-center">
                        Copyright @2023
                    </div>
                </div>
            </div>

        </div>

        <div class="card text-center mt-5">
            <div class="card-header bg-info text-light">
                Hasil Input Data
            </div>
            <div class="card-body">
                <div class="col-md-6">
                    <form method="post">
                        <div class="input-group mb-3">
                            <input type="text" name="bcari" value="<?=@$_POST['bcari']?>" class="form-control"
                                placeholder="Ketikan Barang Dicari">
                            <button class="btn btn-primary" name="cari" type="submit">Cari</button>
                            <button type="reset" name="kosongkan" class="btn btn-danger">Reset</button>
                        </div>

                    </form>
                </div>
                <table class="table table-striped table-hover table-bordered">
                    <tr>
                        <th>No.</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Asal Barang</th>
                        <th>Jumlah Barang</th>
                        <th>Tanggal Diterima</th>
                        <th>Action</th>

                    </tr>
                    <?php
                    $no = 1;
                    if(isset($_POST['cari'])){
                        $keyword = $_POST['bcari'];
                        $key = "SELECT * FROM tb_barang WHERE kd_barang like '%$keyword%' or nama_brg like '%$keyword%' or asal_brg like '%$keyword%' order by id_barang asc" ;
                    }else{
                        $key = "SELECT * FROM tb_barang order by id_barang asc";
                    }
                    $tampil = mysqli_query($conn,$key);
                    while ($data = mysqli_fetch_array($tampil)) :
                    
                    ?>
                    <tr>
                        <th><?=$no++?></th>
                        <th><?=$data ['kd_barang']?></th>
                        <th><?=$data ['nama_brg']?></th>
                        <th><?=$data ['asal_brg']?></th>
                        <th><?=$data ['jumlah_brg']?> <?=$data ['satuan_brg']?></th>
                        <th><?=$data ['tanggal']?></th>
                        <td>
                            <a href="index.php?hal=edit&id=<?= $data['id_barang'] ?>" class="btn btn-warning">Edit</a>
                            <a href="index.php?hal=hapus&id=<?= $data['id_barang'] ?>" class="btn btn-danger"
                                onclick="return confirm('Are You Sure?')">Hapus</a>
                        </td>

                    </tr>
                    <?php endwhile; ?>
                </table>
            </div>
            <div class="card-footer bg-info text-light text-center">
                Copyright @2023
            </div>
        </div>

    </div>













    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
</body>

</html>