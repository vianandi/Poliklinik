<?php
if (!isset($_SESSION)) {
    session_start();
}

$showTable = false;
$searchResults = [];

if (isset($_POST['cari'])) {
    $no_ktp = $_POST['no_ktp'];
    // Check if the No KTP already exists
    $checkNoKTP = mysqli_query($mysqli, "SELECT * FROM pasien WHERE no_ktp = '$no_ktp'");
    if (mysqli_num_rows($checkNoKTP) > 0) {
        $showTable = true;
        // Fetch the rows that match the entered No KTP
        $searchResults = mysqli_query($mysqli, "SELECT * FROM pasien WHERE no_ktp = '$no_ktp'");
    } else {
        // No KTP doesn't exist, show an alert
        echo "<script>alert('No KTP Belum terdaftar. Pasien dengan No KTP tersebut tidak dapat mendaftar Poliklinik.');</script>";
    }
}
?>
<br>
<br>
<div class="container">
    <!--Form Input Data-->
    <form class="form col" method="POST" action="" name="myForm" onsubmit="return(validate());">
        <!-- Kode php untuk menghubungkan form dengan database -->
        <?php
        $nama = '';
        $alamat = '';
        $no_ktp = '';
        $no_hp = '';
        $no_rm = '';
        if (isset($_GET['id'])) {
            $ambil = mysqli_query($mysqli, "SELECT * FROM pasien WHERE id='" . $_GET['id'] . "'");
            while ($row = mysqli_fetch_array($ambil)) {
                $nama = $row['nama'];
                $alamat = $row['alamat'];
                $no_ktp = $row['no_ktp'];
                $no_hp = $row['no_hp'];
                $no_rm = $row['no_rm'];
            }
        ?>
            <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
        <?php
        }
        ?>
        <div class="col mt-1">
            <label for="inputNoKtp" class="form-label fw-bold">
                No KTP
            </label>
            <div>
                <input type="text" class="form-control" name="no_ktp" id="inputNoKtp" required placeholder="3319xxxxxxxxxxxx" value="<?php echo $no_ktp ?>">
            </div>
        </div>
        <div class="col mt-3">
            <div class="col">
                <button type="submit" class="btn btn-primary rounded-pill px-3 mt-auto" name="cari">Cari</button>
            </div>
        </div>
    </form>
    <br>
    <br>
    <!-- Table-->
    <?php if ($showTable) : ?>
        <table class="table table-hover">
            <!--thead atau baris judul-->
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Alamat</th>
                    <th scope="col">Nomor KTP</th>
                    <th scope="col">Nomor Handphone</th>
                    <th scope="col">Nomor Rekam Medis</th>
                </tr>
            </thead>
            <!--tbody berisi isi tabel sesuai dengan judul atau head-->
            <tbody>
                <!-- Kode PHP untuk menampilkan semua isi dari tabel urut-->
                <?php
                $no = 1;
                while ($data = mysqli_fetch_array($searchResults)) {
                ?>
                    <tr>
                        <th scope="row"><?php echo $no++ ?></th>
                        <td><?php echo $data['nama'] ?></td>
                        <td><?php echo $data['alamat'] ?></td>
                        <td><?php echo $data['no_ktp'] ?></td>
                        <td><?php echo $data['no_hp'] ?></td>
                        <td><?php echo $data['no_rm'] ?></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>