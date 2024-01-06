<?php
if (!isset($_SESSION)) {
    session_start();
}

if (isset($_POST['simpanData'])) {
    $id_daftar_poli = $_GET['id']; // Get the id from the URL
    $id_obat = $_POST['id_obat']; // Get the id_obat value from the form
    $base_biaya_periksa = 150000;
    $tgl_periksa = date('Y-m-d H:i:s'); // Get the current datetime
    $catatan = $_POST['catatan']; // Get the catatan value from the form

    // Query the obat table to get the harga for the selected id_obat
    $result = mysqli_query($mysqli, "SELECT harga FROM obat WHERE id = '$id_obat'");
    $data = mysqli_fetch_assoc($result);
    $harga_obat = $data['harga'];

    // Calculate the total biaya_periksa
    $biaya_periksa = $base_biaya_periksa + $harga_obat;

    $sql = "INSERT INTO periksa (id_daftar_poli, tgl_periksa, catatan, biaya_periksa) VALUES ('$id_daftar_poli', '$tgl_periksa', '$catatan', '$biaya_periksa')";
    $tambah = mysqli_query($mysqli, $sql);

    // Get the id_periksa of the record just inserted
    $id_periksa = mysqli_insert_id($mysqli);

    // Insert into detail_periksa table
    $sql = "INSERT INTO detail_periksa (id_periksa, id_obat) VALUES ('$id_periksa', '$id_obat')";
    $tambah = mysqli_query($mysqli, $sql);

    echo "
            <script> 
                alert('Berhasil menambah data.');
                window.location.href='dokterdashboard.php?page=periksa';
            </script>
        ";
    exit();
}
?>

