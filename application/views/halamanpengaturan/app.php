<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Pengaturan Akun /</span> Pengaturan Konfigurasi
            Aplikasi</h4>

        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-pills flex-column flex-md-row mb-3">
                    <?php
                    if ($userid != '1') {
                        if ($plh != '1') {
                            if ($plt != '1') {
                                ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?= site_url('profil'); ?>" data-loader><i
                                            class="bx bx-user me-1"></i>
                                        Data Pegawai</a>
                                </li>
                            <?php }
                        }
                    }

                    if ($plh != '1') {
                        if ($plt != '1') {
                            ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= site_url('user'); ?>" data-loader><i class="bx bx-bell me-1"></i>
                                    Data User</a>
                            </li>
                        <?php }
                    }

                    if (in_array($role, ['super', 'admin_satker', 'validator_kepeg_satker'])) {
                        ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= site_url('plh'); ?>" data-loader><i class="bx bx-bell me-1"></i>
                                Pengaturan Plh</a>
                        </li>
                        <?php
                    }

                    if (in_array($role, ['super', 'admin_satker', 'validator_kepeg_satker'])) {
                        ?>
                        <li class="nav-item">
                            <a class="nav-link active" href="javascript:void(0);"><i class="bx bx-wrench me-1"></i>
                                Pengaturan Aplikasi</a>
                        </li>
                        <?php
                    }
                    ?>
                </ul>

                <div class="card mb-4">
                    <h5 class="card-header">Pengaturan Aplikasi</h5>
                    <!-- Account -->

                    <div class="card-body">
                        <div class="row">
                            <form id="formUser" method="POST" action="<?= site_url('simpan_config') ?>"
                                onsubmit="return showLoaderSweetalert2(this)">
                                <div class="row">
                                    <input class="form-control" type="hidden" id="id_nama" name="id"
                                        value="<?= base64_encode($this->encryption->encrypt($nama_app->row()->id)) ?>" />
                                    <label for="nama_app" class="form-label">NAMA APLIKASI</label>
                                    <div class="mb-3 col-md-10">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="nama_app" name="app"
                                                value="<?= $nama_app->row()->value ?>" />
                                        </div>
                                    </div>

                                    <div class="mb-3 col-md-2 col-sm-12 text-center">
                                        <button type="submit" class="btn btn-primary me-2">Simpan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="row">
                            <form id="formUser" method="POST" action="<?= site_url('simpan_config') ?>"
                                onsubmit="return showLoaderSweetalert2(this)">
                                <div class="row">
                                    <input class="form-control" type="hidden" id="id_title" name="id"
                                        value="<?= base64_encode($this->encryption->encrypt($title_app->row()->id)) ?>" />
                                    <label for="title_app" class="form-label">DESKRIPSI APLIKASI</label>
                                    <div class="mb-3 col-md-10">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="title_app" name="app"
                                                value="<?= $title_app->row()->value ?>" />
                                        </div>
                                    </div>

                                    <div class="mb-3 col-md-2 col-sm-12 text-center">
                                        <button type="submit" class="btn btn-primary me-2">Simpan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="row">
                            <form id="formUser" method="POST" action="<?= site_url('simpan_config') ?>"
                                onsubmit="return showLoaderSweetalert2(this)">
                                <div class="row">
                                    <input class="form-control" type="hidden" id="id_kode" name="id"
                                        value="<?= base64_encode($this->encryption->encrypt($kode_satker->row()->id)) ?>" />
                                    <label for="kode_satker" class="form-label">KODE SATUAN KERJA</label>
                                    <div class="mb-3 col-md-10">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="kode_satker" name="app"
                                                value="<?= $kode_satker->row()->value ?>" />
                                        </div>
                                    </div>

                                    <div class="mb-3 col-md-2 col-sm-12 text-center">
                                        <button type="submit" class="btn btn-primary me-2">Simpan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="row">
                            <form id="formUser" method="POST" action="<?= site_url('simpan_config') ?>"
                                onsubmit="return showLoaderSweetalert2(this)">
                                <div class="row">
                                    <input class="form-control" type="hidden" id="id_nama" name="id"
                                        value="<?= base64_encode($this->encryption->encrypt($nama_satker->row()->id)) ?>" />
                                    <label for="nama_satker" class="form-label">NAMA SATUAN KERJA</label>
                                    <div class="mb-3 col-md-10">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="nama_satker" name="app"
                                                value="<?= $nama_satker->row()->value ?>" />
                                        </div>
                                    </div>

                                    <div class="mb-3 col-md-2 col-sm-12 text-center">
                                        <button type="submit" class="btn btn-primary me-2">Simpan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="row">
                            <form id="formUser" method="POST" action="<?= site_url('simpan_config') ?>"
                                onsubmit="return showLoaderSweetalert2(this)">
                                <div class="row">
                                    <input class="form-control" type="hidden" id="id_alamat" name="id"
                                        value="<?= base64_encode($this->encryption->encrypt($alamat_satker->row()->id)) ?>" />
                                    <label for="alamat_satker" class="form-label">ALAMAT SATUAN KERJA</label>
                                    <div class="mb-3 col-md-10">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="alamat_satker" name="app"
                                                value="<?= $alamat_satker->row()->value ?>" />
                                        </div>
                                    </div>

                                    <div class="mb-3 col-md-2 col-sm-12 text-center">
                                        <button type="submit" class="btn btn-primary me-2">Simpan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <form id="formUser" method="POST" action="<?= site_url('simpan_config') ?>"
                                    onsubmit="return showLoaderSweetalert2(this)" enctype="multipart/form-data">
                                    <div class="row mb-3">
                                        <label for="alamat_satker" class="form-label">LOGO SATUAN KERJA</label>
                                        <input class="form-control" type="hidden" id="id_logo" name="id"
                                            value="<?= base64_encode($this->encryption->encrypt($logo_satker->row()->id)) ?>" />
                                        <div class="d-flex align-items-start align-items-sm-center gap-4">
                                            <img src="<?= site_url('assets/dokumen/' . $logo_satker->row()->value); ?>"
                                                alt="user-avatar" class="d-block rounded" height="144" width="96"
                                                id="uploadedLogo" />
                                            <div class="button-wrapper">
                                                <label for="logo" class="btn btn-primary me-2 mb-4" tabindex="0">
                                                    <span class="d-none d-sm-block">Unggah Logo Lain</span>
                                                    <i class="bx bx-upload d-block d-sm-none"></i>
                                                </label>
                                                <input hidden type="file" id="logo" name="app"
                                                    class="account-file-input" accept="image/png" required />

                                                <p class="text-muted mb-0">Allowed PNG. Max size of 5 Mb</p>
                                                <button type="submit" class="btn btn-primary me-2">Simpan</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <form id="formUser" method="POST" action="<?= site_url('simpan_config') ?>"
                                    onsubmit="return showLoaderSweetalert2(this)" enctype="multipart/form-data">
                                    <div class="row mb-3">
                                        <label for="foto" class="form-label">FOTO SATUAN KERJA</label>
                                        <input class="form-control" type="hidden" id="id_foto" name="id"
                                            value="<?= base64_encode($this->encryption->encrypt($foto_satker->row()->id)) ?>" />
                                        <div class="d-flex align-items-start align-items-sm-center gap-4">
                                            <img src="<?= site_url('assets/dokumen/' . $foto_satker->row()->value); ?>"
                                                alt="user-avatar" class="d-block rounded" height="96" width="144"
                                                id="uploadedFoto" />
                                            <div class="button-wrapper">
                                                <label for="foto" class="btn btn-primary me-2 mb-4" tabindex="0">
                                                    <span class="d-none d-sm-block">Unggah Foto Lain</span>
                                                    <i class="bx bx-upload d-block d-sm-none"></i>
                                                </label>
                                                <input hidden type="file" id="foto" name="app"
                                                    class="account-file-input" accept="image/png" required />

                                                <p class="text-muted mb-0">Allowed PNG. Max size of 5 Mb</p>
                                                <button type="submit" class="btn btn-primary me-2">Simpan</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="row">
                            <form id="formUser" method="POST" action="<?= site_url('simpan_config') ?>"
                                onsubmit="return showLoaderSweetalert2(this)" enctype="multipart/form-data">
                                <div class="row mb-3">
                                    <label for="kop" class="form-label">KOP SURAT SATUAN KERJA</label>
                                    <input class="form-control" type="hidden" id="id_kop" name="id"
                                        value="<?= base64_encode($this->encryption->encrypt($kop_satker->row()->id)) ?>" />
                                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                                        <img src="<?= site_url('assets/dokumen/' . $kop_satker->row()->value); ?>"
                                            alt="user-avatar" class="d-block rounded" height="96" width="80%"
                                            id="uploadedKop" />
                                        <div class="button-wrapper">
                                            <label for="kop" class="btn btn-primary me-2 mb-4" tabindex="0">
                                                <span class="d-none d-sm-block">Unggah Kop Surat Lain</span>
                                                <i class="bx bx-upload d-block d-sm-none"></i>
                                            </label>
                                            <input hidden type="file" id="kop" name="app" class="account-file-input"
                                                accept="image/png" required />

                                            <p class="text-muted mb-0">Allowed PNG. Max size of 5 Mb</p>
                                            <button type="submit" class="btn btn-primary me-2">Simpan</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="row">
                            <form id="formUser" method="POST" action="<?= site_url('simpan_config') ?>"
                                onsubmit="return showLoaderSweetalert2(this)">
                                <div class="row">
                                    <input class="form-control" type="hidden" id="id_jam_mulai_apel_pagi" name="id"
                                        value="<?= base64_encode($this->encryption->encrypt($mulai_apel_senin->row()->id)) ?>" />
                                    <label for="mulai_apel_pagi" class="form-label">WAKTU MULAI PRESENSI APEL
                                        PAGI</label>
                                    <div class="mb-3 col-md-10">
                                        <div class="form-group">
                                            <input type="text" class="form-control timepicker" id="mulai_apel_pagi"
                                                name="app" value="<?= $mulai_apel_senin->row()->value ?>" />
                                        </div>
                                    </div>

                                    <div class="mb-3 col-md-2 col-sm-12 text-center">
                                        <button type="submit" class="btn btn-primary me-2">Simpan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="row">
                            <form id="formUser" method="POST" action="<?= site_url('simpan_config') ?>"
                                onsubmit="return showLoaderSweetalert2(this)">
                                <div class="row">
                                    <input class="form-control" type="hidden" id="id_jam_selesai_apel_pagi" name="id"
                                        value="<?= base64_encode($this->encryption->encrypt($selesai_apel_senin->row()->id)) ?>" />
                                    <label for="selesai_apel_pagi" class="form-label">WAKTU SELESAI PRESENSI APEL
                                        PAGI</label>
                                    <div class="mb-3 col-md-10">
                                        <div class="form-group">
                                            <input type="text" class="form-control timepicker" id="selesai_apel_pagi"
                                                name="app" value="<?= $selesai_apel_senin->row()->value ?>" />
                                        </div>
                                    </div>

                                    <div class="mb-3 col-md-2 col-sm-12 text-center">
                                        <button type="submit" class="btn btn-primary me-2">Simpan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="row">
                            <form id="formUser" method="POST" action="<?= site_url('simpan_config') ?>"
                                onsubmit="return showLoaderSweetalert2(this)">
                                <div class="row">
                                    <input class="form-control" type="hidden" id="id_jam_mulai_apel_sore" name="id"
                                        value="<?= base64_encode($this->encryption->encrypt($mulai_apel_jumat->row()->id)) ?>" />
                                    <label for="mulai_apel_sore" class="form-label">WAKTU MULAI PRESENSI APEL
                                        SORE</label>
                                    <div class="mb-3 col-md-10">
                                        <div class="form-group">
                                            <input type="text" class="form-control timepicker" id="mulai_apel_sore"
                                                name="app" value="<?= $mulai_apel_jumat->row()->value ?>" />
                                        </div>
                                    </div>

                                    <div class="mb-3 col-md-2 col-sm-12 text-center">
                                        <button type="submit" class="btn btn-primary me-2">Simpan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="row">
                            <form id="formUser" method="POST" action="<?= site_url('simpan_config') ?>"
                                onsubmit="return showLoaderSweetalert2(this)">
                                <div class="row">
                                    <input class="form-control" type="hidden" id="id_jam_selesai_apel_sore" name="id"
                                        value="<?= base64_encode($this->encryption->encrypt($selesai_apel_jumat->row()->id)) ?>" />
                                    <label for="selesai_apel_sore" class="form-label">WAKTU SELESAI PRESENSI APEL
                                        SORE</label>
                                    <div class="mb-3 col-md-10">
                                        <div class="form-group">
                                            <input type="text" class="form-control timepicker" id="selesai_apel_sore"
                                                name="app" value="<?= $selesai_apel_jumat->row()->value ?>" />
                                        </div>
                                    </div>

                                    <div class="mb-3 col-md-2 col-sm-12 text-center">
                                        <button type="submit" class="btn btn-primary me-2">Simpan</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="row">
                            <form id="formUser" method="POST" action="<?= site_url('simpan_config') ?>"
                                onsubmit="return showLoaderSweetalert2(this)">
                                <div class="row">
                                    <input class="form-control" type="hidden" id="id_ip_kantor" name="id"
                                        value="<?= base64_encode($this->encryption->encrypt($ip_kantor->row()->id)) ?>" />
                                    <label for="selesai_apel_sore" class="form-label">ALAMAT IP JARINGAN KANTOR</label>
                                    <div class="mb-3 col-md-10">
                                        <div class="form-group">
                                            <input type="text" class="form-control timepicker" id="selesai_apel_sore"
                                                name="app" value="<?= $ip_kantor->row()->value ?>" />
                                        </div>
                                    </div>

                                    <div class="mb-3 col-md-2 col-sm-12 text-center">
                                        <button type="submit" class="btn btn-primary me-2">Simpan</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                    <!-- /Account -->
                </div>
            </div>
        </div>
    </div>
    <!-- / Content -->

    <div class="content-backdrop fade"></div>
    <script>
        // Fungsi untuk menampilkan preview gambar
        function previewImage(input, imgElementId) {
            const file = input.files[0];
            const preview = document.getElementById(imgElementId);

            if (file) {
                const reader = new FileReader();
                reader.onload = function (event) {
                    preview.src = event.target.result; // Set src ke hasil pembacaan
                }
                reader.readAsDataURL(file); // Baca file sebagai URL data
            }
        }

        // Event listener untuk logo satker
        document.getElementById('logo').addEventListener('change', function () {
            previewImage(this, 'uploadedLogo'); // Menampilkan preview pada gambar pegawai
        });

        // Event listener untuk foto satker
        document.getElementById('foto').addEventListener('change', function () {
            previewImage(this, 'uploadedFoto'); // Menampilkan preview pada gambar tanda tangan
        });

        // Event listener untuk kop surat satker
        document.getElementById('kop').addEventListener('change', function () {
            previewImage(this, 'uploadedKop'); // Menampilkan preview pada gambar tanda tangan
        });
    </script>
</div>
<!-- Content wrapper -->
</div>
</div>
<div class="layout-overlay layout-menu-toggle"></div>
</div>