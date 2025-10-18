<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Pengaturan Akun /</span> Data Pegawai</h4>

        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-pills flex-column flex-md-row mb-3">
                    <?php
                    if ($userid != '1') {
                        if ($plh != '1') {
                            if ($plt != '1') {
                                ?>
                                <li class="nav-item">
                                    <a class="nav-link active" href="javascript:void(0);"><i class="bx bx-user me-1"></i>
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
                        <li class="nav-item">
                            <a class="nav-link" href="<?= site_url('app'); ?>" data-loader><i class="bx bx-wrench me-1"></i>
                                Pengaturan Aplikasi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= site_url('mpp'); ?>" data-loader><i class="bx bx-bell me-1"></i>
                                Pengaturan MPP</a>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
                <div class="card mb-4">
                    <h5 class="card-header">Detail Profil Pegawai</h5>
                    <!-- Account -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="foto" class="form-label">FOTO PEGAWAI (PNG)</label>
                                <div class="d-flex align-items-start align-items-sm-center gap-4">
                                    <img src="<?= $this->session->userdata('foto'); ?>" alt="user-avatar"
                                        class="d-block rounded" height="180" width="120" id="uploadedAvatar" />
                                    <div class="button-wrapper">
                                        <label for="foto" class="btn btn-primary me-2 mb-4" tabindex="0">
                                            <span class="d-none d-sm-block">Unggah Foto Lain</span>
                                            <i class="bx bx-upload d-block d-sm-none"></i>
                                        </label>

                                        <p class="text-muted mb-0">Allowed PNG. Max size of 5 Mb</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="ttd" class="form-label">TANDA TANGAN PEGAWAI (PNG)</label>
                                <div class="d-flex align-items-start align-items-sm-center gap-4">
                                    <img src="<?= $this->session->userdata('ttd'); ?>" alt="user-avatar"
                                        class="d-block rounded" height="180" width="120" id="uploadedSignature" />
                                    <div class="button-wrapper">
                                        <label for="ttd" class="btn btn-primary me-2 mb-4" tabindex="0">
                                            <span class="d-none d-sm-block">Unggah Tanda Tangan Lain</span>
                                            <i class="bx bx-upload d-block d-sm-none"></i>
                                        </label>

                                        <p class="text-muted mb-0">Allowed PNG. Max size of 5 Mb</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="my-0" />
                    <div class="card-body">
                        <form id="formAccountSettings" action="<?= site_url('simpan_data_profil') ?>" method="POST"
                            onsubmit="return showLoaderSweetalert2(this)" enctype="multipart/form-data">
                            <input hidden type="file" id="foto" name="foto" class="account-file-input"
                                accept="image/png" <?php if ($this->session->userdata('status_plh') == '1') { ?>readonly<?php } ?> />
                            <input hidden type="file" id="ttd" name="ttd" class="account-file-input"
                                accept="image/png" />
                            <div class="row">
                                <input class="form-control" type="hidden" id="id" name="id"
                                    value="<?= base64_encode($this->encryption->encrypt($id)) ?>" />

                                <div class="mb-3 col-md-6">
                                    <label for="nama_gelar" class="form-label">NAMA LENGKAP (DENGAN GELAR)</label>
                                    <input class="form-control" type="text" id="nama_gelar" name="nama_gelar"
                                        value="<?= $nama_gelar; ?>" autofocus autocomplete="off" />
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="nama" class="form-label">NAMA (TANPA GELAR)</label>
                                    <input class="form-control" type="text" name="nama" id="nama" value="<?= $nama ?>"
                                        autocomplete="off" />
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="nip" class="form-label">NIP</label>
                                    <input class="form-control" type="text" id="nip" name="nip" value="<?= $nip; ?>"
                                        placeholder="NIP" readonly />
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="jabatan" class="form-label">JABATAN</label>
                                    <select id="jabatan" name="jabatan" class="select2 form-select">
                                        <option value="">Pilih Jabatan</option>
                                        <?php $no = 1;
                                        foreach ($jabatan as $item1) {
                                            if ($jab_id == $item1->id) {
                                                ?>
                                                <option value="<?= $item1->id ?>" selected><?= $item1->nama_jabatan ?></option>
                                                <?php
                                            } else {
                                                ?>
                                                <option value="<?= $item1->id ?>"><?= $item1->nama_jabatan ?></option>
                                                <?php
                                            }
                                            ?>
                                        <?php }
                                        $no++; ?>
                                    </select>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label class="form-label" for="nohp">NOMOR HANDPHONE</label>
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text">IDN </span>
                                        <input type="text" id="nohp" name="nohp" class="form-control"
                                            placeholder="Nomor Handphone" value="<?= $nohp; ?>" autocomplete="off" />
                                    </div>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="alamat" class="form-label">ALAMAT</label>
                                    <input type="text" class="form-control" id="alamat" name="alamat"
                                        placeholder="Alamat" value="<?= $alamat; ?>" autocomplete="off" />
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="jk" class="form-label">JENIS KELAMIN</label>
                                    <select id="jk" name="jk" class="select2 form-select">
                                        <option value="">Pilih Jenis Kelamin Pegawai</option>
                                        <?php
                                        switch ($jk) {
                                            case '1':
                                                echo '<option value="1" selected>Pria</option>';
                                                echo '<option value="2">Wanita</option>';
                                                break;
                                            case '2':
                                                echo '<option value="1">Pria</option>';
                                                echo '<option value="2" selected>Wanita</option>';
                                                break;
                                            default:
                                                echo '<option value="1">Pria</option>';
                                                echo '<option value="2">Wanita</option>';
                                                break;
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label class="form-label" for="pangkat">PANGKAT | GOLONGAN</label>
                                    <select id="pangkat" name="pangkat" class="select2 form-select">
                                        <option value="">Pilih Pangkat</option>
                                        <?php $no = 1;
                                        foreach ($pangkat as $item2) {
                                            if ($gol_id == $item2->id) {
                                                ?>
                                                <option value="<?= $item2->id ?>" selected><?= $item2->golongan ?> |
                                                    <?= $item2->pangkat ?>
                                                </option>
                                                <?php
                                            } else {
                                                ?>
                                                <option value="<?= $item2->id ?>"><?= $item2->golongan ?> |
                                                    <?= $item2->pangkat ?>
                                                </option>
                                                <?php
                                            }
                                            ?>
                                        <?php }
                                        $no++; ?>
                                    </select>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="jenis" class="form-label">JENIS PEGAWAI</label>
                                    <select id="jenis" name="jenis" class="select2 form-select">
                                        <option value="">Pilih Jenis Pegawai</option>
                                        <?php
                                        switch ($id_grup) {
                                            case '1':
                                                echo '<option value="1" selected>Hakim</option>';
                                                echo '<option value="4">Calon Hakim</option>';
                                                echo '<option value="2">PNS</option>';
                                                echo '<option value="6">PPPK</option>';
                                                echo '<option value="3">Honorer</option>';
                                                echo '<option value="5">Operator</option>';
                                                break;
                                            case '2':
                                                echo '<option value="1">Hakim</option>';
                                                echo '<option value="4">Calon Hakim</option>';
                                                echo '<option value="2" selected>PNS</option>';
                                                echo '<option value="6">PPPK</option>';
                                                echo '<option value="3">Honorer</option>';
                                                echo '<option value="5">Operator</option>';
                                                break;
                                            case '3':
                                                echo '<option value="1">Hakim</option>';
                                                echo '<option value="4">Calon Hakim</option>';
                                                echo '<option value="2">PNS</option>';
                                                echo '<option value="6">PPPK</option>';
                                                echo '<option value="3" selected>Honorer</option>';
                                                echo '<option value="5">Operator</option>';
                                                break;
                                            case '4':
                                                echo '<option value="1">Hakim</option>';
                                                echo '<option value="4" selected>Calon Hakim</option>';
                                                echo '<option value="2">PNS</option>';
                                                echo '<option value="6">PPPK</option>';
                                                echo '<option value="3">Honorer</option>';
                                                echo '<option value="5">Operator</option>';
                                                break;
                                            case '5':
                                                echo '<option value="1">Hakim</option>';
                                                echo '<option value="4">Calon Hakim</option>';
                                                echo '<option value="2">PNS</option>';
                                                echo '<option value="6">PPPK</option>';
                                                echo '<option value="3">Honorer</option>';
                                                echo '<option value="5" selected>Operator</option>';
                                                break;
                                            case '6':
                                                echo '<option value="1">Hakim</option>';
                                                echo '<option value="4">Calon Hakim</option>';
                                                echo '<option value="2">PNS</option>';
                                                echo '<option value="6" selected>PPPK</option>';
                                                echo '<option value="3">Honorer</option>';
                                                echo '<option value="5">Operator</option>';
                                                break;
                                            default:
                                                echo '<option value="1">Hakim</option>';
                                                echo '<option value="4">Calon Hakim</option>';
                                                echo '<option value="2">PNS</option>';
                                                echo '<option value="6">PPPK</option>';
                                                echo '<option value="3">Honorer</option>';
                                                echo '<option value="5">Operator</option>';
                                                break;
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="tmt" class="form-label">TMT PEGAWAI</label>
                                    <input type="date" placeholder="Terhitung Mulai Tanggal Pegawai"
                                        class="form-control" id="tmt" name="tmt" value="<?= $tmt ?>">
                                </div>
                            </div>

                            <div class="mt-2">
                                <button type="submit" class="btn btn-primary me-2">Simpan Perubahan</button>
                                <button type="reset" class="btn btn-outline-secondary">Batal</button>
                            </div>
                        </form>
                    </div>
                    <!-- /Account -->
                </div>
            </div>
        </div>
    </div>
    <!-- / Content -->

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

        // Event listener untuk foto pegawai
        document.getElementById('foto').addEventListener('change', function () {
            previewImage(this, 'uploadedAvatar'); // Menampilkan preview pada gambar pegawai
        });

        // Event listener untuk tanda tangan pegawai
        document.getElementById('ttd').addEventListener('change', function () {
            previewImage(this, 'uploadedSignature'); // Menampilkan preview pada gambar tanda tangan
        });
    </script>

    <div class="content-backdrop fade"></div>
</div>
<!-- Content wrapper -->
</div>
</div>
<div class="layout-overlay layout-menu-toggle"></div>
</div>