<?php
if (!isset($_SESSION)) {
    session_start();
}

// Simpan data pasien ke dalam sesi
$_SESSION['nama'] = $pasien['nama'];
$_SESSION['no_rm'] = $pasien['no_rm'];
// ... tambahkan data pasien lainnya sesuai kebutuhan

?>
<div class="container">
    <!--Form Input Data-->

    <form class="form col" method="POST" action="" name="myForm" onsubmit="return(validate());">
        <!-- Kode php untuk menghubungkan form dengan database -->
        <div class="col">
            <label for="inputNama" class="form-label fw-bold">
                Nama
            </label>
            <div>
                <input type="text" class="form-control" name="nama" id="inputNama" disabled value="<?php echo $_SESSION['nama']; ?>">
            </div>
        </div>
        <div class="col mt-1">
            <label for="inputNoRm" class="form-label fw-bold">
                Nomor Rekam Medis
            </label>
            <div>
                <input type="text" class="form-control" name="no_rm" id="inputNoRm" disabled value="<?php echo $_SESSION['no_rm']; ?>">
            </div>
        </div>

        <div class="col mt-1">
            <label for="inputPoli" class="form-label fw-bold">
                Poli
            </label>
            <div>
                <select class="form-select" required name="id_poli" id="inputPoli">
                    <option value="">Pilih Poli</option>
                    <?php
                    $poli_result = mysqli_query($mysqli, "SELECT * FROM poli");
                    while ($poli_data = mysqli_fetch_array($poli_result)) {
                        $selected = ($poli_data['id'] == $id_poli) ? 'selected' : '';
                        echo "<option value='" . $poli_data['id'] . "' $selected>" . $poli_data['nama_poli'] . "</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="col mt-1">
            <label for="inputJadwal" class="form-label fw-bold">
                Pilih Jadwal
            </label>
            <div>
                <select class="form-select" required name="id_jadwal" id="inputJadwal">
                    <option value="">Pilih Jadwal</option>
                </select>
            </div>
        </div>
        <div class="col mt-1">
            <label for="inputKeluhan" class="form-label fw-bold">
                Keluhan
            </label>
            <div>
                <input type="TEXTAREA" class="form-control" name="keluhan" id="inputKeluhan" required placeholder="Masukkan keluhan Anda..." value="<?php echo $keluhan  ?>">
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