<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Pengaturan Akun /</span> Data User</h4>

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
                                <a class="nav-link active" href="javascript:void(0);"><i class="bx bx-bell me-1"></i>
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
                            <a class="nav-link" href="<?= site_url('app'); ?>" data-loader><i class="bx bx-wrench me-1"></i>
                                Pengaturan Aplikasi</a>
                        </li>
                        <?php
                    }
                    ?>
                </ul>

                <div class="card mb-4">
                    <h5 class="card-header">Detail Data User</h5>
                    <!-- Account -->

                    <div class="card-body">
                        <form id="formUser" method="POST" action="<?= site_url('simpan_data_user') ?>"
                            onsubmit="return showLoaderSweetalert2(this)">
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                                value="<?php echo $this->security->get_csrf_hash(); ?>">
                            <div class="row">
                                <input class="form-control" type="hidden" id="id" name="id"
                                    value="<?= base64_encode($this->encryption->encrypt($userid)) ?>" />
                                <div class="mb-3 col-md-6">
                                    <div class="form-group">
                                        <label for="password" class="form-label">Password</label>
                                        <div class="mb-3 form-password-toggle">
                                            <div class="input-group input-group-merge">
                                                <input type="password" id="password" class="form-control"
                                                    name="password" autocomplete="off"
                                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                                    aria-describedby="password" value="xxxx" />
                                                <span class="input-group-text cursor-pointer"><i
                                                        class="bx bx-hide"></i></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="passKonfirm" class="form-label">Konfirmasi Password</label>
                                        <div class="form-password-toggle">
                                            <div class="input-group input-group-merge">
                                                <input type="password" id="passKonfirm" class="form-control"
                                                    name="passKonfirm" autocomplete="off"
                                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                                    aria-describedby="password" value="xxxx" />
                                                <span class="input-group-text cursor-pointer"><i
                                                        class="bx bx-hide"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label class="form-label" for="atasan">Atasan Langsung</label>
                                    <select id="atasan" name="atasan" class="mb-3 select2 form-select">
                                        <option value="">Pilih Jabatan Atasan Langsung</option>
                                        <?php $no = 1;
                                        foreach ($atasan as $item1) {
                                            if ($atasan_id == $item1->id) {
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
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" autocomplete="off"
                                        value="<?= $email ?>" />
                                </div>
                            </div>
                            <div class="mt-2">
                                <button type="submit" class="btn btn-primary me-2">Simpan Perubahan</button>
                                <button type="reset" class="btn btn-outline-secondary">Cancel</button>
                            </div>
                        </form>
                    </div>
                    <!-- /Account -->
                </div>
            </div>
        </div>
    </div>
    <!-- / Content -->

    <div class="content-backdrop fade"></div>
</div>
<!-- Content wrapper -->
</div>
</div>
<div class="layout-overlay layout-menu-toggle"></div>
</div>