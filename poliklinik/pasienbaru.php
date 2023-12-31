<?php
if (!isset($_SESSION)) {
    session_start();
}

if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $no_ktp = $_POST['no_ktp'];
    $no_hp = $_POST['no_hp'];

    // Check if the No KTP already exists
    $checkNoKTP = mysqli_query($mysqli, "SELECT * FROM pasien WHERE no_ktp = '$no_ktp'");
    if (mysqli_num_rows($checkNoKTP) > 0) {
        // No KTP already exists, show an alert
        echo "<script>alert('No KTP sudah terdaftar. Pasien dengan No KTP tersebut tidak dapat mendaftar.');</script>";
    } else {
        // No KTP doesn't exist, proceed with insert or update
        if (isset($_POST['id'])) {
            // Update existing patient
            $ubah = mysqli_query($mysqli, "UPDATE pasien SET 
                                              nama = '$nama',
                                              alamat = '$alamat',
                                              no_ktp = '$no_ktp',
                                              no_hp = '$no_hp'
                                              WHERE
                                              id = '" . $_POST['id'] . "'");
        } else {
            // Generate No Rekam Medis
            $date = date('Ym'); // Get current year and month

            // Get the latest sequential number for the current month
            $result = mysqli_query($mysqli, "SELECT MAX(SUBSTRING_INDEX(no_rm, '-', -1)) as max_count FROM pasien WHERE no_rm LIKE '$date%'");
            $data = mysqli_fetch_assoc($result);
            $count = ($data['max_count'] != null) ? $data['max_count'] + 1 : 1;
            $formattedCount = sprintf('%03d', $count); // Format count to have leading zeros
            $no_rm = $date . '-' . $formattedCount;

            // Insert new patient with Nomor Rekam Medis
            $tambah = mysqli_query($mysqli, "INSERT INTO pasien (nama, alamat, no_ktp, no_hp, no_rm) 
                                              VALUES (
                                                  '$nama',
                                                  '$alamat',
                                                  '$no_ktp',
                                                  '$no_hp',
                                                  '$no_rm'
                                              )");

            if (!$tambah) {
                // Handle insertion error
                echo "<script>alert('Error: " . mysqli_error($mysqli) . "');</script>";
            }
        }

        echo "<script>alert('Berhasil mendaftar. No Rekam Medis: $no_rm'); document.location='index.php?page=pasienbaru';</script>";
    }
}

if (isset($_GET['aksi'])) {
    if ($_GET['aksi'] == 'hapus') {
        $hapus = mysqli_query($mysqli, "DELETE FROM pasien WHERE id = '" . $_GET['id'] . "'");
    }

    echo "<script> 
              document.location='index.php?page=pasienbaru';
              </script>";
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
        if (isset($_GET['id'])) {
            $ambil = mysqli_query($mysqli, "SELECT * FROM pasien WHERE id='" . $_GET['id'] . "'");
            while ($row = mysqli_fetch_array($ambil)) {
                $nama = $row['nama'];
                $alamat = $row['alamat'];
                $no_ktp = $row['no_ktp'];
                $no_hp = $row['no_hp'];
            }
        ?>
            <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
        <?php
        }
        ?>
        <div class="col">
            <label for="inputNama" class="form-label fw-bold">
                Nama
            </label>
            <div>
                <input type="text" class="form-control" name="nama" id="inputNama" required placeholder="cth: Lionel Ronaldo" value="<?php echo $nama ?>">
            </div>
        </div>
        <div class="col mt-1">
            <label for="inputalamat" class="form-label fw-bold">
                Alamat
            </label>
            <div>
                <input type="text" class="form-control" name="alamat" id="inputalamat" required placeholder="cth: Jl.Mawar" value="<?php echo $alamat ?>">
            </div>
        </div>
        <div class="col mt-1">
            <label for="inputNoKtp" class="form-label fw-bold">
                No KTP
            </label>
            <div>
                <input type="text" class="form-control" name="no_ktp" id="inputNoKtp" required placeholder="3319xxxxxxxxxxxx" value="<?php echo $no_ktp ?>">
            </div>
        </div>
        <div class="col mt-1">
            <label for="inputNoHp" class="form-label fw-bold">
                No HP
            </label>
            <div>
                <input type="text" class="form-control" name="no_hp" id="inputNoHp" required placeholder="08XXXXXXXXXX" value="<?php echo $no_hp ?>">
            </div>
        </div>
        <div class="col mt-3">
            <div class="col">
                <button type="submit" class="btn btn-primary rounded-pill px-3 mt-auto" name="simpan">Simpan</button>
            </div>
        </div>
    </form>
    <br>
    <br>
</div>