<main id="periksapasien-page">
    <div class="container" style="margin-top: 2.5rem;">
        <div class="row">
            <h2 class="ps-0">Data Pasien Saya</h2>

            <div class="container">
                <form action="" method="POST">
                    <?php
                    $id_pasien = '';
                    $id_dokter = $_SESSION['id'];
                    $nama_dokter = $_SESSION['nama'];
                    $tgl_periksa = '';
                    $catatan = '';
                    $nama_pasien = '';
                    $no_antrian = '';
                    $keluhan = '';
                    if (isset($_GET['id'])) {
                        $get = mysqli_query($mysqli, "
                                SELECT daftar_poli.*, pasien.nama AS nama
                                FROM daftar_poli
                                JOIN pasien ON daftar_poli.id_pasien = pasien.id
                                WHERE daftar_poli.id='" . $_GET['id'] . "'
                            ");
                        while ($row = mysqli_fetch_array($get)) {
                            $id_pasien = $row['id_pasien'];
                            $nama_pasien = $row['nama'];
                            $no_antrian = $row['no_antrian'];
                            $keluhan = $row['keluhan'];
                        }
                    }
                    ?>
                    <input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>">
                    <input type="hidden" name="id_pasien" value="<?php echo $id_pasien; ?>">
                    <input type="hidden" name="id_dokter" value="<?php echo $id_dokter; ?>">
                    <div class="mb-3 w-25">
                        <label for="no_antrian">No. Antrian <span class="text-danger">*</span></label>
                        <input disabled type="text" name="no_antrian" class="form-control" required value="<?php echo $no_antrian ?>">
                    </div>
                    <div class="mb-3 w-25">
                        <label for="id_pasien">Nama Pasien <span class="text-danger">*</span></label>
                        <input disabled type="text" name="id_pasien" class="form-control" required value="<?php echo $nama_pasien ?>">
                    </div>
                    <div class="mb-3 w-25">
                        <label for="id_dokter">Nama Dokter <span class="text-danger">*</span></label>
                        <input disabled type="text" name="id_dokter" class="form-control" required value="<?php echo $nama_dokter ?>">
                    </div>
                    <div class="mb-3 w-25">
                        <label for="catatan">Catatan <span class="text-danger">*</span></label>
                        <input type="text" name="catatan" class="form-control" required value="<?php echo $catatan ?>">
                    </div>
                    <div class="dropdown mb-3 w-25">
                        <label for="id_obat">Obat <span class="text-danger">*</span></label>
                        <select class="form-select" name="id_obat" id="id_obat" aria-label="id_obat" multiple>
                            <option value="">Pilih Obat...</option>
                            <?php
                            $result = mysqli_query($mysqli, "SELECT * FROM obat");

                            while ($data = mysqli_fetch_assoc($result)) {
                                echo "<option value='" . $data['id'] . "'data-harga='" . $data['harga'] . "' >" . $data['nama_obat'] . " (" . $data['kemasan'] . ")"  . " (Rp " . $data['harga'] . ")" . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <style>
                        /* Style for the total biaya periksa alert */
                        #total_biaya_periksa {
                            background-color: #d4edda;
                            /* Set the background color */
                            color: #155724;
                            /* Set the text color */
                            border-color: #c3e6cb;
                            /* Set the border color */
                        }
                    </style>
                    <div id="total_biaya_periksa" class="alert alert-success" role="alert"></div>
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            // Initialize Select2 for the id_obat dropdown
                            $('#id_obat').select2({
                                placeholder: 'Pilih Obat'
                            });

                            // Add an onchange event listener to the id_obat dropdown
                            $('#id_obat').on('change.select2', function(e) {
                                updateTotalBiayaPeriksa();
                            });

                            updateTotalBiayaPeriksa();

                        });

                        // Function to update the total biaya periksa
                        function updateTotalBiayaPeriksa() {
                            var baseBiayaPeriksa = 150000;
                            var biayaPeriksa = baseBiayaPeriksa;

                            // Get selected options from the id_obat dropdown
                            var selectedObats = document.getElementById('id_obat').selectedOptions;

                            // Loop through selected options and update biayaPeriksa
                            for (var i = 0; i < selectedObats.length; i++) {
                                var hargaObat = parseFloat(selectedObats[i].getAttribute('data-harga'));
                                biayaPeriksa += parseFloat(hargaObat);
                            }


                            // Display the updated total biaya periksa
                            document.getElementById('total_biaya_periksa').textContent = 'Total Biaya Periksa: Rp ' + biayaPeriksa
                                .toLocaleString();
                        }
                    </script>
                    <div class="col mt-3">
                        <div class="col">
                            <button type="submit" name="simpanData" class="btn btn-primary rounded px-3 mt-auto">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="table-responsive mt-3 px-0">
                <table class="table text-center">
                    <thead class="table-primary">
                        <tr>
                            <th valign="middle">No</th>
                            <th valign="middle">Nama Pasien</th>
                            <th valign="middle">Keluhan</th>
                            <th valign="middle">Hari</th>
                            <th valign="middle">Jam Periksa</th>
                            <th valign="middle">No. Antrian</th>
                            <th valign="middle">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $id_dokter = $_SESSION['id'];
                        $result = mysqli_query($mysqli, "
                                SELECT daftar_poli.*, pasien.nama AS nama, jadwal_periksa.hari, jadwal_periksa.jam_mulai, jadwal_periksa.jam_selesai
                                FROM daftar_poli
                                JOIN (
                                    SELECT id_pasien, MAX(tanggal) as max_tanggal
                                    FROM daftar_poli
                                    GROUP BY id_pasien
                                ) as latest_poli ON daftar_poli.id_pasien = latest_poli.id_pasien AND daftar_poli.tanggal = latest_poli.max_tanggal
                                JOIN jadwal_periksa ON daftar_poli.id_jadwal = jadwal_periksa.id 
                                JOIN pasien ON daftar_poli.id_pasien = pasien.id
                                LEFT JOIN periksa ON daftar_poli.id = periksa.id_daftar_poli
                                WHERE jadwal_periksa.id_dokter = '$id_dokter' AND periksa.id_daftar_poli IS NULL
                            ");
                        $no = 1;
                        while ($data = mysqli_fetch_array($result)) :
                        ?>
                            <tr>
                                <td><?php echo $no++ ?></td>
                                <td><?php echo $data['nama'] ?></td>
                                <td><?php echo $data['keluhan'] ?></td>
                                <td><?php echo $data['hari'] ?></td>
                                <td>
                                    <?php
                                    echo date('H:i', strtotime($data['jam_mulai']));
                                    echo ' - ' . date('H:i', strtotime($data['jam_selesai']));
                                    ?>
                                </td>

                                <td><?php echo $data['no_antrian'] ?></td>
                                <td>
                                    <a class="btn btn-success rounded-pill px-3" href="dokterdashboard.php?page=periksa&id=<?php echo $data['id'] ?>">Periksa</a>

                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>