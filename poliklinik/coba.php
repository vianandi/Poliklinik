<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['username'])) {
    // Jika pengguna sudah login, tampilkan tombol "Logout"
    header("Location: index.php?page=loginDokter");
    exit;
}

// Form submission handling
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['simpan'])) {
    // ... (other code)

    $valid_jam_mulai = preg_match('/^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/', $jam_mulai);
    $valid_jam_selesai = preg_match('/^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/', $jam_selesai);
    $valid_hari_values = array("Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu");

    if (!empty($id_dokter) && !empty($hari) && in_array($hari, $valid_hari_values) && $valid_jam_mulai && $valid_jam_selesai) {
        // ... (other code)
    } else {
        echo "Invalid input or missing fields!";
    }
}


$id_dokter = '';
$hari = '';
$jam_mulai = '';
$jam_selesai = '';


if (isset($_POST['simpan'])) {
    // Validate and sanitize user inputs
    $id_dokter = mysqli_real_escape_string($mysqli, $_POST['id_dokter']);
    $hari = mysqli_real_escape_string($mysqli, $_POST['hari']);
    $jam_mulai = mysqli_real_escape_string($mysqli, $_POST['jam_mulai']);
    $jam_selesai = mysqli_real_escape_string($mysqli, $_POST['jam_selesai']);

    if (isset($_POST['id'])) {
        // Update existing record
        $query = "UPDATE jadwal_periksa SET 
                      id_dokter = '$id_dokter',
                      hari = '$hari',
                      jam_mulai = '$jam_mulai',
                      jam_selesai = '$jam_selesai'
                  WHERE id = '" . $_POST['id'] . "'";
    } else {
        $sql = "INSERT INTO jadwal_periksa (id_dokter, hari, jam_mulai, jam_selesai) VALUES ('$id_dokter', '$hari', '$jam_mulai', '$jam_selesai')";
        $tambah = mysqli_query($mysqli, $sql);

        echo "
                <script> 
                    alert('Berhasil menambah data.');
                    document.location='dashboard.php?page=jadwalperiksa';
                </script>
            ";
    }

    // Perform the query
    $result = mysqli_query($mysqli, $query);

    if ($result) {
        echo "<script> 
                  alert('Data saved successfully');
                  document.location='dashboard.php?page=coba';
              </script>";
    } else {
        echo "<script> 
                  alert('Error saving data');
              </script>";
    }
}


if (isset($_GET['aksi'])) {
    if ($_GET['aksi'] == 'hapus') {
        $hapus = mysqli_query($mysqli, "DELETE FROM jadwal_periksa WHERE id = '" . $_GET['id'] . "'");
    }

    echo "<script> 
              document.location='dashboard.php?page=jadwal_periksa';
              </script>";
}


if (isset($_GET['id'])) {
    $ambil = mysqli_query($mysqli, "SELECT * FROM jadwal_periksa WHERE id='" . $_GET['id'] . "'");
    while ($row = mysqli_fetch_array($ambil)) {
        $id_dokter = $row['id_dokter'];
        $hari = $row['hari'];
        $jam_mulai = $row['jam_mulai'];
        $jam_selesai = $row['jam_selesai'];
    }
}
?>
<div class="container">
    <!--Form Input Data-->
    <form class="form col" method="POST" action="" name="myForm" onsubmit="return(validate());">
        <input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?>">
        <div class="col mt-1">
            <label for="inputIDDokter" class="form-label fw-bold">
                ID Dokter
            </label>
            <div>
                <select class="form-select" required name="id_dokter" id="inputIDDokter">
                    <option value="">Pilih ID Dokter</option>
                    <?php
                    $pid_dokter_result = mysqli_query($mysqli, "SELECT * FROM dokter");
                    while ($id_dokter_data = mysqli_fetch_array($pid_dokter_result)) {
                        $selected = ($id_dokter_data['id'] == $id_dokter) ? 'selected' : '';
                        echo "<option value='" . $id_dokter_data['id'] . "' $selected>" . $id_dokter_data['id'] . "</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="col mt-1">
            <label for="inputhari" class="form-label fw-bold">
                Hari
            </label>
            <div>
                <select class="form-select" name="hari" id="inputhari" required>
                    <option value="" disabled>Pilih Hari</option>
                    <option value="Senin" <?php echo ($hari == 'Senin') ? 'selected' : ''; ?>>Senin</option>
                    <option value="Selasa" <?php echo ($hari == 'Selasa') ? 'selected' : ''; ?>>Selasa</option>
                    <option value="Rabu" <?php echo ($hari == 'Rabu') ? 'selected' : ''; ?>>Rabu</option>
                    <option value="Kamis" <?php echo ($hari == 'Kamis') ? 'selected' : ''; ?>>Kamis</option>
                    <option value="Jumat" <?php echo ($hari == 'Jumat') ? 'selected' : ''; ?>>Jumat</option>
                    <option value="Sabtu" <?php echo ($hari == 'Sabtu') ? 'selected' : ''; ?>>Sabtu</option>
                </select>
            </div>
        </div>
        <div class="col mt-1">
            <label for="inputJamMulai" class="form-label fw-bold">
                Jam Mulai
            </label>
            <div>
                <input type="time" class="form-control" name="jam_mulai" id="inputJamMulai" required value="<?php echo $jam_mulai; ?>">
            </div>
        </div>
        <div class="col mt-1">
            <label for="inputJamSelesai" class="form-label fw-bold">
                Jam Selesai
            </label>
            <div>
                <input type="time" class="form-control" name="jam_selesai" id="inputJamSelesai" required value="<?php echo $jam_selesai; ?>">
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
    <!-- Table-->
    <table class="table table-hover">
        <!--thead atau baris judul-->
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">ID Dokter</th>
                <th scope="col">Hari</th>
                <th scope="col">Jam Mulai</th>
                <th scope="col">Jam Selesai</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <!--tbody berisi isi tabel sesuai dengan judul atau head-->
        <tbody>
            <!-- Kode PHP untuk menampilkan semua isi dari tabel urut-->
            <?php
            $result = mysqli_query($mysqli, "SELECT jadwal_periksa.*, dokter.id AS id_dokter FROM jadwal_periksa JOIN dokter ON jadwal_periksa.id_dokter = dokter.id");
            $no = 1;
            while ($data = mysqli_fetch_array($result)) {
            ?>
                <tr>
                    <th scope="row"><?php echo $no++ ?></th>
                    <td><?php echo $data['id_dokter'] ?></td>
                    <td><?php echo $data['hari'] ?></td>
                    <td><?php echo $data['jam_mulai'] ?></td>
                    <td><?php echo $data['jam_selesai'] ?></td>
                    <td>
                        <a class="btn btn-success rounded-pill px-3" href="dashboard.php?page=coba&id=<?php echo $data['id'] ?>">Ubah</a>
                        <a class="btn btn-danger rounded-pill px-3" href="dashboard.php?page=coba&id=<?php echo $data['id'] ?>&aksi=hapus">Hapus</a>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>